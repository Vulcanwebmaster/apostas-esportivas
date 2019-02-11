<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 04/06/2017
 * Time: 19:09
 */

namespace app\models;


use app\core\Model;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\IndicacaoVO;
use app\vo\UserVO;

class IndicacoesModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_indicacoes';
        $this->valueObject = IndicacaoVO::class;
        $this->query = (new BuildQuery($this->table, 'a'))
            ->addInnerJoin(UsersModel::getTable(), 'indicado', 'indicado.id = a.indicado')
            ->addInnerJoin(UsersModel::getTable(), 'indicador', 'indicador.id = a.indicador');
    }

    /**
     * @param array $parans
     * @param int $page
     * @param int $perpage
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $perpage = 10)
    {
        $termos = 'WHERE a.status != 99';
        $places = [];
        $orderby = 'a.nivel ASC, indicado.nome ASC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case '_indicado':
                        case '_indicador':
                            if (is_array($value)) {
                                $values = $value;
                                $table = str_replace('_', '', $key);
                                foreach ($values as $key => $value) {
                                    if (!isEmpty($value) and !empty($key)) {
                                        switch ($key) {
                                            case 'dataInicio':
                                            case 'dataFim':
                                                $value = Date::data($value);
                                                if ($value) {
                                                    $sinal = $key == 'dataInicio' ? '>=' : '<=';
                                                    $termos .= " AND {$table}.datacadastro {$sinal} :{$key}";
                                                    $places[$key] = $value;
                                                }
                                                break;
                                            case 'datacadastro':
                                                $value = Date::data($value);
                                                if ($value) {
                                                    $termos .= " AND {$table}.{$key} = :{$key}";
                                                    $places[$key] = $value;
                                                }
                                                break;
                                            case 'type':
                                            case 'login':
                                            case 'status':
                                            case 'pagouplano':
                                            case 'type':
                                                $termos .= " AND {$table}.{$key} = :{$key}";
                                                $places[$key] = $value;
                                                break;
                                        }
                                    }
                                }
                            }
                            break;
                        case 'id':
                        case 'token':
                        case 'indicado':
                        case 'indicador':
                        case 'nivel':
                        case 'status':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $l = "LIKE CONCAT('%',:{$key},'%')";
                            $termos .= " AND (indicado.nome {$l} OR indicado.login = :{$key} OR indicado.cidadetitle {$l} OR indicado.email {$l})";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $perpage);
    }

    /**
     * @return IndicacaoVO
     */
    static function getIndicadorDireto(UserVO $user)
    {
        $termos = <<<SQL
WHERE a.indicado = :user AND a.nivel = 1 LIMIT 1
SQL;

        $places = [
            'user' => $user->getId(),
        ];

        return current(self::lista($termos, $places));
    }

    /**
     * @param UserVO $indicador
     * @param UserVO $indicado
     * @return IndicacaoVO[]
     */
    static function add(UserVO $indicador, UserVO $indicado)
    {

        if (!$indicado->getId()) {
            $indicado->save();
        }

        $indicacoes = [];
        $nivel = 1;

        while ($nivel <= 5 and $indicador) {

            /* @var IndicacaoVO $indicacao */
            $indicacao = self::newValueObject();

            $indicacao->setNivel($nivel);
            $indicacao->setIndicador($indicador->getId());
            $indicacao->setIndicado($indicado->getId());
            $indicacao->save();

            $indicacoes[] = $indicacao;

            $indicador = $indicador->voUser();
            $nivel++;
        }

        return $indicacoes;
    }

    /**
     * @param UserVO $user
     * @return IndicacaoVO[]
     */
    static function getIndicadores(UserVO $user)
    {
        return self::lista("WHERE a.indicado = :user AND a.status = 1", [
            'user' => $user->getId(),
        ]);
    }

    /**
     * @param UserVO $user
     * @param int $nivel
     * @param bool $emDia
     * @param bool $count
     * @return IndicacaoVO[]
     */
    static function getIndicados(UserVO $user, int $nivel = 0, bool $emDia = false, bool $count = false)
    {

        $termos = "a.indicador = :user AND a.status = 1";

        $places = [
            'user' => $user->getId(),
        ];

        # Nível
        if ($nivel > 0) {
            $termos .= "  AND (:nivel = 0 OR a.nivel = :nivel)";
            $places['nivel'] = $nivel;
        }

        # Em dia
        if ($emDia) {
            $termos .= " AND (indicado.pagouplano = 1 AND indicado.datavalidade AND indicado.datavalidade >= curdate())";
        }

        $query = clone self::getBuildQuery();

        $query->setWhere($termos);
        $query->setOrder('a.nivel ASC, a.insert ASC');

        return self::lista($termos, $places, $count);
    }

    /**
     * @param UserVO $user
     * @param int $nivel
     * @return array|null
     */
    static function getResumoIndicados(UserVO $user, int $nivel = 0)
    {

        $tbIndicados = self::getTable();
        $tbBanco = HistoricoBancarioModel::getTable();

        $termos = <<<SQL

SELECT 

  a.nivel, a.indicado, a.insert AS data,
  user.nome, user.login,
  SUM(IF(banco.type = 'credito' AND banco.reftype = 'indicacao', banco.valor, 0)) AS indicacao,
  SUM(IF(banco.type = 'credito' AND banco.reftype = 'apuracao', banco.valor, 0)) AS apuracao,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'indicacao', banco.valor, 0)) AS pontos,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'apostar', banco.valor, 0)) AS pontosAposta,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'comercializacao', banco.valor, 0)) AS pontosComercializacao

FROM `{$tbIndicados}` AS a

INNER JOIN `{$user->getTable()}` AS user ON user.id = a.indicado
LEFT JOIN `{$tbBanco}` AS banco ON banco.ref = :ref AND banco.refid = a.id

WHERE a.indicador = :user AND a.status = 1 AND (:nivel = 0 OR a.nivel = :nivel)

GROUP BY a.indicado

ORDER BY a.nivel ASC, a.insert ASC
SQL;

        $places = [
            'user' => $user->getId(),
            'ref' => $tbIndicados,
            'nivel' => $nivel,
        ];

        $result = self::pdoRead()->FullRead($termos, $places)->getResult();

        foreach ($result as &$v) {
            $v['ganhos'] = $v['apuracao'] + $v['indicacao'];
        }

        return $result;
    }

    /**
     * Retorna a contagem de indicações por nível
     * @param UserVO $user
     * @return array
     */
    static function getResumo(UserVO $user)
    {

        $result = [
            'total' => [
                'ganhos' => 0,
                'pontos' => 0,
                'pontosAposta' => 0,
                'pontosComercializacao' => 0,
                'indicados' => 0,
                'indicadosDiretos' => 0,
                'indicacao' => 0,
                'apuracao' => 0,
            ]
        ];

        $tbIndicacoes = self::getTable();
        $tbBanco = HistoricoBancarioModel::getTable();

        foreach (range(1, 5) as $nivel) {

            $termos = <<<SQL
SELECT 

  a.nivel,
  COUNT(DISTINCT a.id) AS indicados,
  SUM(IF(banco.type = 'credito' AND banco.reftype = 'indicacao', banco.valor, 0)) AS indicacao,
  SUM(IF(banco.type = 'credito' AND banco.reftype = 'apuracao', banco.valor, 0)) AS apuracao,
  SUM(IF(banco.type = 'pontos', banco.valor, 0)) AS pontos,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'apostar', banco.valor, 0)) AS pontosAposta,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'comercializacao', banco.valor, 0)) AS pontosComercializacao

FROM `{$tbIndicacoes}` AS a

LEFT JOIN `{$tbBanco}` AS banco ON banco.ref = :ref AND banco.refid = a.id

WHERE a.indicador = :user AND a.status = 1 AND a.nivel = :nivel

SQL;

            $places = [
                'user' => $user->getId(),
                'nivel' => $nivel,
                'ref' => $tbIndicacoes,
            ];

            $busca = current(self::pdoRead()->FullRead($termos, $places)->getResult());

            $result['niveis'][$nivel] = [
                'indicados' => (float)$busca['indicados'] ?? 0,
                'indicacao' => (float)$busca['indicacao'] ?? 0,
                'apuracao' => (float)$busca['apuracao'] ?? 0,
                'pontos' => (float)$busca['pontos'] ?? 0,
                'pontosAposta' => (float)$busca['pontosAposta'] ?? 0,
                'pontosComercializacao' => (float)$busca['pontosComercializacao'] ?? 0,
                'ganhos' => (float)($busca['indicacao'] ?? 0) + ($busca['apuracao'] ?? 0),
            ];

        }

        foreach ($result['niveis'] as $nivel => $values) {

            if ($nivel == 1) {
                $result['total']['indicadosDiretos'] = $values['indicados'];
            }

            foreach ($values as $key => $value) {
                $result['total'][$key] += $value;
            }

        }

        return $result;
    }

}
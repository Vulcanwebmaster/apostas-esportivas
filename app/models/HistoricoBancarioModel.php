<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 27/06/2017
 * Time: 17:38
 */

namespace app\models;


use app\core\Model;
use app\core\ValueObject;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Pagination;
use app\vo\HistoricoBancarioVO;
use app\vo\UserVO;

class HistoricoBancarioModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_historico_bancario';
        $this->valueObject = HistoricoBancarioVO::class;
        $this->query = new BuildQuery($this->table, 'a');
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $parans
     * @param int $page
     * @param int $forPage
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $forPage = 10)
    {
        $termos = 'WHERE a.status != 99';
        $places = [];
        $order = 'a.insert ASC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'horaInicial':
                        case 'horaFinal':
                            $sinal = $key == 'horaInicial' ? '>=' : '<=';
                            $termos .= " AND a.hora {$sinal} :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'valorMinimo':
                        case 'valorMaximo':
                            $sinal = $key == 'valorMinimo' ? '>=' : '<=';
                            $termos .= " AND a.valor {$sinal} :{$key}";
                            $places[$key] = Number::float($value, 2);
                            break;
                        case 'data':
                            $termos .= " AND a.data LIKE :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $termos .= " AND a.descricao LIKE CONCAT('%',:{$key},'%')";
                            $places[$key] = $value;
                            break;
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $termos .= " AND a.data " . ($key == 'dataFinal' ? '<' : '>') . "= :{$key}";
                                $places[$key] = $data;
                            }
                            break;
                        case 'id':
                        case 'status':
                        case 'ref':
                        case 'user':
                        case 'type':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }

        return self::listaPagination("{$termos} ORDER BY {$order}", $places, $page, $forPage);
    }

    /**
     * @param UserVO|null $user
     * @return HistoricoBancarioVO[]
     */
    static function getDuplicadas(UserVO $user = null, \DateTime $dateTime = null)
    {

        $query = self::getBuildQuery()
            ->setSelectFields([
                'a.*',
            ])
            ->setWhere('a.estornada = 0 AND (:user = 0 OR a.user = :user) AND (:data IS NULL OR a.data = :data)')
            ->setGroup([
                'a.user',
                'a.valor',
                'a.descricao',
                'a.estornada',
                'a.reftype',
                'a.type',
                'a.ref',
                'a.refid',
            ])
            ->setHaving('COUNT(a.id) > 1');


        $places = [
            'data' => $dateTime ? $dateTime->format('Y-m-d') : null,
            'user' => $user ? $user->getId() : 0,
        ];

        return self::lista($query, $places);

    }

    /**
     * @param UserVO $user
     * @return array[pontosRedes, pontosComercializacao, pontosTotal, creditosRede, creditosTotal]
     */
    static function getExtrato(UserVO $user)
    {

        $tbBanco = self::getTable();

        $termos = <<<SQL
SELECT 

  SUM(IF(a.type = 'pontos' AND a.ref = :ref, a.valor, 0)) AS pontosRede,
  SUM(IF(a.type = 'pontos' AND a.ref != :ref, a.valor, 0)) AS pontosComercializacao,
  SUM(IF(a.type = 'pontos', a.valor, 0)) AS pontosTotal,

  SUM(IF(a.type = 'credito' AND a.ref = :ref, a.valor, 0)) AS creditosRede,
  SUM(IF(a.type = 'credito', a.valor, 0)) AS creditosTotal

FROM `{$tbBanco}` AS a

WHERE a.user = :user AND a.status = 1
SQL;

        $places = [
            'ref' => IndicacoesModel::getTable(),
            'user' => $user->getId(),
        ];

        return current(self::pdoRead()->FullRead($termos, $places)->getResult());
    }

    /**
     * @param UserVO $user
     */
    static function getResumo(UserVO $user)
    {

        $tbBanco = self::getTable();

        $termos = <<<SQL
SELECT 

  SUM(IF(banco.type = 'pontos', banco.valor, 0)) AS pontos,
  SUM(IF(banco.type = 'credito', banco.valor, 0)) AS creditos,
  SUM(IF(banco.type = 'credito' AND banco.reftype = 'indicacao', banco.valor, 0)) AS creditosIndicacao,
  SUM(IF(banco.type = 'credito' AND banco.reftype = 'apuracao', banco.valor, 0)) AS creditosApuracao,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'apostar', banco.valor, 0)) AS pontosAposta,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'adesao', banco.valor, 0)) AS pontosAdesao,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'indicacao', banco.valor, 0)) AS pontosIndicacao,
  SUM(IF(banco.type = 'pontos' AND banco.reftype = 'comercializacao', banco.valor, 0)) AS pontosComercializacao

FROM `{$tbBanco}` AS banco

WHERE banco.user = :user AND banco.status = 1
SQL;

        $places = [
            'user' => $user->getId(),
        ];

        return current(self::pdoRead()->FullRead($termos, $places)->getResult());

    }

    /**
     * @param UserVO $user
     * @param float $valor
     * @param string $descricao
     * @param ValueObject|null $relacionado
     * @return HistoricoBancarioVO|null
     * @throws \Exception
     */
    static function add(UserVO $user, float $valor, string $descricao = "Créditos", ValueObject $relacionado = null, string $refType = null)
    {

        if ($valor == 0) {
            return null;
        }

        $saldo = self::getSaldo($user);

        /** @var HistoricoBancarioVO $historico */
        $historico = self::newValueObject();

        $historico->setUser($user->getId());
        $historico->setValor($valor);
        $historico->setDescricao($descricao);
        $historico->setSaldoCreditos($saldo['creditos'] + $valor);
        $historico->setRefType($refType);

        # Registro relacionado
        if ($relacionado) {
            $historico->setRef($relacionado->getTable());
            $historico->setRefId($relacionado->getId());
        }

        $historico->save();

        # Atualizando saldo do cliente
        $user->setCredito($historico->getSaldoCreditos());
        $user->save();

        return $historico;
    }

    /**
     * @param UserVO $user
     * @param \DateTime|null $data
     * @return array [user, pontos, creditos]
     */
    static function getSaldo(UserVO $user, \DateTime $data = null)
    {

        $tb = self::getTable();

        $termos = <<<SQL
SELECT
  
  SUM(IF(a.type = 'pontos', a.valor, 0)) AS pontos,
  SUM(IF(a.type = 'credito', a.valor, 0)) AS creditos
  
FROM
  `{$tb}` AS a

WHERE 
  a.status = 1 AND a.user = :user AND (:data IS NULL OR a.data <= :data)
SQL;

        $places = [
            'user' => $user->getId(),
            'data' => $data ? $data->format('Y-m-d') : null,
        ];

        $result = current(self::pdoRead()->FullRead($termos, $places)->getResult()) ?: [];

        return $result;

    }

}
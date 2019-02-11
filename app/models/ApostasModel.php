<?php

namespace app\models;

use app\core\crud\Conn;
use app\core\Model;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Pagination;
use app\helpers\Utils;
use app\vo\ApostaJogoVO;
use app\vo\ApostaVO;
use app\vo\IndicacaoVO;
use app\vo\JogoVO;
use app\vo\UserVO;

class ApostasModel extends Model
{

    const STATUS_ATIVA = 1;
    const STATUS_CANCELADA = 0;
    const STATUS_AGUARDANDO_PAGAMENTO = 2;
    const STATUS_NPAGA = 3;
    const STATUS_EXCLUIDA = 99;

    public function __construct()
    {
        $this->table = 'sis_apostas';
        $this->valueObject = ApostaVO::class;
        $this->query = (new BuildQuery($this->table, 'a'))
            ->addLeftJoin(UsersModel::getTable(), 'user', 'user.id = a.user');
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $parans
     * @param int $page
     * @param int $forpage
     * @param string $OrderBy
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $forpage = 10)
    {
        $termos = 'WHERE a.status != 99';

        $places = [];

        $orderby = 'a.insert DESC';

        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'situacao':
                            switch ($value) {
                                case 'ganhou':
                                    $termos .= " AND a.ganhou = 1";
                                    break;
                                case 'perdeu':
                                    $termos .= " AND a.erros > 0 AND a.status = 1";
                                    break;
                                case 'aguardando':
                                    $termos .= " AND a.erros = 0 AND a.verificado = 0 AND a.status = 1";
                                    break;
                                case 'cancelada':
                                    $termos .= " AND a.status = 0";
                                    break;
                                case 'possivel':
                                    $termos .= " AND a.verificado = 0 AND a.possivelganhador = 1 AND a.erros = 0 AND a.status = 1";
                                    break;
                            }
                            break;
                        case 'gerente':
                            $termos .= " AND (user.id = :{$key} OR user.user = :{$key})";
                            $places[$key] = $value;
                            break;
                        case 'ganhou':
                            $termos .= " AND a.ganhou = 1";
                            break;
                        case 'valorMinimo':
                        case 'valorMaximo':
                        case 'retornoMinimo':
                        case 'retornoMaximo':
                            $sinal = strpos($key, 'Minimo') !== false ? '>=' : '<=';
                            $field = strpos($key, 'retorno') !== false ? 'retornovalido' : 'valor';
                            $termos .= " AND a.{$field} {$sinal} :{$key}";
                            $places[$key] = Number::float($value, 2);
                            break;
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $termos .= " AND a.data " . ($key == 'dataFinal' ? '<' : '>') . "= :{$key}";
                                $places[$key] = $data;
                            }
                            break;
                        case 'apostadornome':
                            $l = "LIKE CONCAT('%',:{$key},'%')";
                            $termos .= " AND a.{$key} {$l}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $l = "LIKE CONCAT('%', :{$key}, '%')";
                            $termos .= " AND (user.nome {$l} OR user.email {$l} OR user.login = :{$key} OR user.cidadetitle {$l})";
                            $places[$key] = $value;
                            break;
                        case 'pago':
                        case 'user':
                        case 'casadinha':
                        case 'jogos':
                        case 'possivelganhador':
                        case 'verificado':
                        case 'id':
                        case 'status':
                        case 'ref':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }

        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $forpage);
    }

    /**
     * @param ApostaVO $aposta
     * @throws \Exception
     */
    public static function pagarComissoes(ApostaVO $aposta)
    {

        $user = $aposta->voUser();

        if ($user) {
            $graduacao = $user->voGraduacao();
            if ($graduacao) {

                $jogos = min(3, max(1, $aposta->getJogos()));
                $comissao = $graduacao->get('jogos' . $jogos);

                if ($comissao > 0) {

                    $comissaoValor = $aposta->getValor() * $comissao / 100;
                    HistoricoBancarioModel::add($user, $comissaoValor, "Comissão de `{$graduacao->getTitle()}` referente a aposta #{$aposta->getId()}", $aposta, 'comissao');

                    if ($gerente = $user->voUser() and $gerente->getComissao() > 0) {
                        $comissaoValor = $comissaoValor * $gerente->getComissao() / 100;
                        HistoricoBancarioModel::add($gerente, $comissaoValor, "Comissão de gerente referente a aposta #{$aposta->getId()}", $aposta, 'comissao');
                    }
                }
            }
        }
    }

    /**
     * Cancela o jogo da aposta
     * @param ApostaJogoVO $jogo
     * @throws \Exception
     */
    public static function cancelarJogo(ApostaJogoVO $jogo)
    {

        $aposta = $jogo->voAposta();
        $partida = $jogo->voJogo();

        if (!$aposta) {
            throw new \Exception("Aposta inválida");
        } else if (!$partida) {
            throw new \Exception("Partida inválida");
        } else if ($aposta->getJogos() == 1) {
            throw new \Exception("Não é possível cancelar o jogo de uma aposta com um uníco jogo");
        } else if (!$jogo->getIsEditavel()) {
            throw new \Exception("O jogo `{$partida->getDescricao()}` não pode mais ser cancelado da aposta.");
        }

        $aposta->setCotacao($aposta->getCotacao() / $jogo->getCotacaoValor());
        $aposta->setRetornoMaximo(min($aposta->getRetorno() * 0.9, $aposta->getRetornoMaximo() * 0.9));

        $termos = <<<SQL

-- Removendo o jogo
UPDATE 
    `{$jogo->getTable()}` AS a 
SET 
    a.status = 99
WHERE  
    a.id = {$jogo->getId()} AND a.status = 1 AND a.verificado = 0 
LIMIT 1;

-- Atualizando quantidade de jogos da aposta
UPDATE 
    `{$aposta->getTable()}` AS a 
SET 
    a.jogos = a.jogos - 1 
WHERE 
    a.id = {$aposta->getId()} 
LIMIT 1;

-- Verificando se a aposta foi verificada e atualizando a cotação
UPDATE 
    `{$aposta->getTable()}` AS a 
SET 
    a.cotacao = {$aposta->getCotacao()}, a.verificado = IF(a.jogos = a.jogosverificados, 1, 0),
    a.retorno = {$aposta->getRetorno()}, a.retornovalido = {$aposta->getRetornoValido()}, a.retornomaximo = {$aposta->getRetornoMaximo()}
WHERE 
    a.id = {$aposta->getId()}
LIMIT 1;

-- Verificando se a aposta está concluída
UPDATE
    `{$aposta->getTable()}` AS a
SET
    a.ganhou = IF(a.acertos = a.jogos, 1, 0),
    a.possivelganhador = IF(a.erros = 0 AND a.jogosverificados < a.jogos, 1, 0)
WHERE
    a.id = {$aposta->getId()}
LIMIT 1;
SQL;

        Conn::getConn()->exec($termos);
    }

    /**
     * @return string
     */
    public static function gerarCodigo()
    {
        $codigo = '';
        $tentativas = 10;

        while (!$codigo or self::lista('WHERE a.codigobilhete = :codigo LIMIT 1', ['codigo' => $codigo], true)) {
            $codigo = Utils::gerarCodigo(3 * 3, false, true, true);
            $tentativas--;
            if (!$tentativas) {
                throw new \Exception("Não foi possível gerar o código da aposta\n{$codigo}");
            }
        }

        return $codigo;
    }

    /**
     * @param ApostaVO $aposta
     * @return IndicacaoVO[]
     */
    public static function bonusComercializacao(ApostaVO $aposta)
    {

        $user = $aposta->voUser();
        $indicadores = IndicacoesModel::getIndicadores($user);

        if ($user->estaEmDia() and $licenca = $user->voLicenca()) {

            $comissao = DadosModel::getBonusComercializacao($user, $aposta->getNivelBonusComissao());

            if ($comissao > 0) {
                $comissao = $aposta->getValor() * $comissao / 100;
                $user->setComercializacao($user->getComercializacao() + $comissao);
                $user->save();
                HistoricoBancarioModel::add($user, $comissao, "<b>COMISSÃO</b> - Comissão de “Comercialização” da aposta (#{$aposta->getId()}) do usuário “{$user->getLogin()}”", $aposta, "comercializacao");
            }
        }

        return $indicadores;
    }

    /**
     * Retorna todoas as apostas contendo o jogo
     * @param JogoVO $jogo
     * @return ApostaVO[]
     */
    static function getApostasJogo(JogoVO $jogo)
    {

        $table = ApostaJogosModel::getTable();

        $termos = <<<SQL
INNER JOIN 
    `{$table}` AS jogo ON jogo.aposta = a.id AND jogo.jogo = :jogo

WHERE 
    a.status != 99 
SQL;

        return self::lista($termos, ['jogo' => $jogo->getId()]);
    }

    /**
     * Retorna o limite de apostas do jogo
     * @param ApostaJogoVO $jogo
     * @return float
     */
    static function limiteJogo(ApostaJogoVO $jogo)
    {
        $config = DadosModel::get();
        switch ($jogo->getJogos()) {
            case 1:
                return $jogo->voJogo()->getLimite1() ?: $config->getLimite1();
                break;
            case 2:
                return $jogo->voJogo()->getLimite2() ?: $config->getLimite2();
                break;
            default:
                return $jogo->voJogo()->getLimite3() ?: $config->getLimite3();
        }
    }

    /**
     * Retorna o total em apostas do jogo
     * @param ApostaJogoVO $jogo
     * @return float
     */
    static function valorTotalApostas(ApostaJogoVO $jogo)
    {

        switch ($jogo->getJogos()) {
            case 1:
                $query = 'a.jogos = 1';
                break;
            case 1:
                $query = 'a.jogos = 2';
                break;
            default:
                $query = 'a.jogos > 2';
        }

        $termos = "SELECT SUM(a.valor) AS total FROM `" . ApostaJogosModel::getTable() . "` AS a WHERE a.jogo = :jogo AND {$query} AND a.status = 1 GROUP BY a.jogo";
        $places = ['jogo' => $jogo->getJogo()];
        $total = Model::pdoRead()->FullRead($termos, $places)->getResult();

        return $total ? (float)$total[0]['total'] : 0;

    }

    /**
     * Retorna o total em apostas no dia
     * @param UserVO $user
     * @param date $data
     * @return float
     */
    static function totalDiario(string $data = null)
    {
        $total = Model::pdoRead()->FullRead("SELECT SUM(a.valor) AS total FROM `" . self::getTable() . "` AS a WHERE a.data = :data;", [
            'data' => $data ?: date('Y-m-d'),
        ])->getResult();

        return $total ? (float)$total[0]['total'] : 0;
    }

    /**
     * Desabilitando apostas que não receberam pagamento antes do jogo
     * @param JogoVO $jogo
     */
    static function desabilitaApostasSemPagamento(JogoVO $jogo)
    {
        $tbApostas = self::getTable();
        $tbApostasJogos = ApostaJogosModel::getTable();

        Conn::getConn()
            ->prepare("UPDATE `{$tbApostas}` AS a "
                . "INNER JOIN `{$tbApostasJogos}` AS b ON b.aposta = a.id AND b.jogo = :jogo "
                . "SET a.status = :npaga "
                . "WHERE a.status = :aguardando AND b.jogo = :jogo")
            ->execute([
                'aguardando' => ApostasModel::STATUS_AGUARDANDO_PAGAMENTO,
                'npaga' => ApostasModel::STATUS_NPAGA,
                'jogo' => $jogo->getId(),
            ]);
    }

}
    
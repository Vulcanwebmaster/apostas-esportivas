<?php

namespace app\models;

use app\core\crud\Conn;
use app\core\Model;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\ApostaJogoVO;
use app\vo\ApostaVO;
use app\vo\JogoVO;
use Exception;

class JogosModel extends Model
{

    const TEMPOS = [
        ['key' => '90', 'title' => 'Resultado final'],
        ['key' => 'pt', 'title' => 'Primeiro tempo'],
        ['key' => 'st', 'title' => 'Segundo tempo'],
    ];

    public function __construct()
    {
        $this->table = 'sis_jogos';
        $this->valueObject = JogoVO::class;
        $this->query = (new BuildQuery($this->table, 'a'))
            ->addInnerJoin(CampeonatosModel::getTable(), 'campeonato', 'campeonato.id = a.campeonato')
            ->addInnerJoin(TimesModel::getTable(), 'casa', 'casa.id = a.timecasa')
            ->addInnerJoin(TimesModel::getTable(), 'fora', 'fora.id = a.timefora');
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $parans
     * @param int $page
     * @param int $forPage
     * @param string $order
     * @return Pagination
     */
    public static function busca(array $parans = null, $page = 1, $forPage = 10, $order = 'default')
    {
        $termos = 'WHERE a.status != 99';
        $places = [];

        # Order By
        switch ($order) {
            case 'apostas':
                $orderBy = 'a.apostas DESC';
                break;
            default:
                $orderBy = 'a.data ASC, a.hora ASC';
        }

        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'disponivel':
                            $termos .= " AND (a.data > :hoje OR (a.data = :hoje AND a.hora >= :hora)) AND a.status = 1 ";
                            $places['hoje'] = date('Y-m-d');
                            $places['hora'] = date('H:i:s');
                            break;
                        case 'datacadastro':
                        case 'data':
                            if ($value = Date::data($value)) {
                                $termos .= " AND a.{$key} = :{$key}";
                                $places[$key] = $value;
                            }
                            break;
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $termos .= " AND a.data " . ($key == 'dataFinal' ? '<' : '>') . "= :{$key}";
                                $places[$key] = $data;
                            }
                            break;
                        case 'status':
                        case 'timecasa':
                        case 'timefora':
                        case 'campeonato':
                        case 'ref':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $l = "LIKE CONCAT('%',:{$key},'%')";
                            $termos .= " AND (casa.title {$l} OR fora.title {$l} OR campeonato.title {$l})";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderBy}", $places, $page, $forPage);
    }

    /**
     * Executa o cancelamento do jogo e das apostas associadas a ele
     * @param JogoVO $jogo
     * @throws Exception
     */
    public static function cancelar(JogoVO $jogo)
    {
        if ($jogo->getStatus() != 1) {
            throw new Exception("O jogo não pode mais ser excluído.");
        }

        $tbJogos = self::getTable();
        $tbApostaJogos = ApostaJogosModel::getTable();
        $tbApostas = ApostasModel::getTable();

        $termos = <<<SQL
UPDATE 
    `{$tbJogos}` AS partida, 
    `{$tbApostaJogos}` AS jogo,
    `{$tbApostas}` AS aposta

SET 
    -- Partida
    partida.status = 0,
    
    -- Jogo
    jogo.status = 0,

    -- Aposta
    aposta.retorno = aposta.cotacao / jogo.cotacaovalor * aposta.valor,
    aposta.retornovalido = LEAST(aposta.cotacao / jogo.cotacaovalor * aposta.valor, aposta.retornomaximo),
    aposta.cotacao = aposta.cotacao / jogo.cotacaovalor,
    aposta.status = IF(aposta.jogos = 1, 0, aposta.status),
    aposta.verificado = IF((aposta.jogos - 1) = (aposta.acertos + aposta.erros), 1, 0),
    aposta.ganhou = IF(aposta.acertos = (aposta.jogos - 1) AND aposta.erros = 0, 1, 0),
    aposta.possivelganhador = IF(aposta.possivelganhador = 1 AND aposta.acertos = (aposta.jogos - 1) AND aposta.erros = 0, 0, aposta.possivelganhador),
    aposta.jogos = aposta.jogos - 1
    
WHERE

    -- Partida
    partida.id = :partida AND partida.status = 1

    -- Jogo
    AND jogo.status = 1 AND jogo.jogo = partida.id AND jogo.verificado = 0
    
    -- Aposta
    AND aposta.id = jogo.aposta AND aposta.verificado = 0 AND aposta.status = 1;
SQL;

        $prepare = Conn::getConn()->prepare($termos);
        $prepare->execute(['partida' => $jogo->getId()]);

        if (!$prepare->rowCount()) {

            $jogo->setStatus(0);
            $jogo->save();

        } else {

            $termos = clone ApostasModel::getBuildQuery();
            $termos->addInnerJoin(ApostaJogosModel::getTable(), 'jogo', 'jogo.aposta = a.id AND jogo.jogo = :partida AND jogo.status = 0');
            $termos->setWhere('a.status = 0 AND a.jogos = 0');

            /** @var ApostaVO $aposta */
            foreach (ApostasModel::lista($termos, ['partida' => $jogo->getId()]) as $aposta) {
                HistoricoBancarioModel::add($aposta->voUser(), $aposta->getValor(), "Extorno da aposta #{$aposta->getId()} pelo cancelamento do jogo `{$jogo->getDescricao()}`", $jogo, 'extorno');
            }
        }

    }

    /**
     * Lista de jogos disponíveis
     * @return JogoVO[]
     */
    public static function getDisponiveis()
    {

        $termos = <<<SQL
WHERE a.status = 1 AND (a.data > :hoje OR (a.data = :hoje AND a.hora > :hora)) 
ORDER BY a.data ASC, campeonato.title ASC, a.hora ASC 
SQL;

        $places = [
            'hoje' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ];

        return self::lista($termos, $places, false, true, true);
    }

    /**
     * Incrementa aposta no jogo
     * @param ApostaJogoVO $jogo
     * @return boolean
     */
    public static function incAposta(ApostaJogoVO $jogo)
    {
        $tbJogos = self::getTable();
        $termos = <<<SQL
UPDATE `{$tbJogos}` AS a
SET a.apostas = a.apostas + 1, a.valorapostas = a.valorapostas + :valor 
WHERE a.id = :id LIMIT 1;
SQL;
        $prepare = Conn::getConn()->prepare($termos);
        $prepare->execute(['id' => $jogo->getJogo(), 'valor' => $jogo->getValor()]);
        return $prepare->rowCount() ? true : false;
    }

    /**
     * Retorna lista de jogos abertos
     * @param int $limite
     * @return JogoVO[]
     */
    public static function getJogosDia($limite = 15)
    {
        $termos = "WHERE a.status = 1 AND (a.data = :data AND a.hora > :hora OR a.data > :data) ORDER BY a.data ASC, a.hora ASC LIMIT :limit";
        $places = ['data' => date('Y-m-d'), 'hora' => date('H:i:s'), 'limit' => (int)$limite];
        return self::lista($termos, $places);
    }

    /**
     * Redefini o placar
     * @param JogoVO $jogo
     */
    public static function redefinirPlacar(JogoVO $jogo)
    {
        self::defazerResultadosApostas($jogo);
        self::definePlacar($jogo);
    }

    /**
     * Zera o placar de um jogo já encerrado
     * @param JogoVO $jogo
     */
    public static function defazerResultadosApostas(JogoVO $jogo)
    {
        if ($jogo->getStatus() != 2) {
            throw new Exception('O jogo não está encerrado');
        } else if ($jogo->getDataBaixa()) {
            throw new Exception('Jogo já teve baixa em ' . str_replace(' ', ' às ', $jogo->getDataBaixa(true)));
        } else {

            $tbApostas = ApostasModel::getTable();
            $tbApostaJogos = ApostaJogosModel::getTable();

            $query = <<<SQL
UPDATE `{$tbApostas}` AS aposta 

INNER JOIN `{$tbApostaJogos}` AS apostaJogo ON apostaJogo.aposta = aposta.id AND apostaJogo.verificado = 1 AND apostaJogo.status = 1

SET
    aposta.acertos = IF(apostaJogo.acertou = 1, aposta.acertos - 1, aposta.acertos),
    aposta.erros = IF(apostaJogo.acertou = 0, aposta.erros - 1, aposta.erros),
    aposta.jogosverificados = aposta.jogosverificados - 1,
    aposta.ganhou = 0,
    aposta.verificado = 0,
    aposta.status = 1,
    apostaJogo.verificado = 0,
    apostaJogo.acertou = 0,
    aposta.possivelganhador = if(aposta.jogosverificados > 1 AND (apostaJogo.acertou = 1 OR aposta.erros = 1), 1, 0)
    
WHERE apostaJogo.jogo = :jogo; 
SQL;

            $prepare = Conn::getConn()->prepare($query);
            $prepare->execute(['jogo' => $jogo->getId()]);

            $jogo->setStatus(1);
            $jogo->Save();
        }
    }

    /**
     * Define o placar do jogo
     * @param JogoVO $jogo
     * @throws Exception
     */
    public static function definePlacar(JogoVO $jogo)
    {

        # Já foi alterado ou excluído
        if ($jogo->getStatus() != 1) {
            throw new Exception("Não é possível alterar o placar do jogo.");
        }

        $jogo->save(['status' => 2]);

        return self::verificaApostasJogos($jogo);
    }

    /**
     * Busca e Verifica apostas do jogo
     * @param JogoVO $jogo
     */
    public static function verificaApostasJogos(JogoVO $jogo)
    {
        $tbApostas = ApostasModel::getTable();
        $tbApostasJogos = ApostaJogosModel::getTable();

        self::_verificaJogos($jogo);
        self::_verificaApostas($jogo);

        $termos = <<<SQL
SELECT 
SUM(1) AS jogos, 
SUM(IF(jogo.acertou = 1, 1, 0)) AS acertos, 
SUM(IF(jogo.acertou = 0, 1, 0)) AS erros, 
SUM(IF(aposta.erros > 0, 1, 0)) AS perdidas, 
SUM(IF(aposta.verificado = 1 AND aposta.ganhou = 1, 1, 0)) AS ganhas, 
SUM(IF(aposta.verificado = 0 AND aposta.erros = 0 AND aposta.acertos > 0, 1, 0)) AS possiveis 
FROM `{$tbApostas}` AS aposta, `{$tbApostasJogos}` AS jogo 
WHERE jogo.jogo = :jogo AND jogo.status = 1 AND jogo.aposta = aposta.id AND aposta.status = 1;
SQL;


        # Buscando os resultados
        return current(self::pdoRead()->FullRead($termos, ['jogo' => $jogo->getId()])->getResult());
    }

    /**
     * Verifica os jogos
     * @param JogoVO $jogo
     */
    private static function _verificaJogos(JogoVO $jogo)
    {
        $cotacoes = CotacoesModel::getCotacoesAtivas();
        $tbApostas = ApostasModel::getTable();
        $tbApostasJogos = ApostaJogosModel::getTable();
        $tbJogos = self::getTable();

        $places = ['jogo' => $jogo->getId()];

        foreach (['90' => '', 'pt' => 'primeiro', 'st' => 'segundo'] as $tempo => $replace) {

            $query = <<<SQL
UPDATE `{$tbApostasJogos}` AS apostaJogo, `{$tbApostas}` AS aposta, `{$tbJogos}` AS jogo 
SET apostaJogo.verificado = 1, apostaJogo.acertou = CASE apostaJogo.cotacaocampo 
SQL;

            # Cotações
            foreach ($cotacoes as $cotacao) {

                $key = 'cotacao' . $cotacao->getId();
                $places[$key] = $cotacao->getCampo();

                $condicao = $cotacao->getQuery();

                $condicao = str_replace([
                    '{timecasaplacar}',
                    '{timeforaplacar}',
                    '{ganhador}',
                    '{totalgols}',
                ], [
                    'timecasaplacar' . $replace,
                    'timeforaplacar' . $replace,
                    'ganhador' . $replace,
                    'totalgols' . $replace,
                ], $condicao);

                $query .= <<<SQL
WHEN :{$key} THEN IF({$condicao}, 1, 0)  
SQL;
            }
            $query .= "ELSE 0 END ";

            # Condições Gerais
            $query .= <<<SQL
WHERE jogo.id = :jogo AND apostaJogo.tempo = :tempo AND apostaJogo.status = 1 AND apostaJogo.jogo = jogo.id AND apostaJogo.verificado = 0 AND aposta.id = apostaJogo.aposta;
SQL;

            # Executando verificações das apostas
            Conn::getConn()->prepare($query)->execute(['tempo' => $tempo] + $places);

        }
    }

    /**
     * Verifica as apostas
     * @param JogoVO $jogo
     */
    private static function _verificaApostas(JogoVO $jogo)
    {
        $tbApostas = ApostasModel::getTable();
        $tbApostasJogos = ApostaJogosModel::getTable();
        $tbJogos = self::getTable();

        # Desabilitando apostas sem pagametno
        ApostasModel::desabilitaApostasSemPagamento($jogo);

        # Acertos/Erros
        $query = <<<SQL
UPDATE `{$tbApostasJogos}` AS apostaJogo, `{$tbApostas}` AS aposta, `{$tbJogos}` AS jogo 

SET 
    aposta.jogosverificados = aposta.jogosverificados + 1, 
    aposta.acertos = IF(apostaJogo.acertou = 1, aposta.acertos + 1, aposta.acertos), 
    aposta.erros = IF(apostaJogo.acertou = 1, aposta.erros, aposta.erros + 1) 

WHERE 
  jogo.id = :jogo AND apostaJogo.status = 1 AND 
  apostaJogo.jogo = jogo.id AND apostaJogo.verificado = 1 AND 
  aposta.id = apostaJogo.aposta AND aposta.status = 1;
SQL;

        Conn::getConn()->prepare($query)->execute(['jogo' => $jogo->getId()]);

        # Verificado/Ganhador
        $query = <<<SQL
UPDATE `{$tbApostasJogos}` AS apostaJogo, `{$tbApostas}` AS aposta, `{$tbJogos}` AS jogo 

SET 
    aposta.verificado = IF(aposta.jogosverificados >= aposta.jogos, 1, 0), 
    aposta.ganhou = IF(aposta.jogosverificados >= aposta.jogos AND aposta.erros = 0, 1, 0), 
    aposta.possivelganhador = IF(aposta.jogosverificados < aposta.jogos AND aposta.erros = 0 AND aposta.acertos > 0, 1, 0)

WHERE 
  jogo.id = :jogo AND apostaJogo.status = 1 AND 
  apostaJogo.jogo = jogo.id AND apostaJogo.verificado = 1 AND 
  aposta.id = apostaJogo.aposta AND aposta.status = 1; 
SQL;
        Conn::getConn()->prepare($query)->execute(['jogo' => $jogo->getId()]);
    }

    /**
     * @return array
     */
    public static function getResumoJogos()
    {

        $tb = self::getTable();

        $termos = <<<SQL
SELECT 

    COUNT(DISTINCT a.id) AS total,
    SUM(IF(a.data = :hoje, 1, 0)) AS hoje,
    SUM(IF(a.data BETWEEN :amanha AND :3dias, 1, 0)) AS 3dias

FROM `{$tb}` AS a

WHERE a.status = 1 AND (a.data > :hoje OR a.data = :hoje AND a.hora > :hora) ;
SQL;

        $places = [
            'hoje' => date('Y-m-d'),
            'amanha' => date('Y-m-d', strtotime('+1day')),
            'hora' => date('H:i:s'),
            '3dias' => date('Y-m-d', strtotime('+3days')),
        ];

        return current(self::pdoRead()->FullRead($termos, $places)->getResult());
    }

}
    
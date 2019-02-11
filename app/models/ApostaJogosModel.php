<?php

namespace app\models;

use app\core\Model;
use app\vo\ApostaJogoVO;
use app\vo\JogoVO;

class ApostaJogosModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_apostas_jogos';
        $this->valueObject = ApostaJogoVO::class;
        $this->query = "SELECT a.* "
            . "FROM `#table#` AS a "
            . "INNER JOIN `" . ApostasModel::getTable() . "` AS aposta ON aposta.id = a.aposta ";
    }

    /**
     * Retorna o numero de apostas do jogo por cotação
     * @param int|JogoVO $jogo
     * @return array
     */
    public static function cotacoesApostadasPorJogo($jogo)
    {
        $cotacoes = self::pdoRead()->FullRead("SELECT SUM(1) AS total, SUM(a.valor) AS valorTotal, a.tipo, a.cotacaocampo "
            . "FROM `" . self::getTable() . "` AS a FORCE INDEX (jogoTipo) "
            . "WHERE a.jogo = :jogo AND a.status = 1 "
            . "GROUP BY a.cotacaocampo ", [
            'jogo' => $jogo instanceof JogoVO ? $jogo->getId() : $jogo,
        ])->getResult();

        $result = [];
        foreach ($cotacoes as $key => $value) {
            $result[$value['tipo']] = [
                'total' => (int)$value['total'],
                'valor' => (float)$value['valorTotal'],
            ];
        }

        return $result;
    }

}
    
<?php

namespace app\models;

use app\core\Model;
use app\vo\CotacaoVO;

class CotacoesModel extends Model
{

    const GRUPOS = [
        1 => 'Resultado da partida',
        2 => 'Duplas',
        3 => 'Gol e Meio',
        4 => 'Placar exato',
        5 => 'Marcam',
        6 => 'Gols da partida',
        7 => 'Paridade',
        8 => 'Condições',
        9 => 'Intervalo / Final',
    ];

    public function __construct()
    {
        $this->table = 'sis_cotacoes';
        $this->valueObject = CotacaoVO::class;
    }

    /**
     * Retorna a lista de cotações ativas
     * @return CotacaoVO[]
     */
    public static function getCotacoesAtivas(string $orderby = 'a.grupo ASC, a.ordem ASC, a.titulo ASC')
    {
        static $_cotacoes_ativas = [];
        if (empty($_cotacoes_ativas[$orderby])) {
            $_cotacoes_ativas[$orderby] = self::lista("WHERE a.status = 1 AND a.query != '' ORDER BY {$orderby}", null, false, true, true);
        }
        return $_cotacoes_ativas[$orderby];
    }

    /**
     * Retorna a lista de todas as cotações do sistema
     * @return CotacaoVO[]
     */
    public static function getTodas()
    {
        return self::lista('WHERE a.status != 99 ORDER BY a.ordem ASC, a.titulo ASC', null, false, true, true);
    }

}
    
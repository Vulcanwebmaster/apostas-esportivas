<?php

namespace app\models;

use app\core\Model;
use app\helpers\Pagination;
use app\vo\TabelaOnlineVO;

class TabelasOnlineModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_tabelas_online';
        $this->valueObject = TabelaOnlineVO::class;
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $Paranmetros
     * @param int $CurrentPage
     * @param int $PorPagina
     * @param string $OrderBy
     * @return Pagination
     */
    static function busca(array $Paranmetros = null, $CurrentPage = 1, $PorPagina = 10)
    {
        $Termos = 'WHERE a.status != 99';
        $Places = [];
        $OrderBy = 'a.type ASC, a.title ASC';
        if ($Paranmetros) {
            foreach ($Paranmetros as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'id':
                        case 'type':
                        case 'status':
                            $Termos .= " AND a.{$key} = :{$key}";
                            $Places[$key] = $value;
                            break;
                        case 'search':
                            $l = "LIKE CONCAT('%',:{$key},'%')";
                            $Termos .= " AND a.title {$l}";
                            $Places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$Termos} ORDER BY {$OrderBy}", $Places, $CurrentPage, $PorPagina);
    }

}
    
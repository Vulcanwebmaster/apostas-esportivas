<?php

namespace app\models;

use app\core\Model;
use app\helpers\Pagination;
use app\vo\BibliotecaVO;

class BibliotecasModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_bibliotecas';
        $this->valueObject = BibliotecaVO::class;
    }

    /**
     * @param array $parans
     * @param int $page
     * @param int $forPage
     * @return Pagination
     */
    public static function busca(array $parans = null, $page = 1, $forPage = 10)
    {
        $termos = 'WHERE a.status != 99';
        $places = [];

        $orderBy = 'a.ordem ASC, a.title ASC';

        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'status':
                        case 'ref':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $l = "LIKE CONCAT('%',:{$key},'%')";
                            $termos .= " AND (a.title {$l})";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }

        return self::listaPagination("{$termos} ORDER BY {$orderBy}", $places, $page, $forPage);
    }

}
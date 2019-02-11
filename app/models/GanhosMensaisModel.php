<?php

namespace app\models;

use app\core\Model;
use app\helpers\Pagination;
use app\vo\GanhoMensalVO;

class GanhosMensaisModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_ganhos_mensais';
        $this->valueObject = GanhoMensalVO::class;
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
        $orderby = 'a.datafim DESC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'id':
                        case 'token':
                        case 'status':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $perpage);
    }

}
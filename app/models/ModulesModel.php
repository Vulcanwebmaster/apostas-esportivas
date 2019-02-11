<?php

namespace app\models;

use app\core\Model;
use app\helpers\Pagination;
use app\vo\ModuleVO;

class ModulesModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_modules';
        $this->valueObject = ModuleVO::class;
        $this->query = "SELECT a.* "
            . "FROM `#table#` AS a ";
    }

    static function options()
    {
        $html = '';
        foreach (self::Instance()->lista('WHERE a.status = 1 ORDER BY a.ordem ASC, a.uri ASC') as $v) {
            $html .= formOption($v->getTitle(), $v->getId());
        }
        return $html;
    }

    /**
     * Busca complexa
     * @param array $parans
     * @param int $page
     * @param int $forPage
     * @return Pagination
     */
    function busca(array $parans = null, $page = 1, $forPage = 20)
    {
        $termos = 'WHERE a.status != 99';
        $places = [];
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value)) {
                    switch ($key) {
                        case 'id':
                        case 'uri':
                        case 'status':
                            $termos = " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY a.ordem ASC, a.uri ASC", $places, $page, $forPage);
    }

}
    
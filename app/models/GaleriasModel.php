<?php

namespace app\models;

use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\models\helpers\OptionsModel;
use app\vo\GaleriaVO;

class GaleriasModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_galerias';
        $this->valueObject = GaleriaVO::class;
        $this->query = "SELECT a.* "
            . "FROM `#table#` AS a "
            . "INNER JOIN `" . OptionsModel::getTable() . "` AS categoria ON categoria.id = a.categoria ";
    }

    /**
     * Busca Complexa
     * @param array $Parans
     * @param int $CurrentPage
     * @param int $PorPagina
     * @return Pagination
     */
    function busca(array $Parans = null, $CurrentPage = 1, $PorPagina = 20)
    {
        $Termos = 'WHERE a.status != 99';
        $Places = [];
        $orderby = 'a.data DESC, a.insert DESC';
        if ($Parans) {
            foreach ($Parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'categoria':
                        case 'urlamigavel':
                        case 'status':
                        case 'ref':
                            $Termos .= " AND a.{$key} = :{$key}";
                            $Places[$key] = $value;
                            break;
                        case 'data':
                            $value = Date::data($value);
                            $Termos .= " AND a.{$key} = :{$key}";
                            $Places[$key] = $value;
                            break;
                        case 'orderby':
                            switch ($value) {
                                case 'categoria':
                                    $orderby = 'categoria.title ASC';
                                    break;
                                case 'title':
                                    $orderby = 'a.title ASC';
                                    break;
                                case 'data':
                                    $orderby = 'a.data ASC';
                                    break;
                            }
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$Termos} ORDER BY {$orderby}", $Places, $CurrentPage, $PorPagina);
    }

}
    
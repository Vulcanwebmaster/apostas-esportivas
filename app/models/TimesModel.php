<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 17/08/2017
 * Time: 12:15
 */

namespace app\models;


use app\core\Model;
use app\helpers\Pagination;
use app\vo\TimeVO;

class TimesModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_times';
        $this->valueObject = TimeVO::class;
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
        $orderby = 'a.title ASC';
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
                        case 'search':
                            $l = "LIKE CONCAT('%',:{$key},'%')";
                            $termos .= " AND a.title {$l}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $perpage);
    }

    /**
     * @return string
     */
    static function options()
    {
        $html = '';

        $query = clone self::getBuildQuery();
        $query->setSelectFields(['a.id', 'a.title']);
        $query->setWhere('a.status = 1');
        $query->setOrder(['a.title ASC']);

        foreach ($query->execute() as $v) {
            $html .= formOption($v['title'], $v['id']);
        }

        return $html;
    }

}
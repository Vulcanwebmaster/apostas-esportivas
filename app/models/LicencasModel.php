<?php

namespace app\models;

use app\core\Model;
use app\helpers\Pagination;
use app\vo\LicencaVO;

class LicencasModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_licencas';
        $this->valueObject = LicencaVO::class;
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

        $orderBy = 'a.ordem ASC, a.title ASC';

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
        return self::listaPagination("{$termos} ORDER BY {$orderBy}", $places, (int)$page, (int)$forPage);
    }

    /**
     * @return LicencaVO[]
     */
    public static function getLicencas(){
        return LicencasModel::lista('WHERE a.status = 1 ORDER BY a.ordem ASC');
    }

}
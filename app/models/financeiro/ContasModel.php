<?php

namespace app\models\financeiro;

use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\financeiro\ContaVO;

class ContasModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_financeiro_contas';
        $this->valueObject = ContaVO::class;
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
        $orderby = 'a.insert DESC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $sinal = $key == 'dataInicial' ? '>=' : '<=';
                                $termos .= " AND a.data {$sinal} :{$key}";
                                $places[$key] = $data;
                            }
                            break;
                        case 'id':
                        case 'token':
                        case 'user':
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
    
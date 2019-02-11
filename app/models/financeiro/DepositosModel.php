<?php

namespace app\models\financeiro;

use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\financeiro\DepositoVO;

class DepositosModel extends Model
{

    const STATUS_AGUARDANDO = 1;
    const STATUS_DESAPROVADO = 0;
    const STATUS_APROVADO = 2;

    const STATUS = [
        self::STATUS_AGUARDANDO => 'Em análise',
        self::STATUS_APROVADO => 'Aprovado',
        self::STATUS_DESAPROVADO => 'Rejeitado',
    ];

    function __construct()
    {
        $this->table = 'sis_depositos';
        $this->valueObject = DepositoVO::class;
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
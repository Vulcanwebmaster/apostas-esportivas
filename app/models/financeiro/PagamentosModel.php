<?php

namespace app\models\financeiro;

use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\financeiro\PagamentoVO;

class PagamentosModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_financeiro_pagamentos';
        $this->valueObject = PagamentoVO::class;
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
        $OrderBy = 'a.insert DESC';
        if ($Paranmetros) {
            foreach ($Paranmetros as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $Termos .= " AND a.data " . ($key == 'dataFinal' ? '<' : '>') . "= :{$key}";
                                $Places[$key] = $data;
                            }
                            break;
                        case 'id':
                        case 'token':
                        case 'descricao':
                        case 'pago':
                        case 'user':
                        case 'status':
                            $Termos .= " AND a.{$key} = :{$key}";
                            $Places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$Termos} ORDER BY {$OrderBy}", $Places, $CurrentPage, $PorPagina);
    }

}
    
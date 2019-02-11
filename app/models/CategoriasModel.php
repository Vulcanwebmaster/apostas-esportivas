<?php

namespace app\models;

use app\core\Model;
use app\helpers\Pagination;
use app\vo\CategoriaVO;

class CategoriasModel extends Model
{

    function __construct()
    {
        $this->table = 'sis_categorias';
        $this->valueObject = CategoriaVO::class;
    }

    /**
     *
     * @param string $ref
     * @param int $refid
     * @param string $default
     * @return string
     */
    static function options($ref, $refid = 0, $default = null, $root = 0, $nivel = 0)
    {
        $html = $default ? formOption($default) : null;
        $colors = ['#7f8c8d', '#16a085', '#2980b9', '#8e44ad', '#c0392b'];
        foreach (self::Instance()->lista("WHERE a.ref = :ref AND a.refid = :refid AND a.root = :root AND a.status = 1 ORDER BY a.ordem ASC, a.title ASC", ['ref' => $ref, 'root' => $root, 'refid' => $refid], false, true, true) as $v) {
            $html .= formOption(trim(str_pad('', $nivel * 2, '-') . ' ' . $v->getTitle()), $v->getId(), false, ['style' => 'color: ' . $colors[$nivel] . ';']);
            $html .= self::options($ref, $refid, null, $v->getId(), $nivel + 1);
        }
        return $html;
    }

    /**
     * Busca Complexa
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
                if (!isEmpty($value) and !is_int($key)) {
                    switch ($key) {
                        case 'ordem':
                        case 'root':
                        case 'ref':
                        case 'refid':
                        case 'status':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY a.ordem ASC, a.title ASC", $places, $page, $forPage);
    }

}
    
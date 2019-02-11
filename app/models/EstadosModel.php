<?php

namespace app\models;

use app\core\Model;
use app\vo\EstadoVO;

class EstadosModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_estados';
        $this->valueObject = EstadoVO::class;
    }

    /**
     * select.options
     * @param string $Label uf | title
     * @return string
     */
    static function options($Label = 'title', $Current = null, $optSelecione = true)
    {
        $html = $optSelecione ? formOption($Label == 'title' ? '-- Selecione --' : '- UF -', '') : '';
        $method = strtolower($Label) == 'title' ? 'getTitle' : 'getUF';
        foreach (self::Instance()->getEstados() as $v) {
            $html .= formOption($v->$method(), $v->getId(), in_array($Current, [$v->getId(), $v->getUf()]) ? true : false);
        }
        return $html;
    }

    /** @return EstadoVO */
    public function getEstados()
    {
        return $this->lista('ORDER BY a.title ASC', null, false, true, true);
    }

    /** @return EstadoVO|null */
    public function getEstado($idUf = null)
    {
        $busca = $this->lista('WHERE a.uf = :uf OR a.id = :uf LIMTI 1', ['uf' => $idUf]);
        return count($busca) ? $busca[0] : null;
    }

}
    
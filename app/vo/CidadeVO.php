<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\EstadosModel;

class CidadeVO extends ValueObject
{

    private $title;
    private $codigo;
    private $estado;

    /**
     * @return string
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param $codigo
     */
    function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    function getUf()
    {
        if ($this->voEstado())
            return $this->voEstado()->getUf();
    }

    /**
     * @return EstadoVO|null
     */
    function voEstado()
    {
        return EstadosModel::getByLabel('id', $this->getEstado());
    }

    /**
     * @return string
     */
    function getEstado()
    {
        return (int)$this->estado;
    }

    /**
     * @param int $estado
     */
    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    function getEstadoTitle()
    {
        if ($this->voEstado())
            return $this->voEstado()->getTitle();
    }

}
    
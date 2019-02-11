<?php

namespace app\traits\vo;

use app\models\CidadesModel;
use app\vo\CidadeVO;
use app\vo\EstadoVO;

trait cidade
{

    private $cidade;

    /** @return int */
    public function getEstado()
    {
        if ($this->voCidade())
            return $this->voCidade()->getEstado();
    }

    /** @return CidadeVO */
    public function voCidade()
    {
        return CidadesModel::getByLabel('id', $this->getCidade(), true);
    }

    /**
     * @return int
     */
    public function getCidade()
    {
        return (int)$this->cidade;
    }

    /**
     * @param string $cidade
     * @return $this
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

    /**
     * @return EstadoVO|null
     */
    public function voEstado()
    {
        if ($this->voCidade())
            return $this->voCidade()->voEstado();
    }

    public function checkCidade()
    {
        if (!$this->voCidade()) {
            throw new \Exception('Cidade inválida');
        }
    }

    /**
     * @return string
     */
    public function getEstadoTitle()
    {
        if ($this->voCidade())
            return $this->voCidade()->getEstadoTitle();
    }

    /**
     * @return string
     */
    public function getCidadeTitle()
    {
        if ($this->voCidade())
            return $this->voCidade()->getTitle();
    }

    /**
     * @return string
     */
    public function getUf()
    {
        if ($this->voCidade())
            return $this->voCidade()->getUf();
    }

}
    
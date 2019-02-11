<?php

namespace app\vo;

use app\core\ValueObject;
use app\helpers\Date;
use app\traits\vo\data;
use app\traits\vo\user;
use app\traits\vo\voRef;

class HistoricoBancarioVO extends ValueObject
{

    use user;
    use voRef;

    private $valor;
    private $saldoCreditos;
    private $descricao;
    private $estornada;

    /**
     * @return mixed
     */
    public function getEstornada()
    {
        return $this->estornada ? 1 : 0;
    }

    /**
     * @param mixed $estornada
     * @return $this
     */
    public function setEstornada($estornada)
    {
        $this->estornada = $estornada;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaldoCreditos($formatar = false)
    {
        return $this->formatValue($this->saldoCreditos, 'real', $formatar);
    }

    /**
     * @param mixed $saldoCreditos
     * @return $this
     */
    public function setSaldoCreditos($saldoCreditos)
    {
        $this->saldoCreditos = $saldoCreditos;
        return $this;
    }

    /**
     * @param bool $formatar
     * @return string
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $formatar);
    }

    /**
     * @return string
     */
    public function getHora()
    {
        return Date::time($this->getInsert());
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getValor($formatar = false)
    {
        return $this->formatValue($this->valor, 'real', $formatar);
    }

    /**
     * @param mixed $valor
     * @return $this
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     * @return $this
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

}
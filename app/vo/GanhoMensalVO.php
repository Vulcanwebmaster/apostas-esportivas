<?php

namespace app\vo;

use app\core\ValueObject;

class GanhoMensalVO extends ValueObject
{

    private $dataInicio;
    private $dataFim;
    private $valor;
    private $comissao;

    /**
     * @return mixed
     */
    public function getDataInicio($formatar = false)
    {
        return $this->formatValue($this->dataInicio, 'data', $formatar);
    }

    /**
     * @param mixed $dataInicio
     * @return $this
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataFim($formatar = false)
    {
        return $this->formatValue($this->dataFim, 'data', $formatar);
    }

    /**
     * @param mixed $dataFim
     * @return $this
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiquido($formatar = false)
    {
        return $this->formatValue($this->getValor() - $this->getComissao(), 'real', $formatar);
    }

    /**
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
    public function getComissao($formatar = false)
    {
        return $this->formatValue($this->comissao, 'real', $formatar);
    }

    /**
     * @param mixed $comissao
     * @return $this
     */
    public function setComissao($comissao)
    {
        $this->comissao = $comissao;
        return $this;
    }

}
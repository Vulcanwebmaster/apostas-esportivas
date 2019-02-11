<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\UsersModel;

class IndicacaoVO extends ValueObject
{

    private $nivel = 1;
    private $indicador;
    private $indicado;
    private $porcentagem;
    private $pontos;
    private $comercializacao;
    private $indicacao;

    /**
     * @param bool $formatar
     * @return string
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $formatar);
    }

    /**
     * @return mixed
     */
    public function getPontos($formatar = false)
    {
        return $this->formatValue($this->pontos, 'real', $formatar);
    }

    /**
     * @param mixed $pontos
     * @return $this
     */
    public function setPontos($pontos)
    {
        $this->pontos = $pontos;
        return $this;
    }

    public function getTotal($formatar = false)
    {
        return $this->formatValue($this->getComercializacao() + $this->getIndicacao(), 'real', $formatar);
    }

    /**
     * @return mixed
     */
    public function getComercializacao($formatar = false)
    {
        return $this->formatValue($this->comercializacao, 'real', $formatar);
    }

    /**
     * @param mixed $comercializacao
     * @return $this
     */
    public function setComercializacao($comercializacao)
    {
        $this->comercializacao = $comercializacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIndicacao($formatar = false)
    {
        return $this->formatValue($this->indicacao, 'real', $formatar);
    }

    /**
     * @param mixed $indicacao
     * @return $this
     */
    public function setIndicacao($indicacao)
    {
        $this->indicacao = $indicacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     * @return $this
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * @return UserVO|null
     */
    public function voIndicador()
    {
        return UsersModel::getByLabel('id', $this->getIndicador());
    }

    /**
     * @return mixed
     */
    public function getIndicador()
    {
        return $this->indicador;
    }

    /**
     * @param mixed $indicador
     * @return $this
     */
    public function setIndicador($indicador)
    {
        $this->indicador = $indicador;
        return $this;
    }

    /**
     * @return UserVO|null
     */
    public function voIndicado()
    {
        return UsersModel::getByLabel('id', $this->getIndicado());
    }

    /**
     * @return mixed
     */
    public function getIndicado()
    {
        return $this->indicado;
    }

    /**
     * @param mixed $indicado
     * @return $this
     */
    public function setIndicado($indicado)
    {
        $this->indicado = $indicado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPorcentagem()
    {
        return $this->porcentagem;
    }

    /**
     * @param mixed $porcentagem
     * @return $this
     */
    public function setPorcentagem($porcentagem)
    {
        $this->porcentagem = $porcentagem;
        return $this;
    }

}
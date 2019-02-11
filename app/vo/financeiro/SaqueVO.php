<?php

namespace app\vo\financeiro;

use app\core\ValueObject;
use app\models\financeiro\SaquesModel;
use app\traits\vo\cnpj;
use app\traits\vo\cpf;
use app\traits\vo\user;

class SaqueVO extends ValueObject
{

    use user;
    use cpf;
    use cnpj;

    private $tipo = 'banco';
    private $picpay;
    private $agencia;
    private $contaTipo;
    private $conta;
    private $banco;
    private $valor;
    private $taxa;
    private $nomeCompleto;
    private $variacao;

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicpay()
    {
        return $this->picpay;
    }

    /**
     * @param mixed $picpay
     * @return $this
     */
    public function setPicpay($picpay)
    {
        $this->picpay = $picpay;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContaTipo()
    {
        return $this->contaTipo;
    }

    /**
     * @param mixed $contaTipo
     * @return $this
     */
    public function setContaTipo($contaTipo)
    {
        $this->contaTipo = $contaTipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVariacao()
    {
        return $this->variacao;
    }

    /**
     * @param mixed $variacao
     * @return $this
     */
    public function setVariacao($variacao)
    {
        $this->variacao = $variacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxa($formatar = false)
    {
        return $this->formatValue($this->taxa, 'real', $formatar);
    }

    /**
     * @param mixed $taxa
     * @return $this
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;
        return $this;
    }

    public function check()
    {
        if (!$this->getCpf() and !$this->getCnpj()) {
            throw new \Exception('Informe o documento da conta');
        }
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $formatar);
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        return SaquesModel::STATUS[$this->getStatus()] ?? 'Inválido';
    }

    /**
     * @return mixed
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param mixed $agencia
     * @return $this
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param mixed $conta
     * @return $this
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param mixed $banco
     * @return $this
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
        return $this;
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
    public function getNomeCompleto()
    {
        return $this->nomeCompleto;
    }

    /**
     * @param mixed $nomeCompleto
     * @return $this
     */
    public function setNomeCompleto($nomeCompleto)
    {
        $this->nomeCompleto = $nomeCompleto;
        return $this;
    }

}
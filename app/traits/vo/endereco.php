<?php

namespace app\traits\vo;

use app\helpers\Mask;

trait endereco
{

    private $cep;
    private $logradouro;
    private $numero;
    private $bairro;
    private $complemento;

    /**
     * @return string
     */
    public function getEnderecoCompleto()
    {
        $endereco = '';

        foreach ([
                     'cep',
                     'logradouro',
                     'numero',
                     'complemento',
                 ] as $method) {
            $value = $this->get($method);

            if ($value) {
                if ($endereco) {
                    $endereco .= ', ';
                }
                $endereco .= $value;
            }
        }

        if (method_exists($this, 'getCidadeTitle')) {
            $endereco .= ", {$this->getCidadeTitle()}/{$this->getUf()}";
        }

        return $endereco;
    }

    /**
     * @return string
     */
    public function getCep()
    {
        return Mask::cep($this->cep);
    }

    /**
     * @param $cep
     * @return $this
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param $logradouro
     * @return $this
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param $numero
     * @return $this
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param $bairro
     * @return $this
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param $complemento
     * @return $this
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

}
    
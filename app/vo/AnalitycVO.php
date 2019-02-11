<?php

namespace app\vo;

use app\core\ValueObject;

class AnalitycVO extends ValueObject
{

    private $data;
    private $hora;
    private $tabela;
    private $ref;
    private $refId;
    private $ip;
    private $userAgent;
    private $navegador;
    private $sistemaOperacional;
    private $cidade;
    private $estado;
    private $uf;
    private $pais;

    public function getData($formatar = false)
    {
        return $this->formatValue($this->data ?: date('Y-m-d'), 'data', $formatar);
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getHora()
    {
        return $this->hora ?: date('H:i:s');
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }

    public function getTabela()
    {
        return $this->tabela;
    }

    public function setTabela($tabela)
    {
        $this->tabela = $tabela;
        return $this;
    }

    public function getRef()
    {
        return $this->ref;
    }

    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    public function getRefId()
    {
        return $this->refId;
    }

    public function setRefId($refId)
    {
        $this->refId = $refId;
        return $this;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    public function getNavegador()
    {
        return $this->navegador;
    }

    public function setNavegador($navegador)
    {
        $this->navegador = $navegador;
        return $this;
    }

    public function getSistemaOperacional()
    {
        return $this->sistemaOperacional;
    }

    public function setSistemaOperacional($sistemaOperacional)
    {
        $this->sistemaOperacional = $sistemaOperacional;
        return $this;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    public function getUf()
    {
        return $this->uf;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
        return $this;
    }

    public function getPais()
    {
        return $this->pais;
    }

    public function setPais($pais)
    {
        $this->pais = $pais;
        return $this;
    }

}
    
<?php

namespace app\vo;

use app\core\ValueObject;

class EstadoVO extends ValueObject
{

    private $Codigo;
    private $Title;
    private $Uf;
    private $Pais = 1;

    function getCodigo()
    {
        return $this->Codigo;
    }

    function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
    }

    function getTitle()
    {
        return $this->Title;
    }

    function setTitle($Title)
    {
        $this->Title = $Title;
    }

    function getUf()
    {
        return $this->Uf;
    }

    function setUf($Uf)
    {
        $this->Uf = $Uf;
    }

    function getPais()
    {
        return $this->Pais;
    }

    function setPais($Pais)
    {
        $this->Pais = $Pais;
    }

}
    
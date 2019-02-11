<?php

namespace app\vo;

use app\core\ValueObject;
use app\traits\vo\token;
use app\traits\vo\urlAmigavel;
use Exception;

class CategoriaVO extends ValueObject
{

    use token,
        urlAmigavel;

    private $Ordem;
    private $Ref;
    private $RefId;
    private $Icone;
    private $Root;
    private $Title;
    private $Descricao;

    function getOrdem()
    {
        return (int)$this->Ordem;
    }

    function setOrdem($Ordem)
    {
        $this->Ordem = $Ordem;
    }

    function getRef()
    {
        return $this->Ref;
    }

    function setRef($Ref)
    {
        $this->Ref = $Ref;
    }

    function getRefId()
    {
        return (int)$this->RefId;
    }

    function setRefId($RefId)
    {
        $this->RefId = $RefId;
    }

    function getIcone()
    {
        return $this->Icone;
    }

    function setIcone($Icone)
    {
        $this->Icone = $Icone;
    }

    function getTitle()
    {
        return $this->Title;
    }

    function setTitle($Title)
    {
        $this->Title = $Title;
    }

    function getDescricao()
    {
        return $this->Descricao;
    }

    function setDescricao($Descricao)
    {
        $this->Descricao = $Descricao;
    }

    function check()
    {
        if ($this->getId() and $this->getId() == $this->getRoot()) {
            throw new Exception('Categoria não pode ser root dela mesma.');
        }
        if ($this->getRoot() and !$this->voRoot()) {
            throw new Exception('Root inválido.');
        }
    }

    function getRoot()
    {
        return (int)$this->Root;
    }

    function setRoot($Root)
    {
        $this->Root = $Root;
    }

    /** @return CategoriaVO */
    function voRoot()
    {
        return $this->voModel()->getByLabel('id', $this->getRoot());
    }

}
    
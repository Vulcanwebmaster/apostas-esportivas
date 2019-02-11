<?php

namespace app\vo;

use app\core\ValueObject;
use Exception;

class UserTypeVO extends ValueObject
{

    private $Ref;
    private $Title;
    private $Permissoes;

    function getPermissoes($inArray = false)
    {
        return $inArray ? stringToArray($this->Permissoes) : arrayToString($this->Permissoes);
    }

    function setPermissoes($Permissoes)
    {
        $this->Permissoes = $Permissoes;
    }

    function check()
    {
        if (!$this->getRef()) {
            $this->Ref = $this->getTitle();
        } else if ($this->voModel()->lista('WHERE a.ref = :ref ANd a.id != :id LIMIT 1', ['ref' => $this->getRef(), 'id' => $this->getId()])) {
            throw new Exception('Referência duplicada.');
        }
    }

    function getRef()
    {
        return url_paranformat((string)$this->Ref);
    }

    function setRef($Ref)
    {
        $this->Ref = $Ref;
    }

    function getTitle()
    {
        return $this->Title;
    }

    function setTitle($Title)
    {
        $this->Title = $Title;
    }

}
    
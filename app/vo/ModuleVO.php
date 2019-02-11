<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\UsersTypesModel;
use Exception;

class ModuleVO extends ValueObject
{

    private $Ordem = 1;
    private $URI;
    private $Icone;
    private $Title;
    private $Cor1;
    private $Cor2;
    private $Permissoes;

    function getOrdem()
    {
        return (int)$this->Ordem;
    }

    function setOrdem($Ordem)
    {
        $this->Ordem = $Ordem;
    }

    function getIcone()
    {
        return $this->Icone;
    }

    function setIcone($Icone)
    {
        $this->Icone = $Icone;
    }

    function getCor1()
    {
        return $this->Cor1;
    }

    function setCor1($Cor1)
    {
        $this->Cor1 = $Cor1;
    }

    function getCor2()
    {
        return $this->Cor2;
    }

    function setCor2($Cor2)
    {
        $this->Cor2 = $Cor2;
    }

    function getPermissoesTitles()
    {
        $permissoes = $this->getPermissoes(true);
        if (!$permissoes) {
            return '<i class="fa fa-warning" ></i> Sem permissões';
        }

        $html = '';
        foreach ($permissoes as $id) {
            if ($v = UsersTypesModel::Instance()->getByLabel('id', $id)) {
                $html .= $v->getTitle() . ', ';
            }
        }
        return substr($html, 0, -2);
    }

    function getPermissoes($toArray = false)
    {
        return $this->formatValue($this->Permissoes, 'array', $toArray);
    }

    function setPermissoes($Permissoes)
    {
        $this->Permissoes = $Permissoes;
    }

    function check()
    {

        if (!$this->getURI()) {
            throw new Exception('Informe a URI.');
        } else if (!$this->getTitle()) {
            throw new Exception('Informe o título do módulo.');
        }
    }

    function getURI()
    {
        return url_paranformat((string)$this->URI);
    }

    function setURI($URI)
    {
        $this->URI = $URI;
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
    
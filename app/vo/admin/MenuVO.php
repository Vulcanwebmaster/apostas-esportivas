<?php

namespace app\vo\admin;

use app\core\ValueObject;
use app\models\ModulesModel;
use app\models\UsersTypesModel;
use app\vo\ModuleVO;
use Exception;

class MenuVO extends ValueObject
{

    private $Module;
    private $ModuleURI;
    private $ModuleTitle;
    private $Root;
    private $Ordem;
    private $Title;
    private $Legenda;
    private $Arquivo;
    private $Controller;
    private $Variaveis;
    private $OnClick;
    private $Class;
    private $Icone;
    private $Manual;
    private $Permissoes;
    private $Principal;

    function getModuleTitle()
    {
        return $this->ModuleTitle;
    }

    function setModuleTitle($ModuleTitle)
    {
        $this->ModuleTitle = $ModuleTitle;
    }

    function getModuleURI()
    {
        return $this->ModuleURI;
    }

    function setModuleURI($ModuleURI)
    {
        $this->ModuleURI = $ModuleURI;
    }

    function getOrdem()
    {
        return (int)$this->Ordem;
    }

    function setOrdem($Ordem)
    {
        $this->Ordem = $Ordem;
    }

    function getTitle()
    {
        return $this->Title;
    }

    function setTitle($Title)
    {
        $this->Title = $Title;
    }

    function getLegenda()
    {
        return $this->Legenda;
    }

    function setLegenda($Legenda)
    {
        $this->Legenda = $Legenda;
    }

    function getArquivo()
    {
        return $this->Arquivo;
    }

    function setArquivo($Arquivo)
    {
        $this->Arquivo = $Arquivo;
    }

    function getController()
    {
        return $this->Controller;
    }

    function setController($Controller)
    {
        $this->Controller = $Controller;
    }

    function getVariaveis($toArray = false)
    {
        if ($toArray) {
            if (!is_array($this->Variaveis)) {
                parse_str($this->Variaveis, $vars);
                return $vars;
            } else {
                return $this->Variaveis;
            }
        } else {
            if (is_array($this->Variaveis)) {
                return http_build_query($this->Variaveis);
            } else {
                return $this->Variaveis;
            }
        }
    }

    function setVariaveis($Variaveis)
    {
        $this->Variaveis = $Variaveis;
    }

    function getOnClick()
    {
        return $this->OnClick;
    }

    function setOnClick($OnClick)
    {
        $this->OnClick = $OnClick;
    }

    function getClass()
    {
        return $this->Class;
    }

    function setClass($Class)
    {
        $this->Class = $Class;
    }

    function getIcone()
    {
        return $this->Icone;
    }

    function setIcone($Icone)
    {
        $this->Icone = $Icone;
    }

    function getManual()
    {
        return $this->Manual;
    }

    function setManual($Manual)
    {
        $this->Manual = $Manual;
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
        $this->Permissoes = stringToArray($Permissoes);
    }

    function getPrincipal()
    {
        return (int)$this->Principal;
    }

    function setPrincipal($Principal)
    {
        $this->Principal = $Principal;
    }

    function check()
    {

        # Root
        if ($this->getRoot()) {
            if (!$root = $this->voRoot()) {
                throw new Exception('Root inválido.');
            } else {
                $this->Module = $root->getModule();
            }
        }

        # Módulo
        if (!$this->voModule()) {
            throw new Exception('Módulo inválido.');
        }

        # Verificando parentesco
        if ($this->getId() && $this->getId() == $this->getRoot()) {
            throw new Exception('O menu não pode ser root dele mesmo.');
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

    /** @return MenuVO */
    function voRoot()
    {
        return $this->voModel()->getByLabel('id', $this->getRoot());
    }

    function getModule()
    {
        if ($this->getRoot() and $root = $this->voRoot()) {
            return $root->getModule();
        }
        return (int)$this->Module;
    }

    function setModule($Module)
    {
        $this->Module = $Module;
    }

    /** @return ModuleVO */
    function voModule()
    {
        return ModulesModel::Instance()->getByLabel('id', $this->getModule());
    }

}
    
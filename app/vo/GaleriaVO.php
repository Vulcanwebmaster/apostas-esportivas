<?php

namespace app\vo;

use app\core\ValueObject;
use app\helpers\Utils;
use app\models\CategoriasModel;
use app\vo\helpers\OptionVO;
use Exception;

class GaleriaVO extends ValueObject
{

    private $UrlAmigavel;
    private $Ref;
    private $Categoria;
    private $Data;
    private $Title;
    private $Texto;
    private $Descricao;
    private $Keywords;

    function getRef()
    {
        return $this->Ref;
    }

    function setRef($Ref)
    {
        $this->Ref = $Ref;
    }

    function getData($formatar = false)
    {
        return $this->formatValue($this->Data, 'data', $formatar);
    }

    function setData($Data)
    {
        $this->Data = $Data;
    }

    function getTexto()
    {
        return $this->Texto;
    }

    function setTexto($Texto)
    {
        $this->Texto = $Texto;
    }

    function getDescricao()
    {
        return $this->Descricao;
    }

    function setDescricao($Descricao)
    {
        $this->Descricao = $Descricao;
    }

    function getKeywords()
    {
        return $this->Keywords;
    }

    function setKeywords($Keywords)
    {
        $this->Keywords = $Keywords;
    }

    function check()
    {
        if (!$this->voCategoria()) {
            throw new Exception('Categoria inválida.');
        }
        if (!$this->getTitle()) {
            throw new Exception('Informe o título da galeria.');
        } else if (!$this->getId()) {
            $this->UrlAmigavel = $this->getTitle();
        }

        while ($this->voModel()->lista('WHERE a.urlamigavel = :url AND a.id != :id AND a.status != 99 LIMIT 1', ['url' => $this->getUrlAmigavel(), 'id' => $this->getId()])) {
            $this->UrlAmigavel = $this->getTitle() . '-' . Utils::gerarCodigo(5, false, true, false, false);
        }
    }

    /** @return OptionVO */
    function voCategoria()
    {
        return CategoriasModel::Instance()->getByLabel('id', $this->getCategoria());
    }

    function getCategoria()
    {
        return (int)$this->Categoria;
    }

    function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
    }

    function getTitle()
    {
        return $this->Title;
    }

    function setTitle($Title)
    {
        $this->Title = $Title;
    }

    function getUrlAmigavel()
    {
        return url_paranformat((string)$this->UrlAmigavel);
    }

    function setUrlAmigavel($UrlAmigavel)
    {
        $this->UrlAmigavel = $UrlAmigavel;
    }

}
    
<?php

namespace app\vo\helpers;

use app\core\ValueObject;

class PaginaVO extends ValueObject
{

    protected $ref;
    protected $refId;
    protected $link;
    protected $title;
    protected $texto;
    protected $descricao;
    protected $keywords;
    protected $ordem;

    /**
     * @return mixed
     */
    function getRef()
    {
        return $this->ref;
    }

    /**
     * @param $ref
     * @return $this
     */
    function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @return mixed
     */
    function getRefId()
    {
        return $this->refId;
    }

    /**
     * @param $refId
     * @return $this
     */
    function setRefId($refId)
    {
        $this->refId = $refId;
        return $this;
    }

    /**
     * @return mixed
     */
    function getLink()
    {
        return $this->link;
    }

    /**
     * @param $link
     * @return $this
     */
    function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param $texto
     * @return $this
     */
    function setTexto($texto)
    {
        $this->texto = $texto;
        return $this;
    }

    /**
     * @return mixed
     */
    function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param $descricao
     * @return $this
     */
    function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return mixed
     */
    function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param $keywords
     * @return $this
     */
    function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return int
     */
    function getOrdem()
    {
        return (int)$this->ordem;
    }

    /**
     * @param $ordem
     * @return $this
     */
    function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

}
    
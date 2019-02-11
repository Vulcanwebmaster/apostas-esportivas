<?php

namespace app\vo\helpers;

use app\core\ValueObject;

class BannerVO extends ValueObject
{

    private $ref;
    private $title;
    private $subTitle;
    private $legenda;
    private $linkTitle;
    private $linkUrl;
    private $linkTarget;
    private $inicio;
    private $fim;
    private $dias;
    private $ordem;
    private $video;
    private $posicao = 'bg-center';
    private $texto;

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     * @return $this
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
        return $this;
    }

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
    public function setRef($ref)
    {
        $this->ref = $ref;
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
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * @param $subTitle
     * @return $this
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    function getLegenda()
    {
        return $this->legenda;
    }

    /**
     * @param $legenda
     * @return $this
     */
    public function setLegenda($legenda)
    {
        $this->legenda = $legenda;
        return $this;
    }

    /**
     * @return mixed
     */
    function getLinkTitle()
    {
        return $this->linkTitle;
    }

    /**
     * @param $linkTitle
     * @return $this
     */
    public function setLinkTitle($linkTitle)
    {
        $this->linkTitle = $linkTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * @param $linkUrl
     * @return $this
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    function getLinkTarget()
    {
        return $this->linkTarget;
    }

    /**
     * @param $linkTarget
     * @return $this
     */
    public function setLinkTarget($linkTarget)
    {
        $this->linkTarget = $linkTarget;
        return $this;
    }

    /**
     * @param bool $format
     * @return mixed
     */
    function getInicio($format = false)
    {
        return $this->formatValue($this->inicio, 'date', $format);
    }

    /**
     * @param $inicio
     * @return $this
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
        return $this;
    }

    /**
     * @param bool $format
     * @return mixed
     */
    function getFim($format = false)
    {
        return $this->formatValue($this->fim, 'date', $format);
    }

    /**
     * @param $fim
     * @return $this
     */
    public function setFim($fim)
    {
        $this->fim = $fim;
        return $this;
    }

    /**
     * @param bool $toArray
     * @return mixed
     */
    function getDias($toArray = false)
    {
        if (!$this->dias or strpos($this->dias, '*') !== false) {
            $this->dias = '[0][1][2][3][4][5][6]';
        }
        return $this->formatValue($this->dias, 'array', $toArray);
    }

    /**
     * @param $dias
     * @return $this
     */
    public function setDias($dias)
    {
        if (is_array($dias)) {
            $dias = arrayToString($dias);
        }
        $this->dias = $dias;
        return $this;
    }

    /**
     * @return mixed
     */
    function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * @param $ordem
     * @return $this
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param $video
     * @return $this
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * @param $posicao
     * @return $this
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
        return $this;
    }

}
    
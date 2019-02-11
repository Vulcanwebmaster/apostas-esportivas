<?php

namespace app\vo\helpers;

use app\core\ValueObject;
use app\helpers\STR;

class ImageVO extends ValueObject
{

    private $Ref;
    private $RefId;
    private $Title;
    private $Legenda;
    private $Source;
    private $DefaultSource = 'default.jpg';
    private $Position;

    /**
     *
     * @param int $Width
     * @param int $Height
     * @param string $ResizeType preenchimento | crop | proporcional | normal
     * @param int $Quality
     * @param STR|int $BGColor
     * @return string
     */
    function redimensiona($Width, $Height, $ResizeType = 'crop', $Quality = 100, $BGColor = '#FFFFFF')
    {
        return url('img', [$Width, $Height, $ResizeType, $Quality], 'cdn') . '/' . $this->getSource();
    }

    /**
     * @param bool $Host
     * @return string
     */
    function getSource($Host = false)
    {
        if ($Host and !file_exists(abs_source_images($this->getSource()))) {
            $this->Source = $this->getDefaultSource();
        }
        return $Host ? base_url_images($this->Source) : $this->Source;
    }

    /**
     * @param $Source
     * @return $this
     */
    function setSource($Source)
    {
        $this->Source = $Source;
        return $this;
    }

    /**
     * @return string
     */
    function getDefaultSource()
    {
        return $this->DefaultSource;
    }

    /**
     * @param $DefaultSource
     * @return $this
     */
    function setDefaultSource($DefaultSource)
    {
        $this->DefaultSource = $DefaultSource;
        return $this;
    }

    /**
     * @return mixed
     */
    function getRef()
    {
        return $this->Ref;
    }

    /**
     * @param $Ref
     * @return $this
     */
    function setRef($Ref)
    {
        $this->Ref = $Ref;
        return $this;
    }

    /**
     * @return mixed
     */
    function getRefId()
    {
        return $this->RefId;
    }

    /**
     * @param $RefId
     * @return $this
     */
    function setRefId($RefId)
    {
        $this->RefId = $RefId;
        return $this;
    }

    /**
     * @return mixed
     */
    function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param $Title
     * @return $this
     */
    function setTitle($Title)
    {
        $this->Title = $Title;
        return $this;
    }

    /**
     * @return mixed
     */
    function getLegenda()
    {
        return $this->Legenda;
    }

    /**
     * @param $Legenda
     * @return $this
     */
    function setLegenda($Legenda)
    {
        $this->Legenda = $Legenda;
        return $this;
    }

    /**
     * @return array|false|null
     */
    function getSourceInfo()
    {
        $source = abs_source_images($this->getSource());
        if (file_exists($source) and is_file($source)) {
            return getimagesize($source);
        }
    }

    /**
     * @return mixed
     */
    function getPosition()
    {
        return (int)$this->Position;
    }

    /**
     * @param $Position
     * @return $this
     */
    function setPosition($Position)
    {
        $this->Position = $Position;
        return $this;
    }

}
    
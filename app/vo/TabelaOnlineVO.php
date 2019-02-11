<?php

namespace app\vo;

use app\core\ValueObject;
use Exception;

class TabelaOnlineVO extends ValueObject
{

    private $type;
    private $title;
    private $url;
    private $mesInicio;
    private $mesFim;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function check()
    {
        if ($this->getMesInicio() > $this->getMesFim()) {
            throw new Exception('Mês de início não pode ser superior ao mês final.');
        } else if (!$this->getTitle()) {
            throw new Exception('Informe o título.');
        } else if (!$this->getUrl()) {
            throw new Exception('Informe a URL');
        }
    }

    public function getMesInicio()
    {
        return (int)$this->mesInicio;
    }

    public function setMesInicio($mesInicio)
    {
        $this->mesInicio = $mesInicio;
        return $this;
    }

    public function getMesFim()
    {
        return (int)$this->mesFim;
    }

    public function setMesFim($mesFim)
    {
        $this->mesFim = $mesFim;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

}
    
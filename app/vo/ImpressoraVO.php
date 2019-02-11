<?php

namespace app\vo;

use app\core\ValueObject;

class ImpressoraVO extends ValueObject
{

    private $ordem;
    private $title;
    private $tipo;

    public function getOrdem()
    {
        return (int)$this->ordem;
    }

    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
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

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

}
    
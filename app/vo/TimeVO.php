<?php

namespace app\vo;

use app\core\ValueObject;

class TimeVO extends ValueObject
{

    private $title;
    private $sigla;

    /**
     * @return mixed
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param mixed $sigla
     * @return $this
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return trim($this->title);
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

}
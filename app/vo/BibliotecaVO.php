<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 18/08/2017
 * Time: 22:11
 */

namespace app\vo;


use app\core\ValueObject;

class BibliotecaVO extends ValueObject
{

    private $ordem;
    private $title;
    private $link;

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * @param mixed $ordem
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
    public function getTitle()
    {
        return $this->title;
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
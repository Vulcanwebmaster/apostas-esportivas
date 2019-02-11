<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 22/08/2017
 * Time: 10:19
 */

namespace app\vo;


use app\core\ValueObject;

class ComunicadoVO extends ValueObject
{

    private $data;
    private $hora;
    private $title;
    private $mensagem;

    /**
     * @return mixed
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->data, 'data', $formatar);
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return substr($this->hora, 0, 5);
    }

    /**
     * @param mixed $hora
     * @return $this
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
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

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param mixed $mensagem
     * @return $this
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
        return $this;
    }

}
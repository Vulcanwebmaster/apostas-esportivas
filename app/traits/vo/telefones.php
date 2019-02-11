<?php
/**
 * Created by PhpStorm.
 * User: Xolenno
 */

namespace app\traits\vo;


use app\helpers\Mask;

trait telefones
{

    private $telefone;
    private $celular;
    private $whatsapp;

    /**
     * @return string
     */
    public function getTelefone()
    {
        return Mask::telefone($this->telefone);
    }

    /**
     * @param string $telefone
     * @return $this
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return string
     */
    public function getCelular()
    {
        return Mask::telefone($this->celular);
    }

    /**
     * @param string $celular
     * @return $this
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
        return $this;
    }

    /**
     * @return string
     */
    public function getWhatsapp()
    {
        return Mask::telefone($this->whatsapp);
    }

    /**
     * @param string $whatsapp
     * @return $this
     */
    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;
        return $this;
    }


}
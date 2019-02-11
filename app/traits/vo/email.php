<?php
/**
 * Created by PhpStorm.
 * User: Xolenno
 */

namespace app\traits\vo;


use app\core\ValueObject;
use app\helpers\VALIDAR;

trait email
{


    private $email;

    public function checkEmail($obrigatorio = false, $unico = false)
    {

        if ($obrigatorio and !$this->email)
            throw new \Exception('Informe o endereço o de e-mail');

        if ($this->email)
            VALIDAR::email($this->email);

        if ($this->email and $unico and $this instanceof ValueObject) {
            $termos = 'WHERE a.email = :email AND a.status != 99 AND a.id != :id LIMIT 1';
            $places = ['id' => $this->getId(), 'email' => $this->getEmail()];

            if ($this->voModel()->lista($termos, $places)) {
                throw new \Exception('E-mail está sendo utilizado');
            }
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return strtolower((string)$this->email);
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


}
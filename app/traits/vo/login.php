<?php
/**
 * Created by PhpStorm.
 * User: Xolenno
 */

namespace app\traits\vo;


use app\core\ValueObject;
use app\helpers\VALIDAR;

trait login
{

    private $login;

    public function checkLogin()
    {
        if (!$this->login)
            throw new \Exception('Informe o login');

        VALIDAR::username($this->login);

        # Login
        if ($this instanceof ValueObject) {
            
            $termos = 'WHERE a.login = :login AND a.status != 99 AND a.id != :id LIMIT 1';
            $places = ['id' => $this->getId(), 'login' => $this->getLogin()];

            if ($this->voModel()->lista($termos, $places)) {
                throw new \Exception('Login está sendo utilizado por outro usuário');
            }
        }
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return strtolower($this->login);
    }

    /**
     * @param mixed $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }


}
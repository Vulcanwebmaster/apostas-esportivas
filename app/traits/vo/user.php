<?php

namespace app\traits\vo;

use app\models\UsersModel;
use app\vo\UserVO;

trait user
{

    /**
     * @var int
     */
    private $user;

    public function checkUser($obrigatorio = true)
    {
        if ($obrigatorio and !$this->getUser())
            throw new \Exception('Selecione o usuário');

        if ($this->getUser() and !$this->voUser())
            throw new \Exception('Usuário inválido');
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return (int)$this->user;
    }

    /**
     * @param int $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return UserVO
     */
    public function voUser()
    {
        return UsersModel::getByLabel('id', $this->getUser());
    }

    /**
     * Nome do usuário
     * @return string
     */
    public function getUserNome()
    {
        if ($this->voUser())
            return $this->voUser()->getNome();
    }

    /**
     * Telefone do usuário
     * @return string
     */
    public function getUserTelefone()
    {
        if ($user = $this->voUser()) {
            return $user->getCelular() ?: $user->getTelefone() ?: $user->getWhatsapp();
        }
    }

    /**
     * @return int
     */
    public function getUserType()
    {
        if ($this->voUser())
            return $this->voUser()->getType();
    }

    /**
     * Login do usuário
     * @return string
     */
    public function getUserLogin()
    {
        if ($this->voUser())
            return $this->voUser()->getLogin();
    }


}
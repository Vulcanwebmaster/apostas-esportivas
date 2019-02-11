<?php

namespace app\traits\vo;

use app\models\UsersModel;
use app\vo\UserVO;

trait userRelacionado
{

    /**
     * @var int
     */
    private $userRelacionado;

    public function checkUserRelacionado($obrigatorio = true)
    {
        if ($obrigatorio and !$this->getUserRelacionado())
            throw new \Exception('Selecione o usuário');

        if ($this->getUserRelacionado() and !$this->voUserRelacionado())
            throw new \Exception('Usuário inválido');
    }

    /**
     * @return int
     */
    public function getUserRelacionado()
    {
        return (int)$this->userRelacionado;
    }

    /**
     * @param int $userRelacionado
     * @return $this
     */
    public function setUserRelacionado($userRelacionado)
    {
        $this->userRelacionado = $userRelacionado;
        return $this;
    }

    /**
     * @return UserVO
     */
    public function voUserRelacionado()
    {
        return UsersModel::getByLabel('id', $this->getUserRelacionado());
    }

    public function getUserRelacionadoNome()
    {
        if ($this->voUserRelacionado())
            return $this->voUserRelacionado()->getNome();
    }


}
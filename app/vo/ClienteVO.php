<?php

namespace app\vo;

use app\core\ValueObject;
use app\traits\vo\user;

class ClienteVO extends ValueObject
{

    use user;

    private $nome;

    function check()
    {
        if (!$this->voUser()) {
            throw new \Exception("Usuário inválido");
        } elseif (!$this->getNome()) {
            throw new \Exception("Informe o nome do cliente");
        }
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return trim($this->nome);
    }

    /**
     * @param mixed $nome
     * @return $this
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

}
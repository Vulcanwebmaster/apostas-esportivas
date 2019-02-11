<?php

namespace app\vo;

use app\core\ValueObject;

class SmtpVO extends ValueObject
{

    private $Nome;
    private $Email;
    private $Host;
    private $Login;
    private $Senha;
    private $Porta;
    private $Autenticar;
    private $Protocolo;
    private $Assunto;

    function getNome()
    {
        return $this->Nome;
    }

    function setNome($Nome)
    {
        $this->Nome = $Nome;
    }

    function getEmail()
    {
        return $this->Email;
    }

    function setEmail($Email)
    {
        $this->Email = $Email;
    }

    function getHost()
    {
        return $this->Host;
    }

    function setHost($Host)
    {
        $this->Host = $Host;
    }

    function getLogin()
    {
        return $this->Login;
    }

    function setLogin($Login)
    {
        $this->Login = $Login;
    }

    function getSenha($hidden = false)
    {
        return $hidden ? null : $this->Senha;
    }

    function setSenha($Senha)
    {
        if ($Senha)
            $this->Senha = $Senha;
    }

    function getPorta()
    {
        return $this->Porta;
    }

    function setPorta($Porta)
    {
        $this->Porta = $Porta;
    }

    function getAutenticar()
    {
        return $this->Autenticar;
    }

    function setAutenticar($Autenticar)
    {
        $this->Autenticar = $Autenticar;
    }

    function getProtocolo()
    {
        return $this->Protocolo;
    }

    function setProtocolo($Protocolo)
    {
        $this->Protocolo = $Protocolo;
    }

    function getAssunto()
    {
        return $this->Assunto;
    }

    function setAssunto($Assunto)
    {
        $this->Assunto = $Assunto;
    }

}
    
<?php

namespace app\traits\vo;

use app\helpers\Utils;

trait token
{

    protected $Token;

    /**
     * Gera o TOKEN único do Objeto
     * @return string TOKEN 50 caracteres
     * @throws \Exception
     */
    public function getToken()
    {
        if (!$this->Token) {
            $tentativas = 20;
            while (!$this->Token or $this->voModel()->lista('WHERE a.token = :token AND a.id != :id LIMIT 1', ['token' => $this->getToken(), 'id' => $this->getId()])) {
                if (!$tentativas) {
                    throw new \Exception('Não foi possível gerar o TOKEN');
                }
                $tentativas--;
                $this->setToken('21' . uniqid() . Utils::gerarCodigo(35, false, true, true, false));
            }
        }
        return strtoupper($this->Token);
    }

    /**
     * Define o TOKEN
     * @param string $Token
     */
    public function setToken($Token)
    {
        $this->Token = $Token;
    }

}
    
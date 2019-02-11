<?php

namespace app\traits\vo;

use app\helpers\Mask;
use app\helpers\VALIDAR;
use Exception;

trait cpf
{

    private $cpf;

    /**
     * Verifica duplicidade
     * @param bool $obrigatorio
     * @param bool $unico
     * @throws Exception
     */
    public function checkCpf($obrigatorio = true, $unico = true)
    {
        if ($obrigatorio and !$this->cpf) {
            throw new Exception('Informe o CPF');
        } else if ($this->cpf and !$this->getCpf()) {
            throw new Exception('CPF inválido');
        }

        if ($unico and $this->getCpf() and $this->voModel()->lista('WHERE a.cpf = :cpf AND a.id != :id AND a.status != 99 LIMIT 1', ['cpf' => $this->getCpf(), 'id' => $this->getId()], true)) {
            throw new Exception('CPF já está sendo utilizado');
        }
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return $this
     */
    public function setCpf($cpf)
    {
        if ($cpf) {
            VALIDAR::cpf($cpf);
            $cpf = Mask::cpf($cpf);
        }

        $this->cpf = $cpf;
        return $this;
    }

}
    
<?php

namespace app\traits\vo;

use app\helpers\VALIDAR;
use stringEncode\Exception;

trait senha
{

    private $senha;
    private $novaSenha;

    /**
     * @return mixed
     */
    public function getNovaSenha()
    {
        return $this->novaSenha;
    }

    /**
     * @param mixed $novaSenha
     * @return $this
     */
    public function setNovaSenha($novaSenha)
    {
        if ($novaSenha and strlen($novaSenha) != PASSWORD_LENG) {
            VALIDAR::password($novaSenha);
            $novaSenha = password($novaSenha);
        }
        $this->novaSenha = $novaSenha;
        return $this;
    }

    /**
     * @param bool $hide
     * @return null|string
     */
    public function getSenha($hide = false)
    {
        return $hide ? null : $this->senha;
    }

    /**
     * @param string $senha
     * @return $this
     * @throws Exception
     */
    public function setSenha($senha)
    {
        if ($senha) {
            if (strlen($senha) != PASSWORD_LENG) {
                $validar = VALIDAR::password($senha);

                if (is_string($validar)) {
                    throw new Exception(strip_tags($validar));
                }

                $this->senha = password($senha);
            } else {
                $this->senha = $senha;
            }
        } else if (!$this->getSenha()) {
            throw new Exception('Informe uma senha de acesso');
        }
        return $this;
    }

}
    
<?php

namespace app\vo\financeiro;

use app\core\ValueObject;
use app\models\helpers\OptionsModel;
use app\models\UsersModel;
use app\traits\vo\token;
use app\vo\helpers\OptionVO;
use app\vo\UserVO;
use Exception;

class ContaVO extends ValueObject
{

    use token;

    private $user;
    private $descricao;
    private $valor;
    private $pago;
    private $primeira;
    private $intervalo = 1;
    private $parcelas = -1;
    private $proxima;

    public function getValor($formatar = false)
    {
        return $this->formatValue($this->valor, 'real', $formatar);
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function getPago()
    {
        return $this->pago ? 1 : 0;
    }

    public function setPago($pago)
    {
        $this->pago = $pago;
        return $this;
    }

    public function getParcelas()
    {
        return (int)$this->parcelas;
    }

    public function setParcelas($parcelas)
    {
        $this->parcelas = $parcelas;
        return $this;
    }

    public function getProxima($formatar = false)
    {
        return $this->formatValue($this->proxima, 'data', $formatar);
    }

    public function setProxima($proxima)
    {
        $this->proxima = $proxima;
        return $this;
    }

    public function check()
    {
        if (!$this->getPrimeira()) {
            throw new Exception('Data inválida');
        } else if (!$this->getId()) {
            if ($this->getPrimeira() <= date('Y-m-d')) {
                throw new Exception('Data da primeira parcela já está ultrapassada');
            }
            $this->setProxima($this->getPrimeira());
        }

        if (!$this->getIntervalo() > 0) {
            throw new Exception('Intervalo inválido');
        } else if (!$this->getDescricao()) {
            throw new Exception('Informe a descrição');
        } else if ($this->getUser() and !$this->voUser()) {
            throw new Exception('Usuário inválido');
        } else if (!$this->voDescricao()) {
            throw new Exception('Descrição inválida');
        }
    }

    public function getPrimeira($formatar = false)
    {
        return $this->formatValue($this->primeira, 'data', $formatar);
    }

    public function setPrimeira($primeira)
    {
        $this->primeira = $primeira;
        return $this;
    }

    public function getIntervalo()
    {
        return (int)$this->intervalo;
    }

    public function setIntervalo($intervalo)
    {
        $this->intervalo = $intervalo;
        return $this;
    }

    public function getDescricao()
    {
        return (int)$this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getUser()
    {
        return (int)$this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /** @return UserVO */
    public function voUser()
    {
        return UsersModel::getByLabel('id', $this->getUser());
    }

    /** @return OptionVO */
    public function voDescricao()
    {
        return OptionsModel::getByLabel('id', $this->getDescricao());
    }

}
    
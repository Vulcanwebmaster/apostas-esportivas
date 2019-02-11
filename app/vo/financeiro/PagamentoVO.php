<?php

namespace app\vo\financeiro;

use app\core\ValueObject;
use app\models\financeiro\ContasModel;
use app\models\helpers\OptionsModel;
use app\models\UsersModel;
use app\traits\vo\token;
use app\vo\helpers\OptionVO;
use app\vo\UserVO;
use Exception;

class PagamentoVO extends ValueObject
{

    use token;

    private $conta;
    private $user;
    private $descricao;
    private $data;
    private $pago;
    private $valor;
    private $dataPagamento;

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

    public function getDataPagamento($formatar = false)
    {
        return $this->formatValue($this->dataPagamento, 'data', $formatar);
    }

    public function setDataPagamento($dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    public function check()
    {
        if (!$this->getData()) {
            throw new Exception('Data inválida');
        } else if ($this->getUser() and !$this->voUser()) {
            throw new Exception('Usuário inválido');
        } else if ($this->getConta() and !$this->voConta()) {
            throw new Exception('Conta inválida');
        } else if (!$this->voDescricao()) {
            throw new Exception('Descrição inválida');
        }
    }

    public function getData($formatar = false)
    {
        return $this->formatValue($this->data, 'data', $formatar);
    }

    public function setData($data)
    {
        $this->data = $data;
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

    public function getConta()
    {
        return (int)$this->conta;
    }

    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    /** @return ContaVO */
    public function voConta()
    {
        return ContasModel::getByLabel('id', $this->getConta());
    }

    /** @return OptionVO */
    public function voDescricao()
    {
        return OptionsModel::getByLabel('id', $this->getDescricao());
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

}
    
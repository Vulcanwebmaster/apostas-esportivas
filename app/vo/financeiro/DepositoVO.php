<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 05/08/2017
 * Time: 10:34
 */

namespace app\vo\financeiro;


use app\core\ValueObject;
use app\helpers\Number;
use app\models\DadosModel;
use app\models\financeiro\DepositosModel;
use app\traits\vo\user;

class DepositoVO extends ValueObject
{

    use user;

    private $tipo;
    private $valor;

    public function check()
    {
        if (!$this->getId()) {
            $valorMinimo = DadosModel::get()->getDepositoMinimo();
            if ($this->getValor() < $valorMinimo) {
                $valorMinimo = Number::real($valorMinimo);
                throw new \Exception("Valor mínimo para depósito é de R$ {$valorMinimo}");
            }
        }
    }

    /**
     * @return mixed
     */
    public function getValor($formatar = false)
    {
        return $this->formatValue($this->valor, 'real', $formatar);
    }

    /**
     * @param mixed $valor
     * @return $this
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function getStatusTitle()
    {
        return DepositosModel::STATUS[$this->getStatus()] ?? 'Inválido';
    }

    /**
     * @return mixed
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $formatar);
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

}
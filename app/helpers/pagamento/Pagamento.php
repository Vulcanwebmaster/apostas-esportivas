<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 09/06/2017
 * Time: 11:43
 */

namespace app\helpers\pagamento;


use app\vo\PagamentoVO;

abstract class Pagamento
{

    /**
     * @var PagamentoVO
     */
    private $pagamento;

    function __construct(PagamentoVO $pagamento)
    {
        $this->pagamento = $pagamento;
    }

    public abstract function cobrar();

    /**
     * @return PagamentoVO
     */
    protected final function getPagamento(): PagamentoVO
    {
        return $this->pagamento;
    }

}
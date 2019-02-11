<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 23/06/2017
 * Time: 19:58
 */

namespace app\modules\admin\controllers;


use app\core\Controller;
use app\helpers\Number;
use app\helpers\pagamento\ItauShopLinePagamento;
use app\models\PagamentosModel;
use app\modules\admin\Admin;
use app\vo\PagamentoVO;

class comprarController extends Controller
{

    function indexAction()
    {
        $this->view("admin/creditos/comprar");
    }

    function insertAction()
    {
        try {

            $valor = Number::float(inputPost('valor'));

            if ($valor < 50) {
                throw new \Exception('O valor mínimo é de R$ 50,00');
            }

            /** @var PagamentoVO $pagamento */
            $pagamento = PagamentosModel::newValueObject();

            $pagamento->setDataVencimento(date('Y-m-d', strtotime('+5days')));
            $pagamento->setUser(Admin::getIdLogged());
            $pagamento->setValor($valor);

            (new ItauShopLinePagamento($pagamento))->cobrar();

            return [
                'message' => 'Compra realizada com sucesso',
                'url' => $pagamento->getLink(),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
<?php

namespace app\notificacoes\controllers;

use app\core\Controller;
use app\models\PagamentosModel;
use app\vo\PagamentoVO;

class itaushoplineController extends Controller
{

    function indexAction()
    {
        try {

            $pagamento = PagamentosModel::getByLabel('token', url_parans(1));

            if (!$pagamento instanceof PagamentoVO) {
                throw new \Exception('Pagamento inválido');
            }

            error_log("ItauShopLine: " . json_encode(inputPost()));

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function redirecionaAction()
    {
        $pagamento = PagamentosModel::getByLabel('token', url_parans(0));

        if ($pagamento instanceof PagamentoVO) {
            location($pagamento->getLink());
        }
    }

}
<?php

namespace app\notificacoes\controllers;

use app\core\Controller;
use app\helpers\pagamento\GerencianetPagamento;
use app\models\PagamentosModel;
use app\vo\PagamentoVO;

class gerencianetController extends Controller
{

    function indexAction()
    {
        try {

            $token = $_POST['notification'] ?? inputGet('token');

            $not = GerencianetPagamento::notificacao($token);

            $data = end($not['data']);
            $status = $data['status']['current'];

            $pg = PagamentosModel::getByLabel('token', $data['custom_id']);

            if (!$pg instanceof PagamentoVO) {
                return [
                    'resposta' => $data,
                    'result' => 0,
                    'message' => 'Pagamento inválido',
                ];
            }

            switch ($status) {
                case 'new':

                    $message = 'Cobrança criada com sucesso';

                    break;
                case 'waiting':

                    $message = 'Aguardando pagamento';

                    break;
                case 'paid':

                    PagamentosModel::baixa($pg, date('Y-m-d'));

                    $message = 'Baixa realizada com sucesso';

                    break;
                case 'canceled':
                case 'unpaid':

                    PagamentosModel::cancelar($pg, date('Y-m-d'));

                    $message = 'Cancelamento realizado';

                    break;
                default:
                    throw new \Exception('Status inválido');
            }

            return [
                'message' => $message,
                'result' => 1,
            ];
        } catch (\Exception $ex) {

            error_log("GerenciaNET:Notificacoes:Error: " . $ex->getMessage());

            return $ex;
        }
    }

}
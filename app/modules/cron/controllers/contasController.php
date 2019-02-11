<?php

namespace app\modules\cron\controllers;

use app\core\Controller;
use app\models\financeiro\ContasModel;
use app\models\financeiro\PagamentosModel;
use app\models\HistoricoModel;
use app\vo\financeiro\ContaVO;
use app\vo\financeiro\PagamentoVO;

class contasController extends Controller
{

    function indexAction()
    {

        $contas = ContasModel::lista('WHERE a.proxima = :hoje AND a.status = 1 AND (a.parcelas = -1 OR a.parcelas > 0)', [
            'hoje' => date('Y-m-d', strtotime('+1day')),
        ]);

        foreach ($contas as $conta) {
            if ($conta instanceof ContaVO) {

                $pagamento = PagamentosModel::newValueObject();

                if ($pagamento instanceof PagamentoVO) {

                    $pagamento
                        ->setConta($conta->getId())
                        ->setUser($conta->getUser())
                        ->setDescricao($conta->getDescricao())
                        ->setData($conta->getProxima())
                        ->setPago($conta->getPago())
                        ->setValor($conta->getValor())
                        ->setDataPagamento($conta->getPago() ? $conta->getProxima() : null)
                        ->Save();


                    $conta->Save([
                        'proxima' => date('Y-m-d', strtotime("{$conta->getProxima()} + {$conta->getIntervalo()}months")),
                        'parcelas' => $conta->getParcelas() > -1 ? max(0, $conta->getParcelas() - 1) : -1,
                    ]);
                }
            }
        }

        if ($contas) {
            $total = count($contas);
            HistoricoModel::add("CRON: {$total} cobranças foram geradas");
        }
    }

}
    
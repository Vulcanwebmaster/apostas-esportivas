<?php

namespace app\modules\website\controllers;

use app\core\Controller;
use app\models\ApostasModel;
use app\models\HistoricoBancarioModel;
use app\modules\admin\Admin;
use app\vo\ApostaVO;

class bilheteController extends Controller
{

    function indexAction()
    {
        $this->view('website/page/bilhete', [
            'title' => 'Consultar bilhete',
        ]);
    }

    function validarAction()
    {
        try {

            $user = Admin::getLogged();
            $aposta = ApostasModel::getByLabel('token', inputPost('token'));

            if (!$user) {
                throw new \Exception("Atualize sua página e faça login novamente.");
            } else if (!$aposta instanceof ApostaVO) {
                throw new \Exception("Aposta inválida");
            } else if ($aposta->getStatus() != ApostasModel::STATUS_AGUARDANDO_PAGAMENTO) {
                throw new \Exception("Aposta não pode mais ser validada");
            } else if ($aposta->getValor() > $user->getCredito()) {
                throw new \Exception("Saldo insuficiente para validar a aposta.");
            }

            foreach ($aposta->voJogos() as $v) {
                if ($v->voJogo()->jaComecou()) {
                    throw new \Exception("A aposta não pode mais ser validada pois o jogos `{$v->voJogo()->getDescricao()}` já se iniciou.");
                }
            }

            $aposta->setUser($user->getId());
            $aposta->setStatus(1);
            $aposta->save();

            HistoricoBancarioModel::add($user, -$aposta->getValor(), "Validação de aposta #{$aposta->getId()}", $aposta);

            ApostasModel::pagarComissoes($aposta);

            return [
                'message' => 'Aposta validada com sucesso',
                'saldo' => $user->getCredito(),
                'result' => 1,
            ];

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {
        try {

            $codigo = inputPost('codigo');
            if (!$codigo)
                throw new \Exception("Informe o código da aposta");

            $aposta = ApostasModel::getByLabel('codigobilhete', str_replace(' ', '', $codigo));

            if (!$aposta instanceof ApostaVO) {
                throw new \Exception("Aposta inválida");
            }

            $this->view('website/page/bilhete', [
                'aposta' => $aposta,
                'user' => $aposta->voUser(),
            ], 'bilhete');

        } catch (\Exception $ex) {
            echo <<<HTML
<div class="alert alert-info mb-0">
    <i class="fa fa-warning"></i> {$ex->getMessage()}
</div>
HTML;
        }
    }

}
<?php

namespace app\modules\website\controllers;

use app\core\Controller;
use app\helpers\Date;
use app\models\HistoricoBancarioModel;
use app\models\UsersModel;

class saldoController extends Controller
{

    function indexAction()
    {
        $this->view('website/page/saldo');
    }

    function listAction()
    {
        try {

            $user = UsersModel::getLogged();
            if (!$user) {
                throw new \Exception("Precisa estar logado para visualizar seu histórico financeiro");
            }

            $parans = ['status' => 1, 'user' => $user->getId()];
            $parans += inputPost();
            $parans += [
                'page' => 1,
                'forpage' => 9999,
                'dataInicial' => date('Y-01-01'),
                'dataFinal' => date('Y-m-t'),
                'type' => 'credito',
            ];

            $data = new \DateTime(Date::data($parans['dataInicial']));
            $resumoAnterior = HistoricoBancarioModel::getSaldo($user, $data);

            $busca = HistoricoBancarioModel::busca($parans, $parans['page'], $parans['forpage']);

            $this->view('website/page/saldo', [
                'resumoAnterior' => $resumoAnterior,
                'busca' => $busca,
            ], 'list');

        } catch (\Exception $ex) {

            $this->view('website/page/saldo', [
                'message' => $ex->getMessage(),
            ], 'list');

        }
    }

}
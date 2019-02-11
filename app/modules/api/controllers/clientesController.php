<?php

namespace app\modules\api\controllers;

use app\core\Controller;
use app\models\ClientesModel;
use app\modules\api\API;
use app\modules\api\serialize\ClienteSerialize;
use app\vo\ClienteVO;

class clientesController extends Controller
{

    function novoAction()
    {
        try {

            $user = API::getUser();

            $cliente = ClientesModel::newValueObject([
                'user' => $user->getId(),
                'nome' => inputPost('nome'),
            ])->save();

            return $this->indexAction();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function indexAction()
    {
        try {

            $user = API::getUser();

            $results = [];

            foreach (ClientesModel::busca(['user' => $user->getId(), 'status' => 1], 1, 99)->getRegistros() as $v) {
                $results[] = new ClienteSerialize($v);
            }

            return [
                'clientes' => $results,
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function excluirAction()
    {
        try {

            $user = API::getUser();

            $cliente = ClientesModel::getByLabel('id', inputPost('id'));
            if (!$cliente instanceof ClienteVO)
                throw new \Exception("Cliente inválido");

            if ($cliente->getUser() != $user->getId())
                throw new \Exception("Cliente não pertence a sua conta");

            $cliente->save(['status' => 99]);

            return $this->indexAction();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
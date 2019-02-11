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
use app\models\DadosModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\UserVO;

class transferirController extends Controller
{

    function indexAction()
    {
        $this->view("admin/creditos/transferir");
    }

    function insertAction()
    {
        $valor = Number::float(inputPost('valor'));
        $user = Admin::getLogged();

        try {

            $places = ['login' => inputPost('destinatario')];
            $dest = current(UsersModel::lista('WHERE a.login = :login AND a.status = 1 LIMIT 1', $places));

            if (!$dest instanceof UserVO) {
                throw new \Exception('Destinatário inválido');
            } else if (!Admin::isDeveloper() and $dest->getId() == $user->getId()) {
                throw new \Exception('Não é possível transferir crédito para sua própria conta.');
            } else if ($valor < 5) {
                throw new \Exception('O valor mínimo por transferência é de R$ 5,00');
            }

            $taxa = DadosModel::get()->getTaxaTransferencia();

            if ($taxa) {
                $taxa = $valor * $taxa / 100;
            }

            if ($user->getCredito() < $valor + $taxa) {
                $total = Number::real($valor + $taxa);
                $valor = Number::real($valor);
                $taxa = Number::real($taxa);
                throw new \Exception("Seu saldo é insuficiente para concluir a transferência.<br/><br/>Valor: R$ {$valor}<br/>Taxa: R$ {$taxa}<br/>-------------------<br/>Total: R$ {$total}");
            }

            HistoricoBancarioModel::add($dest, $valor, "<b>TRANSFERÊNCIA</b> - Crédito transferido pelo usuário “{$user->getLogin()}”", $user, "transferencia");
            HistoricoBancarioModel::add($user, -$valor, "<b>TRANSFERÊNCIA</b> - Transferência de crédito para o usuário “{$dest->getLogin()}”", $dest, "transferencia");
            HistoricoBancarioModel::add($user, -$taxa, "<b>TARIFA</b> - Tarifa referente a transferência para o usuário “{$dest->getLogin()}”", $dest, "transferencia");

            HistoricoModel::add("Transferiu R$ {$valor} para {$dest->getLogin()}", $dest, $user);

            return [
                'message' => 'Tranferência realizada com sucesso',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            HistoricoModel::add("Tentou transferir R$ {$valor} para outro usuário", null, $user);
            return $ex;
        }
    }

}
<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\models\DadosModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\UserVO;

class ativacaoController extends Controller
{

    function indexAction()
    {
        $this->view("admin/ativacao/ativacao");
    }

    function utilizarSaldoAction()
    {
        try {

            $user = Admin::getLogged();

            if (!$user->getPagouPlano()) {
                UsersModel::ativarPlano($user);
                HistoricoModel::add("Ativou o plano `{$user->getLicencaTitle()}`", $user, $user);
            } else if (!$user->estaEmDia()) {
                UsersModel::recargaMensal($user);
                HistoricoModel::add("Efetuou a recarga mensal", $user, $user);
            }

        } catch (\Exception $ex) {

        }

        location(url_referer());
    }

    function checkAction()
    {
        try {

            $login = inputPost('destinatario');

            $tipo = inputPost('tipo');

            $places = ['login' => $login];

            $dest = current(UsersModel::lista('WHERE a.login = :login AND a.status != 99 LIMIT 1', $places));

            if (!$dest instanceof UserVO) {
                throw new \Exception("Conta de destino não existe");
            }

            switch ($tipo) {
                case 'pre':
                    $label = "do pré-cadastro";
                    $valor = DadosModel::getValorPreCadastro(true);
                    break;
                case 'plano':
                    $label = "da licença";
                    $valor = DadosModel::getValorPlanoAdesao($dest, true);
                    break;
                case 'recarga':
                    $label = "da mensalidade";
                    $valor = DadosModel::getValorRecarga($dest, true);
                    break;
                default:
                    throw new \Exception("Ação inválida");
            }

            return [
                'values' => [
                    'destinatario' => $dest->getToken(),
                    'tipo' => $tipo,
                ],
                'message' => "Você confirma a ativação {$label} do usuário {$dest->getLogin()}, no valor de R$ {$valor}",
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function ativarAction()
    {
        try {

            Conn::startTransaction();

            $dest = UsersModel::getByLabel('token', inputPost('destinatario'));

            $user = Admin::getLogged();
            $config = DadosModel::get();

            if (!$dest instanceof UserVO) {
                throw new \Exception('Conta de destino não existe');
            }

            switch (inputPost('tipo')) {
                case 'pre':

                    if ($dest->getPagouPreCadastro()) {
                        throw new \Exception('Conta já possuí baixa do pagamento do pré-cadastro');
                    }

                    $valor = $config->getValorPreCadastro();

                    if ($valor > 0) {

                        if ($user->getCredito() < $valor) {
                            throw new \Exception('Seu saldo é insuficiente para completar a transação');
                        }

                        HistoricoBancarioModel::add($user, -$valor, "PRÉ-CADASTRO: Pagamento do Pré-cadastro do usuário `{$dest->getLogin()}`", $dest, "precadastro");
                    }

                    $dest->setPagouPreCadastro(1);
                    $dest->save();

                    HistoricoModel::add("Ativou o pré-cadastro do usuário #{$dest->getId()}", $dest, Admin::getLogged());

                    break;
                case 'plano':

                    if ($dest->getPagouPlano()) {
                        throw new \Exception("Conta já possuí baixa do pagamento do plano");
                    }

                    $valor = DadosModel::getValorPlanoAdesao($dest);

                    if ($valor > 0) {

                        if ($user->getCredito() < $valor) {
                            throw new \Exception("Seu saldo é insuficiente para completar a transação");
                        }

                        HistoricoBancarioModel::add($dest, $valor, "<b>TRANSFERÊNCIA</b> - Crédito transferido pelo usuário “{$user->getLogin()}” para pagamento da “Ativação”", $user, "ativacao");
                        UsersModel::ativarPlano($dest);
                        HistoricoBancarioModel::add($user, -$valor, "<b>ATIVAÇÃO</b> - Ativação da licença “{$user->getLicencaTitle()}” do usuário “{$dest->getLogin()}”", $dest, "ativacao");

                    }

                    $dest->setPagouPlano(1);
                    $dest->save();

                    HistoricoModel::add("Ativou o plano do usuário #{$dest->getId()}", $dest, Admin::getLogged());

                    break;
                case 'recarga':

                    if (!$dest->getPagouPlano() or !$dest->getPagouPreCadastro()) {
                        throw new \Exception("Conta ainda não está ativa");
                    }

                    $valor = DadosModel::getValorRecarga($user);

                    if ($valor > 0) {

                        if ($user->getCredito() < $valor) {
                            throw new \Exception("Seu saldo é insuficiente para completar a transação");
                        }

                        HistoricoBancarioModel::add($user, -$valor, "<b>RECARGA</b> - Pagamento da Recarga Mínima Mensal do usuário “{$dest->getLogin()}”", $dest, "ativacao");
                    }

                    if (!$dest->getDataValidade() or date('Y-m-d') > $dest->getDataValidade()) {
                        $validade = date('Y-m-d', strtotime("+1month"));
                    } else {
                        $validade = date('Y-m-d', strtotime("{$dest->getDataValidade()} +1month"));
                    }

                    $dest->setDataValidade($validade);
                    $dest->save();

                    HistoricoModel::add("Efetuou a recarga mensal do usuário #{$dest->getId()}", $dest, Admin::getLogged());

                    break;
                default:
                    throw new \Exception('Tipo inválido');
            }

            Conn::commit();

            return [
                'message' => 'Transação realizada com sucesso',
                'result' => 1,
            ];

        } catch (\Exception $ex) {
            Conn::rollBack();
            return $ex;
        }
    }

}
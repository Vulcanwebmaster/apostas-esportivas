<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\pagamento\ItauShopLinePagamento;
use app\models\DadosModel;
use app\models\PagamentosModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\PagamentoVO;
use Exception;

class indexController extends Controller
{

    function indexAction()
    {
        $user = Admin::getLogged();

        switch ($user->getType()) {
            case UsersModel::TYPE_CLIENTE:
            case UsersModel::TYPE_GERENTE:
                $this->view('admin/home/jogador', [
                    'title' => 'Resumo da conta',
                    'page' => null,
                ]);
                break;
            default:
                location(url('home'));
        }
    }

    function recargaboletoAction()
    {
        $user = Admin::getLogged();
        $valor = $type = 0;

        if ($user->getPagouPlano()) {

            $type = PagamentosModel::TYPE_ADESAO;
            $valor = DadosModel::getValorPlanoAdesao($user);


        } else if (!$user->estaEmDia()) {

            $type = PagamentosModel::TYPE_RECARGA;
            $valor = DadosModel::getValorRecarga($user);

        } else {

            location();

        }

        if (!$valor) {

            $user->setDataValidade(date('Y-m-d', strtotime('+1month')));
            $user->setPagouPlano(1);
            $user->save();

            location();
        }

        $pagamento = PagamentosModel::getEmAberto($user, $type);

        if (!$pagamento) {

            /** @var PagamentoVO $pagamento */
            $pagamento = PagamentosModel::newValueObject();

            $pagamento->setValor($valor);
            $pagamento->setUser($user->getId());
            $pagamento->setType($type);

            try {

                Conn::startTransaction();

                $pagamento->save();

                (new ItauShopLinePagamento($pagamento))->cobrar();

                Conn::commit();

                location($pagamento->getLink());

            } catch (Exception $ex) {
                Conn::rollBack();
                error_log($ex->getMessage());
                location();
            }
        } else {
            location($pagamento->getLink());
        }

    }

    function twigAction()
    {
        $this->viewCacheClean();
        location(url_referer());
    }

}

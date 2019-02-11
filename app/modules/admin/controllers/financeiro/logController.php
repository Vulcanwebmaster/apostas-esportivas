<?php

namespace app\modules\admin\controllers\financeiro;

use app\core\Controller;
use app\helpers\PanelBootstrap;
use app\helpers\Table;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\vo\admin\MenuVO;
use app\vo\HistoricoBancarioVO;

class logController extends Controller
{

    function indexAction(MenuVO $page)
    {
        $this->view('admin/financeiro/log');
    }

    function estornarAction()
    {
        try {

            if (!Admin::isMaster()) {
                throw new \Exception("Somente administradores");
            }

            $transacao = HistoricoBancarioModel::getByLabel('token', url_parans(0));

            if (!$transacao instanceof HistoricoBancarioVO) {
                throw new \Exception("Transação inválida");
            } else if ($transacao->getEstornada()) {
                throw new \Exception("Transação já foi estornada");
            }

            $msg = "Estorno da transação #{$transacao->getId()}";

            HistoricoBancarioModel::add($transacao->voUser(), $transacao->getValor() * -1, $msg, $transacao->voRef(), $transacao->getRefType());

            $transacao->setEstornada(1)->save();

            HistoricoModel::add("Estornou a transação #{$transacao->getId()}", $transacao, Admin::getLogged());

            return [
                'message' => "Estorno realizado com sucesso",
                'restul' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {

        if (!Admin::isMaster()) {
            throw new \Exception("Somente administradores");
        }

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 30];

        $busca = HistoricoBancarioModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getRegistros()) {

            $t = new Table(null, 'table table-striped table-bordered table-hover');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('#')
                ->addCell('Data/Hora')
                ->addCell('Cliente')
                ->addCell('Descrição')
                ->addCell('Creditos')
                ->addCell('Ações')
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 7])
                ->addTSection('tbody');

            /** @var HistoricoBancarioVO $v */
            foreach ($busca->getRegistros() as $v) {

                $user = $v->voUser();

                $acoes = '';

                if (!$v->getEstornada()) {
                    $acoes = '<div class="btn btn-warning" data-estornar="' . $v->getToken() . '"><i class="fa fa-exchange" data-toggle="tooltip" title=estornar></i></div>';
                }

                $t
                    ->addRow($v->getValor() < 0 ? 'text-danger' : null)
                    ->addCell($v->getId(), 'text-center')
                    ->addCell($v->getData(true) . '<br />' . $v->getHora(), 'text-center')
                    ->addCell("{$user->getNome()} ({$user->getLogin()})<br />{$user->getEmail()}")
                    ->addCell($v->getDescricao())
                    ->addCell('R$ ' . $v->getValor(true) . '<br /><small class="text-default">R$ ' . $v->getSaldoCreditos(true) . '</small>', 'text-center')
                    ->addCell($acoes, 'text-center');
            }

            echo (new PanelBootstrap())
                ->setBody("<div class='table-responsive'>{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo <<<HTML
<div class="alert alert-warning">
    Nehum registro encontrado dentro do periodo informado
</div>
HTML;

        }

    }

}
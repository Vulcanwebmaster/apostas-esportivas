<?php

namespace app\modules\admin\controllers\financeiro;

use app\APP;
use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\financeiro\ContasModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\vo\financeiro\ContaVO;
use Exception;

class contasController extends Controller
{

    use excluir;

    function indexAction()
    {
        $this->view('admin/financeiro/contas');
    }

    function novoAction()
    {
        $this->form(ContasModel::newValueObject(), 'Nova Conta');
    }

    function form(ContaVO $conta, $title)
    {
        $this->view('admin/financeiro/conta-form', [
            'v' => $conta,
            'title' => $title,
        ]);
    }

    function editarAction()
    {
        $v = ContasModel::getByLabel('token', url_parans(0));
        if ($v) {
            $this->form($v, 'Editar Conta');
        } else {
            location(url_referer());
        }
    }

    function save(ContaVO $v)
    {
        try {

            $nova = !$v->getId();

            if (!$v->getId()) {
                $v->input('primeira');
            }

            $v
                ->input('user')
                ->input('descricao')
                ->input('intervalo')
                ->input('parcelas')
                ->input('pago')
                ->input('valor')
                ->Save();

            HistoricoModel::add($nova ? "Criou a conta #{$v->getId()}" : "Alterou a conta #{$v->getId()}", $v, Admin::getLogged());

            return [
                'message' => 'Salvo',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {
        $busca = ContasModel::busca(inputPost(), inputPost('page') ?: 1, 20);
        if ($busca->getCount()) {


            $t = (new Table(null, 'table table-striped table-hover table-bordered'))
                ->addTSection('thead')
                ->addRow()
                ->addCell('Data', ['width' => 120])
                ->addCell('Usuário')
                ->addCell('Descrição')
                ->addCell('Valor', ['width' => 120])
                ->addCell('Auto PG', ['width' => 90])
                ->addCell('Ações', ['width' => 120])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof ContaVO) {

                    $link = url(APP::getControllerName() . '/editar', [$v->getToken()]);
                    $t
                        ->addRow()
                        ->addCell($v->getProxima(true), 'text-center')
                        ->addCell($v->getUser() ? $v->voUser()->getNome() : '--/--')
                        ->addCell($v->voDescricao()->getTitle())
                        ->addCell('R$ ' . $v->getValor(true), 'text-center')
                        ->addCell($v->getPago() ? 'Sim' : 'Não', 'text-center')
                        ->addCell('<div class="btn-group">'
                            . "<a class='btn btn-default' href='{$link}'><i class='fa fa-edit'></i></a>"
                            . "<div class='btn btn-danger' data-excluir='{$v->getToken()}'><i class='fa fa-trash'></i></div>"
                            . '</div>', 'text-center');
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive'>{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning">'
                . '<i class="fa fa-warning"></i> Nenhuma conta encontrado '
                . '</div>';
        }
    }

    function getModel()
    {
        return ContasModel::Instance();
    }

}
    
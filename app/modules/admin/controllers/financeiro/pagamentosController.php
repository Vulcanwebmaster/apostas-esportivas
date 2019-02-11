<?php

namespace app\modules\admin\controllers\financeiro;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\Table;
use app\models\financeiro\PagamentosModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\vo\financeiro\PagamentoVO;
use Exception;

class pagamentosController extends Controller
{

    use excluir;

    function indexAction()
    {
        $this->view('admin/financeiro/pagamentos', [
            'usersTypes' => UsersModel::options(null, Admin::getLogged()->getType()),
        ]);
    }

    function pagarAction()
    {
        try {

            $pagamento = PagamentosModel::getByLabel('token', inputPost('token'));
            if (!$pagamento instanceof PagamentoVO) {
                throw new Exception('Pagamento inválido');
            }

            $data = Date::data(inputPost('datapagamento'));
            if (!$data) {
                throw new Exception('Data inválida');
            }

            $pagamento
                ->setDataPagamento($data)
                ->setPago(1)
                ->Save();

            HistoricoModel::add("Confirmou o pagamento da conta #{$pagamento->getId()}", $pagamento, Admin::getLogged());

            return [
                'message' => 'Baixa efetuada com sucesso',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function novoAction()
    {
        $this->form(PagamentosModel::newValueObject(), 'Novo Pagamento');
    }

    function form(PagamentoVO $pagamento, $title)
    {
        $this->view('admin/financeiro/pagamento-form', [
            'v' => $pagamento,
            'title' => $title,
        ]);
    }

    function editarAction()
    {
        $v = PagamentosModel::getByLabel('token', url_parans(0));
        if ($v) {
            $this->form($v, 'Editar Pagamento');
        } else {
            location(url_referer());
        }
    }

    function save(PagamentoVO $v)
    {
        try {

            $novo = !$v->getId();

            $v
                ->input('user')
                ->input('descricao')
                ->input('data')
                ->input('valor')
                ->Save();

            HistoricoModel::add($novo ? "Criou o pagamento #{$v->getId()}" : "Alterou o pagamento #{$v->getId()}", $v, Admin::getLogged());

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
        $busca = PagamentosModel::busca(inputPost(), inputPost('page') ?: 1, 20);
        if ($busca->getCount()) {


            $t = (new Table(null, 'table table-striped table-hover table-bordered'))
                ->addTSection('thead')
                ->addRow()
                ->addCell('Data', ['width' => 120])
                ->addCell('Usuário')
                ->addCell('Descrição')
                ->addCell('Valor', ['width' => 120])
                ->addCell('Pago', ['width' => 120])
                ->addCell('Ações', ['width' => 120])
                ->addTSection('tbody');

            $hoje = date('Y-m-d');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof PagamentoVO) {

                    $link = url(\app\APP::getControllerName() . '/editar', [$v->getToken()]);

                    $class = 'default';

                    if ($v->getPago()) {
                        $class = 'success';
                    } else if ($v->getData() < $hoje) {
                        $class = 'danger';
                    } else if ($v->getData() == $hoje) {
                        $class = 'warning';
                    }

                    $t
                        ->addRow($class)
                        ->addCell($v->getData(true), 'text-center')
                        ->addCell($v->getUser() ? $v->voUser()->getNome() : '--/--')
                        ->addCell($v->voDescricao()->getTitle())
                        ->addCell('R$ ' . $v->getValor(true), 'text-center')
                        ->addCell($v->getPago() ? $v->getDataPagamento(true) : 'Não', 'text-center')
                        ->addCell('<div class="btn-group">'
                            . "<a class='btn btn-default' href='{$link}'><i class='fa fa-edit' data-toggle='tooltip' title='Editar'></i></a>"
                            . (!$v->getPago() ? "<a class='btn btn-default' onClick=\"$('.modal-pagar').setValues({token: '{$v->getToken()}', id: {$v->getId()}, datapagamento: '{$v->getData()}'})\"><i class='fa fa-money' data-toggle='tooltip' title='Pagar'></i></a>" : null)
                            . "<div class='btn btn-danger' data-excluir='{$v->getToken()}'><i class='fa fa-trash' data-toggle='tooltip' title='Excluir'></i></div>"
                            . '</div>', 'text-center');
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive'>{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning">'
                . '<i class="fa fa-warning"></i> Nenhum pagamento encontrado '
                . '</div>';
        }
    }

    function getModel()
    {
        return PagamentosModel::Instance();
    }

}
    
<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\TabelasOnlineModel;
use app\traits\ctrl\excluir;
use app\vo\TabelaOnlineVO;
use Exception;

class tabelas_onlineController extends Controller
{

    public function indexAction()
    {
        $this->view('admin/forms/tabelas_online');
    }

    public function save(TabelaOnlineVO $v)
    {
        if (!IS_AJAX) {
            location(url());
        }

        try {

            $v
                ->input('mesinicio')
                ->input('mesfim')
                ->input('type')
                ->input('title')
                ->input('url')
                ->Save();

            json('Salvo com sucesso.', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    use excluir;

    function getModel()
    {
        return TabelasOnlineModel::Instance();
    }

    function listAction()
    {

        $parans=inputPost();
        $parans += ['page' => 1, 'forpage' => 20];

        $busca = TabelasOnlineModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Tipo', ['width' => 150])
                ->addCell('Tabela')
                ->addCell('Ações', ['width' => 100])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof TabelaOnlineVO) {

                    $acoes = '<div class="btn btn-default" data-editar="' . $v . '" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></div>'
                        . '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-trash-o" data-toggle="tooltip" title="Excluir" ></i></div>';

                    $t
                        ->addRow()
                        ->addCell($v->getType())
                        ->addCell($v->getTitle())
                        ->addCell('<div class="btn-group" >'
                            . $acoes
                            . '</div>', 'text-center');
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive' >{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning no-margin" >'
                . '<i class="fa fa-warning" ></i> Nenhuma tabela encontrada.'
                . '</div>';
        }
    }

}
    
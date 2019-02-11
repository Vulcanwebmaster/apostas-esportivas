<?php

namespace app\modules\admin\controllers\cadastros;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\ComunicadosModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\status;
use app\vo\ComunicadoVO;

class comunicadosController extends Controller
{

    use excluir;
    use status;

    function indexAction()
    {
        $this->view('admin/comunicados');
    }

    function listAction()
    {

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 10];

        $busca = ComunicadosModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-hover table-bordered');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Data/Hora', ['width' => 120])
                ->addCell('Comunicado')
                ->addCell('Ações', ['width' => 150])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 10])
                ->addTSection('tbody');


            /** @var ComunicadoVO $v */
            foreach ($busca->getRegistros() as $v) {

                $statusClass = $v->getStatus() == 1 ? '' : '-slash';

                $acoes = '<div class="btn btn-default" data-editar="' . $v . '"><i class="fa fa-edit"></i></div>';
                $acoes .= '<div class="btn btn-default" data-status="' . $v->getToken() . '"><i class="fa fa-eye' . $statusClass . '"></i></div>';
                $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '"><i class="fa fa-trash"></i></div>';


                $t
                    ->addRow()
                    ->addCell("{$v->getData(true)}<Br />{$v->getHora()}", 'text-center')
                    ->addCell($v->getTitle())
                    ->addCell("<div class='btn-group'>{$acoes}</div>");
            }

            echo (new Panel())
                ->setBody("<div class='table-responsive'>{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);

        } else {
            echo <<<HTML
<div class="alert alert-warning">
    Nenhum registro encontrado.
</div>
HTML;

        }

    }

    function save(ComunicadoVO $v)
    {
        try {

            $novo = !$v->getId();
            $v->save(inputPost());

            HistoricoModel::add($novo ? "Adicionou o comunicado #{$v->getId()}" : "Alterou o comunicado #{$v->getId()}", $v, Admin::getLogged());

            return ['result' => 1];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function getModel()
    {
        return ComunicadosModel::instance();
    }

}
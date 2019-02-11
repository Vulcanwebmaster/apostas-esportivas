<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\ImpressorasModel;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;
use app\vo\admin\MenuVO;
use app\vo\ImpressoraVO;

class impressorasController extends Controller
{

    use save;
    use excluir;

    function indexAction(MenuVO $p)
    {
$this->view('admin/impressoras');
    }

    /**
     * Lista os registros
     */
    function listAction()
    {
        $registros = ImpressorasModel::lista();

        if ($registros) {

            # Table
            $t = new Table('', "table table-hover table-striped table-bordered sortable");

            # Header
            $t->addTSection('thead');
            $t->addRow();
            $t->addCell('Impressora');
            $t->addCell('Tipo', ['width' => 150]);
            $t->addCell('Ações', ['width' => 150]);

            # Registros
            $t->addTSection('tbody');
            foreach ($registros as $v) {

                $acoes = '<div class="btn btn-default" data-editar="' . $v->toHtml(true) . '" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></div>';
                $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" data-toggle="tooltip" title="Excluir" ></i></div>';

                $t->addRow(null, ['data-id' => $v->getId(), 'data-ordem' => $v->getOrdem()]);
                $t->addCell($v->getTitle());
                $t->addCell($v->getTipo() . 'mm');
                $t->addCell('<div class="btn-group" >'
                    . $acoes
                    . '</div>'
                    , 'text-center');
            }

            echo (new Panel())
                ->setBody('<div class="table-responsive" >' . $t . '</div>');
        } else {
            echo '<div class="alert alert-warning" >'
                . '<i class="fa fa-warning" ></i> Nenhuma impressora cadastrada até o momento'
                . '</div>';
        }
    }

    /**
     * Reorganizando registros
     */
    function sortableAction()
    {
        $ids = stringToArray(inputPost('id'));
        $ordens = stringToArray(inputPost('ordem'));

        if (!empty($ids) and count($ids) == count($ordens)) {
            foreach ($ids as $key => $id) {
                $impressora = $this->getModel()->getByLabel('id', $id);
                if (isset($ordens[$key]) and $impressora instanceof ImpressoraVO) {
                    $impressora->save(['ordem' => $ordens[$key]]);
                }
            }
        }

        ImpressorasModel::organizar();
    }

    function getModel()
    {
        return ImpressorasModel::Instance();
    }

}
    
<?php

namespace app\modules\admin\controllers\helpers;

use app\core\Controller;
use app\helpers\PanelBootstrap;
use app\helpers\Table;
use app\models\helpers\OptionsModel;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;
use app\vo\admin\MenuVO;
use app\vo\helpers\ImageVO;
use app\vo\helpers\OptionVO;
use Exception;

class optionsController extends Controller
{

    use excluir;
    use save;

    function indexAction(MenuVO $p)
    {

        $config = $p->getVariaveis(true);
        $config += ['ref' => 'options', 'refid' => 0];

        $this->view('admin/helpers/options', [
            'vars' => $config,
        ]);

    }

    function optionsAction()
    {
        echo OptionsModel::options(url_parans(0));
    }

    /**
     * Lista os registros
     */
    function listAction()
    {

        $registros = $this->getModel()->listByRef(inputPost('ref'));
        $showImage = inputPost('image');

        if (count($registros)) {

            # Table
            $t = new Table('', "table table-hover table-striped table-bordered sortable");

            # Header
            $t->addTSection('thead');
            $t->addRow();

            if ($showImage)
                $t->addCell('<i class="fa fa-image"></i>', 'text-center', null, ['width' => 100]);

            $t->addCell('Título');
            $t->addCell('Ações', ['width' => 120]);

            # Registros
            $t->addTSection('tbody');

            /** @var ImageVO $v */
            foreach ($registros as $v) {

                $acoes = '<div class="btn btn-default" data-editar="' . $v . '" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></div>';
                $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" data-toggle="tooltip" title="Excluir" ></i></div>';

                $t->addRow('', ['data-id' => $v->getId(), 'data-ordem' => $v->getOrdem()]);

                if ($showImage)
                    $t->addCell("<img src='{$v->imgCapa()->redimensiona(0 , 30)}' />", 'text-center');

                $t->addCell($v->getTitle());
                $t->addCell('<div class="btn-group" >'
                    . $acoes
                    . '</div>'
                    , 'text-center');
            }

            echo (new PanelBootstrap())
                ->setBody('<div class="table-responsive" >' . $t . '</div>');
        } else {
            echo '<div class="alert alert-warning" >'
                . '<i class="fa fa-warning" ></i> Nenhum registro encontrado'
                . '</div>';
        }
    }

    /** @return OptionsModel */
    function getModel()
    {
        return OptionsModel::Instance();
    }

    function sortableAction()
    {

        $ids = stringToArray(inputPost('id'));
        $ordens = stringToArray(inputPost('ordem'));

        if (!empty($ids) and count($ids) == count($ordens)) {

            $opt = null;

            foreach ($ids as $key => $id) {

                $ordem = (int)$ordens[$key];
                $v = $this->getModel()->getByLabel('id', $id);

                if ($v instanceof OptionVO) {

                    if (!$opt) {
                        $opt = $v;
                    }

                    $v->setOrdem($ordem)->save();
                }
            }

            if ($opt) {
                OptionsModel::instance()->organizaOrdemReferencia($opt->getRef());
            }

        }
    }

}
    
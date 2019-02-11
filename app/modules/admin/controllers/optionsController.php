<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\helpers\OptionsModel;
use app\modules\admin\Admin as Module;
use app\traits\ctrl\excluir;
use app\vo\admin\MenuVO;
use app\vo\helpers\OptionVO;
use Exception;

class optionsController extends Controller
{

    function indexAction(MenuVO $p)
    {
        $vars = $p->getVariaveis(true);
        $this->view('admin/helpers/options', [
            'vars' => $vars,
        ]);
    }

    /**
     * Lista os registros
     */
    function listAction()
    {

        $registros = $this->getModel()->listByRef(inputPost('ref'));

        if (count($registros)) {

            # Table
            $t = new Table('', "table table-hover table-striped table-bordered sortable");

            # Header
            $t->addTSection('thead');
            $t->addRow();

            if (!empty($pageVars['image'])) {
                $t->addCell($pageVars['image'], ['width' => 60]);
            }

            $t->addCell(!empty($pageVars['label']) ? $pageVars['label'] : 'Título');
            $t->addCell('Ações', ['width' => 5]);

            # Registros
            $t->addTSection('tbody');
            foreach ($registros as $v) {

                $acoes = '<div class="btn btn-default" data-editar="' . $v->toHtml(true) . '" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></div>';
                //$acoes .= '<a class="btn btn-default" href="' . url('options/sub', [$v->getRef(), $v->getId(), $v->getTitle()]) . '" ><i class="fa fa-bars" ></i></a>';
                if (!empty($pageVars['galeria'])) {
                    $acoes .= '<div class="btn btn-default" onClick="galeria(\'' . $v->getTable() . '\', ' . $v->getId() . ', \'' . htmlspecialchars($v->getTitle()) . '\')" ><i class="fa fa-image" data-toggle="tooltip" title="' . $pageVars['galeria'] . '" ></i></div>';
                }
                $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" data-toggle="tooltip" title="Excluir" ></i></div>';

                $t->addRow('', ['data-id' => $v->getId(), 'data-ordem' => $v->getOrdem()]);

                if (!empty($pageVars['image'])) {
                    $t->addCell('<img src="' . $v->imgCapa()->redimensiona(60, 30, 'proporcional') . '" />', 'text-center');
                }

                $t->addCell($v->getTitle());
                $t->addCell('<div class="btn-group" >'
                    . $acoes
                    . '</div>'
                    , 'text-center');
            }

            echo (new Panel())
                ->setBody('<div class="table-responsive" >' . $t . '</div>');
        }
    }

    /** @return OptionsModel */
    function getModel()
    {
        return OptionsModel::Instance();
    }

    /**
     * Salvando registros
     * @param OptionVO $v
     */
    function save(OptionVO $v)
    {
        try {


            if (!$v->getId()) {
                $v->input('ref');
                $v->input('refid');
                $v->setOrdem($this->getModel()->getLastOrdem($v->getRef()));
            }

            $v
                ->input('title')
                ->Save();

            # Imagem
            if (!empty($pageVars['image'])) {
                $v->imgAddCapa('file_image', null, empty($pageVars['galeria']));
            }

            json('Opção adicionada com sucesso.', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    use excluir;

    /**
     * Reorganizando registros
     */
    function sortableAction()
    {

        $pageVars = Module::getCurrentPage()->getVariaveis(true);

        $ids = stringToArray(inputPost('id'));
        $ordens = stringToArray(inputPost('ordem'));

        if (!empty($ids) and count($ids) == count($ordens)) {
            foreach ($ids as $key => $id) {
                $opt = $this->getModel()->getByLabel('id', $id);
                if (isset($ordens[$key]) and $opt instanceof OptionVO) {
                    if ($opt->getRef() == $pageVars['ref']) {
                        $opt->setOrdem(['ordem' => $ordens[$key]])->save();
                    }
                }
            }
        }

        $this->getModel()->organizaOrdemReferencia($pageVars['ref']);
    }

}
    
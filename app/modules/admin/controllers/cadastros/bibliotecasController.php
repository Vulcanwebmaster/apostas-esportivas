<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 18/08/2017
 * Time: 20:04
 */

namespace app\modules\admin\controllers\cadastros;


use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\Table;
use app\models\BibliotecasModel;
use app\models\helpers\ArquivosModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\vo\BibliotecaVO;

class bibliotecasController extends Controller
{

    use excluir;

    function indexAction()
    {
        $this->view('admin/biblioteca/listar', [
            'isAdm' => Admin::isMaster(),
        ]);
    }

    function save(BibliotecaVO $v)
    {
        try {

            if (!Admin::isMaster()) {
                throw new \Exception('Somente para administradores');
            }

            $novo = !$v->getId();
            $v->save(inputPost());

            ArquivosModel::addArquivo($v, 'upfile');

            HistoricoModel::add($novo ? "Nova biblioteca #{$v->getId()}" : "Alterou as informações da biblioteca #{$v->getId()}", $v, Admin::getLogged());

            return ['message' => 'Salvo', 'result' => 1];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 20];

        $busca = BibliotecasModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table('', "table table-hover table-striped table-bordered sortable");

            $t->addTSection('thead');
            $t->addRow();
            $t->addCell('Arquivo');
            $t->addCell('Formato', ['width' => 90]);
            $t->addCell('Criado em', ['width' => 100]);
            $t->addCell('Ações', ['width' => 150]);
            $t->addTSection('tbody');

            /** @var BibliotecaVO $v */
            foreach ($busca->getRegistros() as $v) {

                $acoes = '';

                $arquivo = ArquivosModel::getArquivo($v);
                $type = 'N/I';

                if ($v->getLink()) {
                    $acoes .= '<a href="' . $v->getLink() . '" class="btn btn-default" target="_blank"><i class="fa fa-download"></i></a>';
                    $type = 'Link';
                } else if ($arquivo) {
                    $acoes .= '<a href="' . $arquivo->getSource(true) . '" class="btn btn-default" target="_blank"><i class="fa fa-download"></i></a>';
                    $type = $arquivo->getExtension();
                }

                if (Admin::isMaster()) {
                    $acoes .= '<div class="btn btn-default" data-editar="' . $v->toHtml(true) . '" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></div>';
                    $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" data-toggle="tooltip" title="Excluir" ></i></div>';
                }


                $t->addRow();
                $t->addCell($v->getTitle());
                $t->addCell($type, 'text-center text-uppercase');
                $t->addCell(Date::formatData($v->getInsert()));
                $t->addCell('<div class="btn-group" >'
                    . $acoes
                    . '</div>'
                    , 'text-center');
            }

            echo (new Panel())
                ->setBody('<div class="table-responsive" >' . $t . '</div>')
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning" >'
                . '<i class="fa fa-warning" ></i> Nenhum registro encontrado'
                . '</div>';
        }
    }

    function getModel()
    {
        return BibliotecasModel::instance();
    }

}
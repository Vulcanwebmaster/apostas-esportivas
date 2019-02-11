<?php

namespace app\modules\admin\controllers\config;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\CotacoesModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\status;
use app\vo\admin\MenuVO;
use app\vo\CotacaoVO;
use Exception;

class cotacoesController extends Controller
{

    use excluir;
    use status;

    function indexAction(MenuVO $p)
    {
        $this->view('admin/cadastros/cotacoes', [
            'grupos' => CotacoesModel::GRUPOS,
        ]);
    }

    function getModel()
    {
        return CotacoesModel::Instance();
    }


    function save(CotacaoVO $v)
    {
        try {

            $nova = !$v->getId();
            $v->Save(inputPost());

            HistoricoModel::add($nova ? "Adicionou uma nova cotação #{$v->getId()}" : "Atualizou a cotação #{$v->getId()}", $v, Admin::getLogged());

            json('Cotação salva com sucesso', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {

        /** @var CotacaoVO[] $cotacoes */
        $cotacoes = CotacoesModel::lista('WHERE a.status != 99 ORDER BY a.ordem ASC, a.titulo ASC');

        $tabelas = [];

        foreach (CotacoesModel::GRUPOS as $grupoId => $grupo) {
            $t = (new Table(null, 'table table-striped table-bordered table-hover'))
                ->addTSection('thead')
                ->addRow()
                ->addCell('<i class="fa fa-sort-amount-asc" ></i>', ['class' => 'text-center', 'width' => 50])
                ->addCell('Cor', ['width' => 30])
                ->addCell('Cotação')
                ->addCell('Ações', ['width' => 120])
                ->addTSection('tbody');

            foreach ($cotacoes as $v) {
                if ($v->getGrupo() == $grupoId) {

                    $status = $v->getStatus() == 1 ? null : '-slash';

                    if ($v->getStatus() != 1) {
                        $class = 'danger';
                    } else {
                        $class = '';
                    }

                    $t
                        ->addRow($class)
                        ->addCell($v->getOrdem(), ['class' => 'text-center', 'style' => $v->getPrincipal() ? 'background-color: #357eba; color: white;' : null])
                        ->addCell($v->getCor(), ['class' => 'text-center', 'style' => 'color: white; background-color: ' . $v->getCor()])
                        ->addCell("<div>{$v->getTitulo()}</div><small>{$v->getSigla()} ({$v->getCampo()})</small>")
                        ->addCell('<div class="btn-group" >'
                            . "<div class='btn btn-default' data-editar=\"{$v}\" ><i class='fa fa-edit'></i></div>"
                            . "<div class='btn btn-default' data-status='{$v->getToken()}' ><i class='fa fa-eye{$status}'></i></div>"
                            . "<div class='btn btn-danger' data-excluir='{$v->getToken()}' ><i class='fa fa-trash'></i></div>"
                            . '</div>', 'text-center');
                }
            }

            $tabelas[] = (new Panel)
                ->setHeader($grupo)
                ->setBody("<div class='table-responsive' >{$t}</div>");
        }

        foreach ($tabelas as $i => $t) {
            if (!$i) {
                echo '<div class="row">';
            } else if ($i % 3 == 0) {
                echo '</div><div class="row">';
            }

            echo '<div class="col-md-4 col-xs-12">' . $t . '</div>';
        }
        echo '</div>';
    }

}
    
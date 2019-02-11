<?php

namespace app\modules\admin\controllers\pagamentos;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\ApostasModel;
use app\modules\admin\Admin;
use app\vo\ApostaVO;

class possiveisController extends Controller
{

    public function indexAction()
    {
        $this->view('admin/pagamento/possivel');
    }

    function listAction()
    {

        $parans = inputPost();

        $parans['possivelganhador'] = 1;

        $busca = ApostasModel::busca($parans, inputPost('page') ?: 1, 20);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Código', ['width' => 70])
                ->addCell('Apostador')
                ->addCell('Valor Apostado', ['width' => 150])
                ->addCell('Valor de Retorno', ['width' => 150])
                ->addCell('Jogos', ['width' => 50])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof ApostaVO) {
                    $acoes = '<div class="btn btn-default" data-apostajogos="' . $v->getToken() . '" ><i class="fa fa-play" data-toggle="tooltip" title="Jogos" ></i> Jogos</div>';
                    $t
                        ->addRow()
                        ->addCell($v->getId(), 'text-center')
                        ->addCell($v->getUserNome())
                        ->addCell('R$ ' . $v->getValor(true), 'text-center')
                        ->addCell('R$ ' . $v->getRetornoValido(true), 'text-center')
                        ->addCell('<div class="btn-group" >'
                            . $acoes
                            . '</div>', 'text-center');
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive' >{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-success no-margin" >'
                . '<i class="fa fa-warning" ></i> Nenhum possível ganhador foi encontrado.'
                . '</div>';
        }
    }

}
    
<?php

namespace app\modules\admin\controllers\apostas;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\ApostasModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\ApostaVO;

class listarController extends Controller
{

    function indexAction()
    {

        $usuarios = null;

        if (Admin::isMaster()) {
            $usuarios = UsersModel::options([UsersModel::TYPE_CLIENTE, UsersModel::TYPE_GERENTE]);
        }

        $this->view('admin/apostas/listar', [
            'type' => 'default',
            'usuarios' => $usuarios,
        ]);
    }

    function listAction()
    {

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 20];

        if (!Admin::isMaster()) {
            $parans['gerente'] = Admin::getIdLogged();
        }

        $busca = ApostasModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Código', ['width' => 70])
                ->addCell('Data e Hora')
                ->addCell('Cambista/Apostador')
                ->addCell('Situação')
                ->addCell('Qtde. Jogos')
                ->addCell('Valor Aposta')
                ->addCell('Valor Retorno')
                ->addCell('Ações', ['width' => 100])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 8])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof ApostaVO) {

                    $acoes = $class = '';

                    $acoes .= '<div class="btn btn-default" data-editar-aposta="' . $v . '" ><i class="fa fa-play" data-toggle="tooltip" title="Jogos" ></i></div>';
                    $acoes .= '<a class="btn btn-default" href="' . $v->getPrintLink() . '" target="_blank" ><i class="fa fa-print" data-toggle="tooltip" title="Imprimir" ></i></a>';

                    if ($v->getVerificado()) {
                        if ($v->get('ganhou')) {
                            if (!$v->getPago() and Admin::isMaster()) {
                                $acoes .= '<div class="btn btn-warning" data-pagar="' . $v->getToken() . '" ><i class="fa fa-money" data-toggle="tooltip" title="Pagar"></i></div>';
                            }
                        }
                    }

                    if (Admin::isMaster() and $v->getStatus() == ApostasModel::STATUS_ATIVA) {
                        $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-trash-o" data-toggle="tooltip" title="Excluir" ></i></div>';
                    }

                    $data = str_replace(' ', ' ás ', substr($v->getInsert(true), 0, -3));
                    $dia = (int)date('w', strtotime($v->getInsert()));
                    $data .= '<br />' . ['Domingo', 'Segunda-feira', 'Terça-feira', 'quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'][$dia];

                    $t
                        ->addRow($v->getStatusClass())
                        ->addCell($v->getId(), 'text-center')
                        ->addCell($data)
                        ->addCell("<div>{$v->getUserNome()} {$v->getUserTelefone()}</div><div>{$v->getApostadorNome()} {$v->getApostadorTelefone()}</div>")
                        ->addCell($v->getStatusTitle())
                        ->addCell($v->getJogos(), 'text-center')
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
            echo <<<HTML
<div class="alert alert-warning no-margin" >
    <i class="fa fa-warning" ></i> Nenhum jogo foi encontrado.
</div>
HTML;
        }
    }

}
    
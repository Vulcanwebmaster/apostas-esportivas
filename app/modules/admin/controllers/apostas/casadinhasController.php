<?php

namespace app\modules\admin\controllers\apostas;

use app\core\Controller;
use app\helpers\Table;
use app\models\ApostasCountCasadinhasModel;
use app\modules\admin\Admin;
use app\vo\ApostaCountCasadinhasVO;
use app\vo\JogoVO;

class casadinhasController extends Controller
{

    function indexAction()
    {
        $this->view('admin/apostas/casadinhas');
    }

    function listAction()
    {

        $busca = ApostasCountCasadinhasModel::busca(extend(inputPost(), []), inputPost('page') ?: 1, 20);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-minified table-hover table-bordered table-striped list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Jogos')
                ->addCell('Total de Apostas', ['width' => 150])
                ->addCell('Valor em Apostas', ['width' => 150])
                ->addCell('Valor de Retorno', ['width' => 150])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof ApostaCountCasadinhasVO) {
                    $t
                        ->addRow()
                        ->addCell($this->tableJogos($v->voJogos()), 'text-center')
                        ->addCell($v->getApostas(), 'text-center')
                        ->addCell('R$ ' . $v->getValor(true), 'text-center')
                        ->addCell('R$ ' . $v->getRetorno(true), 'text-center');
                }
            }

            echo "<div class='table-responsive' >{$t}</div>";
        } else {
            echo '<div class="alert alert-warning" >Nenhuma aposta casada foi encontrada.</div>';
        }
    }

    function tableJogos(array $jogos)
    {
        $html = '';
        foreach ($jogos as $jogo) {
            if ($jogo instanceof JogoVO) {
                if ($jogo->getStatus() == 0) {
                    $placar = "{$jogo->getTimeForaPlacar()} x {$jogo->getTimeForaPlacar()}";
                } else {
                    $placar = " x ";
                }
                $html .= "<div>{$jogo->getTimeCasaTitle()} $placar {$jogo->getTimeForaTitle()}</div>";
            }
        }
        return $html;
    }

}
    
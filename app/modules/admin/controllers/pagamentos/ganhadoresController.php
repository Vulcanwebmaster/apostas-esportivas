<?php

namespace app\modules\admin\controllers\pagamentos;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Table;
use app\models\ApostasModel;
use app\modules\admin\Admin;
use app\vo\ApostaVO;

class ganhadoresController extends Controller
{

    function indexAction()
    {
        $this->view('admin/pagamento/ganhadores');
    }

    function listAction()
    {

        $parans = inputPost();

        if (!Admin::isMaster() or !Admin::isGerente()) {

            # Gerente
            if (Admin::isGerente()) {
                $parans['gerente'] = Admin::getIdLogged();
            }

            # Cambista
            if (Admin::getLogged()->voType()->getRef() == 'cambista') {
                $parans['cambista'] = Admin::getIdLogged();
            }
        }

        $parans['ganhou'] = 1;

        $busca = ApostasModel::busca($parans, inputPost('page') ?: 1, 100);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Código', ['width' => 70])
                ->addCell('Data e Hora')
                ->addCell('Ganhador')
                ->addCell('Qtde. Jogos')
                ->addCell('Valor Apostado')
                ->addCell('Valor a Receber')
                ->addCell('Jogos', ['width' => 120])
                ->addTSection('tbody');

            $totalApostado = $totalReceber = 0;

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof ApostaVO) {

                    $acoes = '<div class="btn btn-default" data-apostajogos="' . $v->getToken() . '" ><i class="fa fa-play" data-toggle="tooltip" title="Jogos" ></i></div>';

                    if (!$v->getPago()) {
                        $classe = 'default';
                    } else {
                        $classe = 'info';
                    }

                    $class = $totalApostado += $v->getValor();
                    $totalReceber += $v->getRetornoValido();

                    $t
                        ->addRow($classe)
                        ->addCell($v->getId(), 'text-center')
                        ->addCell(str_replace(' ', ' ás ', substr($v->getInsert(true), 0, -3)))
                        ->addCell($v->getUserNome())
                        ->addCell($v->getJogos(), 'text-center')
                        ->addCell('R$ ' . $v->getValor(true), 'text-center')
                        ->addCell('R$ ' . $v->getRetornoValido(true), 'text-center')
                        ->addCell('<div class="btn-group" >'
                            . $acoes
                            . '</div>', 'text-center');
                }
            }

            $t
                ->addTSection('tfoot')
                ->addRow()
                ->addCell('<b>Totais:</b>', ['colspan' => 4, 'class' => 'text-right'])
                ->addCell('<b>R$ ' . Number::real($totalApostado) . '</b>', ['class' => 'text-center'])
                ->addCell('<b>R$ ' . Number::real($totalReceber) . '</b>', ['class' => 'text-center'])
                ->addCell('');

            echo (new Panel)
                ->setBody("<div class='table-responsive' >{$t}</div>")
                ->setFooter($busca
                    . '<div class="text-right m-t-xs" >'
                    . '<a href="' . $this->getPrintLink($busca->getRegistros()) . '" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>'
                    . '</div>', ['class' => 'text-right']);
        } else {
            echo <<<HTML
<div class="alert alert-warning no-margin" >
    <i class="fa fa-warning" ></i> Nenhum ganhador foi encontrado.
</div>
HTML;
        }
    }

    /**
     * Retorna o link de impressão
     * @param ApostaVO[] $apostas
     * @return string
     */
    function getPrintLink(array $apostas)
    {
        $url = url('pagamentos/ganhadores/imprimir') . '?apostas=';
        foreach ($apostas as $i => $aposta) {
            if ($i) {
                $url .= ',';
            }
            $url .= $aposta->getId();
        }
        $url .= '&dataInicial=' . Date::formatData(inputPost('dataInicial'));
        $url .= '&dataFinal=' . Date::formatData(inputPost('dataFinal'));
        return $url;
    }

    function imprimirAction()
    {
        view_load('admin/pagamento/ganhadores_print', [
            'apostas' => ApostasModel::lista('WHERE a.id IN(' . inputGet('apostas') . ')'),
        ]);
    }

}
    
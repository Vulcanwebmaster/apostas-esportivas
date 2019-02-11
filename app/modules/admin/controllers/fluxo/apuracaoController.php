<?php

namespace app\modules\admin\controllers\fluxo;

use app\core\Controller;
use app\core\Model;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Table;
use app\models\ApostasModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\ApostaVO;

class apuracaoController extends Controller
{

    function indexAction()
    {
        if (!IS_AJAX) {
            $this->view('admin/fluxo/apuracao', ['parans' => []]);
        } else {
            $this->htmlRelatorio();
        }
    }

    function htmlRelatorio()
    {
        $parans = $this->getParans();

        echo $this->htmlTotais();

        echo '<div class="alert alert-info text-right m-b-lg" >'
            . 'Período <b>' . Date::formatData($parans['dataInicial']) . '</b> até <b>' . Date::formatData($parans['dataFinal']) . '</b>'
            . '</div>';

        if (\app\APP::getAction() != 'imprimirAction') {
            echo '<div class="m-t-md m-b-md">'
                . '<div class="pull-xs-right">'
                . '<a href="' . url('fluxo/apuracao/imprimir', null, null, $this->getParans()) . '" target="_blank" alt="" class="btn btn-info"><i class="fa fa-print"></i> Imprimir</a>'
                . '</div>'
                . '</div>';
        }
    }

    function getParans()
    {
        static $_parans = null;
        if (!$_parans) {
            $_parans = [
                'dataInicial' => Date::data(inputGet('dataInicial')) ?: date('Y-m-d'),
                'dataFinal' => Date::data(inputGet('dataFinal')) ?: date('Y-m-t'),
            ];
        }
        return $_parans;
    }

    /**
     *
     * @return string
     */
    function htmlTotais()
    {

        $totais = $this->totaisApostas();
        $html = '';

        if ($totais) {
            $t = new Table(null, 'table table-bordered table-hover table-striped list-table');
            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell("Data")
                ->addCell('Apostas')
                ->addCell('Qtd. Jogos')
                ->addCell('Valor Apostado')
                ->addCell('Apostas Pagas')
                ->addCell('Líquido')
                ->addTSection('tbody');

            $liquido = $comissoes = $valores = $jogos = $apostas = $apostasPagas = 0;

            foreach ($totais as $total) {

                $apostas += (int)$total['apostas'];
                $jogos += (int)$total['totalJogos'];
                $valores += (float)$total['valor'];
                $liquido += (float)$total['liquido'];
                $apostasPagas += (float)$total['apostasPagas'];

                $t
                    ->addRow()
                    ->addCell(Date::formatData($total['data']), 'text-center')
                    ->addCell($total['apostas'], 'text-center')
                    ->addCell($total['totalJogos'], 'text-center')
                    ->addCell('R$ ' . Number::real($total['valor']), 'text-center btn-info')
                    ->addCell('R$ ' . Number::real($total['apostasPagas']), 'text-center btn-danger')
                    ->addCell('R$ ' . Number::real($total['liquido']), 'text-center btn-' . ((float)$total['liquido'] > 0 ? 'success' : 'danger'));
            }

            $t
                ->addTSection('tfoot')
                ->addRow()
                ->addCell('Total', 'text-right')
                ->addCell($apostas, 'text-center')
                ->addCell($jogos, 'text-center')
                ->addCell('R$ ' . Number::real($valores), 'text-center')
                ->addCell('R$ ' . Number::real($apostasPagas), 'text-center')
                ->addCell('R$ ' . Number::real($liquido), 'text-center');

            $html .= (new Panel)
                ->setBody("<div class='table-responsive' >{$t}</div>");

            # Por jogo
            foreach ($totais as $total) {
                $t = (new Table(null, 'table table-bordered table-hover table-striped list-table'))
                    # thead
                    ->addTSection('thead')
                    ->addRow()
                    ->addCell('Número de jogos')
                    ->addCell('Número de Apostas')
                    ->addCell('Valor Apostado')
                    # tbody
                    ->addTSection('tbody')
                    ->addRow()
                    ->addCell('1', 'text-center')
                    ->addCell($total['jogos1'], 'text-center')
                    ->addCell('R$ ' . Number::real($total['jogosValor1']), 'text-center')
                    ->addRow()
                    ->addCell('2', 'text-center')
                    ->addCell($total['jogos2'], 'text-center')
                    ->addCell('R$ ' . Number::real($total['jogosValor2']), 'text-center')
                    ->addRow()
                    ->addCell('3, 4, 5', 'text-center')
                    ->addCell($total['jogos3'], 'text-center')
                    ->addCell('R$ ' . Number::real($total['jogosValor3']), 'text-center')
                    ->addRow()
                    ->addCell('6, 7, 8, 9, 10', 'text-center')
                    ->addCell($total['jogos4'], 'text-center')
                    ->addCell('R$ ' . Number::real($total['jogosValor4']), 'text-center')
                    ->addRow()
                    ->addCell('11 ou mais', 'text-center')
                    ->addCell($total['jogos5'], 'text-center')
                    ->addCell('R$ ' . Number::real($total['jogosValor5']), 'text-center')
                    # tfoot
                    ->addTSection('tfoot')
                    ->addRow()
                    ->addCell('Total', 'text-right')
                    ->addCell((int)$total['jogos1'] + (int)$total['jogos2'] + (int)$total['jogos3'] + (int)$total['jogos4'] + (int)$total['jogos5'], 'text-center')
                    ->addCell('R$ ' . Number::real((float)$total['jogosValor1'] + (float)$total['jogosValor2'] + (float)$total['jogosValor3'] + (float)$total['jogosValor4'] + (float)$total['jogosValor5']), 'text-center');

                $html .= (new Panel)
                    ->setHeader('<h3 class="panel-title" >Apostas: ' . Date::formatData($total['data']) . '</h3>')
                    ->setBody("<div class='table-responsive' >{$t}</div>");
            }
        }

        return $html;
    }

    /**
     *
     * @param int $jogos
     * @return array
     */
    function totaisApostas()
    {
        $tApostas = ApostasModel::getTable();
        $tUsers = UsersModel::getTable();
        $parans = $this->getParans();

        $query = <<<SQL
SELECT DISTINCT 
    COUNT(*) AS apostas, a.data, SUM(a.jogos) AS totalJogos, 
    SUM(a.valor) AS valor, 
    SUM(IF(a.nivelbonuscomissao = 1, 1, 0)) AS jogos1, SUM(IF(a.nivelbonuscomissao = 2, 1, 0)) AS jogos2, SUM(IF(a.nivelbonuscomissao = 3, 1, 0)) jogos3, SUM(IF(a.nivelbonuscomissao = 4, 1, 0)) jogos4, SUM(IF(a.nivelbonuscomissao = 5, 1, 0)) jogos5, 
    SUM(IF(a.nivelbonuscomissao = 1, a.valor, 0)) AS jogosValor1, SUM(IF(a.nivelbonuscomissao = 2, a.valor, 0)) AS jogosValor2, SUM(IF(a.nivelbonuscomissao = 3, a.valor, 0)) jogosValor3, SUM(IF(a.nivelbonuscomissao = 4, a.valor, 0)) jogosValor4, SUM(IF(a.nivelbonuscomissao = 5, a.valor, 0)) jogosValor5, 
    SUM(IF(a.ganhou = 1 AND a.acertos >= a.jogos AND a.erros = 0 AND a.acertos = a.jogosverificados, a.retornovalido, 0)) AS apostasPagas, 
    SUM(a.valor - IF(a.ganhou = 1, a.retornovalido, 0)) AS liquido 

FROM 
  `{$tApostas}` AS a 

WHERE 
  (a.data BETWEEN :dataInicial AND :dataFinal) AND a.status = 1 

GROUP BY 
  a.data 
SQL;


        $busca = Model::pdoRead()->FullRead($query, $parans)->getResult();

        return $busca;
    }

    /**
     *
     * @return ApostasModel
     */
    function htmlGanhadores()
    {

        $ganhadores = ApostasModel::busca(['ganhou' => 1] + $this->getParans());

        if ($ganhadores->getCount()) {

            $t = new Table(null, 'table table-bordered table-hover table-striped list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Código')
                ->addCell('Ganhador')
                ->addCell('Data')
                ->addCell('Qtd. Jogos')
                ->addCell('Valor Apostado')
                ->addCell('Valor a Receber')
                ->addTSection('tbody');

            $total = 0;

            foreach ($ganhadores->getRegistros() as $v) {
                if ($v instanceof ApostaVO) {
                    $total += $v->getRetornoValido();
                    $t
                        ->addRow()
                        ->addCell($v->getId(), 'text-center')
                        ->addCell($v->getUserNome())
                        ->addCell($v->getData(true), 'text-center')
                        ->addCell($v->getJogos(), 'text-center')
                        ->addCell('R$ ' . $v->getValor(true), 'text-center')
                        ->addCell('R$ ' . $v->getRetornoValido(true), 'text-center');
                }
            }

            $t
                ->addTSection('tfoot')
                ->addRow()
                ->addCell('Total', ['colspan' => 5, 'class' => 'text-right'])
                ->addCell('R$ ' . Number::real($total), 'text-center');


            return (new Panel)
                ->setHeader('<h3 class="panel-title" >Apostas Ganhas</h3>')
                ->setBody("<div class='table-responsive' >{$t}</div>", ['class' => 'p-0']);
        } else {
            return '<div class="alert alert-info" >'
                . '<i class="fa fa-info" ></i> Nenhum ganhador no período.'
                . '</div>';
        }
    }

    function imprimirAction()
    {
        ob_start();
        $this->htmlRelatorio();
        $this->view('admin/fluxo/imprimir', [
            'body' => ob_get_clean(),
        ]);
    }

}
    
<?php

namespace app\modules\admin\controllers\fluxo;

use app\core\Controller;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\models\ApostasModel;

class caixaController extends Controller
{

    public function indexAction()
    {
        if ($this->getParans()) {
            $this->view('admin/fluxo/fluxo', [
                'result' => $this->calculaTotais(),
                'parans' => $this->getParans(),
            ]);
        } else {
            $this->view('admin/fluxo/fluxo', [
                'parans' => [],
            ]);
        }
    }

    private function getParans()
    {
        $dtInicial = Date::data(inputGet('dataInicial'));
        $dtFinal = Date::data(inputGet('dataFinal'));
        if ($dtInicial and $dtFinal) {
            return [
                'dataInicial' => $dtInicial,
                'dataFinal' => $dtFinal,
            ];
        } else {
            return [];
        }
    }

    /**
     * Calcula os totais da região do periodo especificado
     * @return array [[data, apostas, comissoes, totalApostas, totalPerdido]]
     */
    public function calculaTotais()
    {

        $parans = $this->getParans();

        $query = new BuildQuery(ApostasModel::getTable(), 'a');

        $query->setSelectFields([
            'a.data',
            'COUNT(*) AS countApostas',
            'SUM(a.valor) valorApostas',
            'SUM(IF(a.ganhou = 1 AND a.acertos >= a.jogos AND a.erros = 0 AND a.acertos = a.jogosverificados, a.retornovalido, 0)) pagoApostas',
            'SUM(a.jogos) AS qtd_jogos'
        ]);

        $query->setWhere('a.data BETWEEN :dataInicial AND :dataFinal AND a.status = 1 ');
        $query->setGroup(['a.data']);

        $totais = $query->execute($parans);

        foreach ($totais as $key => $values) {
            $totais[$key]['liquido'] = $values['valorApostas'] - $values['pagoApostas'];
            $totais[$key]['fdata'] = Date::formatData($values['data']);
        }

        return $totais;
    }

    function imprimirAction()
    {
        $totais = $this->calculaTotais();
        $this->view('admin/fluxo/imprimir', [
            'result' => $totais,
        ]);
    }

}
    
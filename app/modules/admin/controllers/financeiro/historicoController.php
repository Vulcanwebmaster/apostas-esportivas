<?php

namespace app\modules\admin\controllers\financeiro;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Table;
use app\models\HistoricoBancarioModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\HistoricoBancarioVO;

class historicoController extends Controller
{

    function indexAction()
    {

        $users = [];

        if (Admin::isMaster()) {
            $users = UsersModel::busca(['status' => 1], 0, 0)->getRegistros();
        } else if (Admin::isGerente()) {
            $users = UsersModel::busca(['status' => 1, 'user' => Admin::getIdLogged()], 0, 0)->getRegistros();
        }

        $this->view('admin/financeiro/historico', [
            'users' => $users,
        ]);
    }

    function listAction()
    {
        $user = Admin::getLogged();

        $parans = ['status' => 1, 'user' => $user->getId()];

        if (inputPost('user')) {
            if (Admin::isGerente() or Admin::isMaster()) {
                $parans['user'] = inputPost('user');
            }
        }

        $parans += inputPost();
        $parans += ['page' => 1, 'forpage' => 9999];

        $fncSinal = function ($valor, $isReal = false) {
            $formatado = Number::real(abs($valor));
            $sinal = $valor < 0 ? '-' : ($valor == 0 ? '' : '+');
            $prefixo = $isReal ? "{$sinal} R$ " : "{$sinal}";
            return $prefixo . $formatado;
        };

        $busca = HistoricoBancarioModel::busca($parans, $parans['page'], $parans['forpage']);

        $t = new Table(null, 'table table-striped table-bordered table-hover');

        $t
            ->addTSection('thead')
            ->addRow()
            ->addCell('Código', ['width' => 100])
            ->addCell('Data', ['width' => 180])
            ->addCell('Descrição')
            ->addCell('Créditos e Débitos', ['width' => 200])
            ->addTSection('tbody');

        if (empty($parans['search'])) {

            $data = new \DateTime(Date::data($parans['dataInicial']));
            $data->modify('-1day');

            $resumoAnterior = HistoricoBancarioModel::getSaldo($user, $data);

            $t->addRow()
                ->addCell('-/-', 'text-center')
                ->addCell($data->format('d/m/Y'), 'text-center')
                ->addCell('Resumo anterior')
                ->addCell($fncSinal($resumoAnterior['creditos'], true), 'text-right');
        }

        $totais = [
            'credito' => $resumoAnterior['creditos'] ?? 0 ?: 0,
            'debito' => 0,
        ];

        /** @var HistoricoBancarioVO $v */
        foreach ($busca->getRegistros() as $v) {

            $totais[$v->getValor() < 0 ? 'debito' : 'credito'] += abs($v->getValor());

            $class = $v->getValor() > 0 ? '' : 'danger';

            $t
                ->addRow('text-' . $class)
                ->addCell($v->getId(), 'text-center')
                ->addCell(str_replace(' ', ' - ', $v->getInsert(true)), 'text-center')
                ->addCell($v->getDescricao())
                ->addCell($fncSinal($v->getValor(), true) . '<div><small>' . $fncSinal($v->getSaldoCreditos(), true) . '</small></div>', 'text-right');
        }

        $t
            ->addTSection('tfoot')
            ->addRow()
            ->addCell('Créditos', ['colspan' => 3, 'class' => 'text-right'])
            ->addCell($fncSinal($totais['credito'], true), 'text-right')
            ->addRow('text-danger')
            ->addCell('Débitos', ['colspan' => 3, 'class' => 'text-right'])
            ->addCell($fncSinal($totais['debito'] * -1, true), 'text-right')
            ->addRow()
            ->addCell('Total', ['colspan' => 3, 'class' => 'text-right'])
            ->addCell($fncSinal($totais['credito'] - $totais['debito'], true), 'text-right');

        echo (new Panel())
            ->setBody("<div class='table-responsive'>{$t}</div>");
    }

}
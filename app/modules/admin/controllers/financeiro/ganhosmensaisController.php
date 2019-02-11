<?php

namespace app\modules\admin\controllers\financeiro;

use app\core\Controller;
use app\helpers\Number;
use app\helpers\PanelBootstrap;
use app\helpers\Table;
use app\models\GanhosMensaisModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\GanhoMensalVO;
use app\vo\UserVO;

class ganhosmensaisController extends Controller
{

    function indexAction()
    {
        $this->view('admin/financeiro/ganhosmensais');
    }

    function insertAction()
    {
        try {

            if (!Admin::isMaster()) {
                throw new \Exception("Somente administradores");
            }

            /** @var GanhoMensalVO $lacamento */
            $lacamento = GanhosMensaisModel::newValueObject();

            $comissoes = 0;

            $lacamento->input('datainicio');
            $lacamento->input('datafim');
            $lacamento->input('valor');
            $lacamento->save();

            /** @var UserVO[] $users */
            $users = UsersModel::lista('WHERE a.status = 1 AND a.participacao > 0');

            foreach ($users as $user) {
                if ($user->estaEmDia()) {

                    $comissao = $lacamento->getValor() * $user->getParticipacao() / 100;
                    $comissoes += $comissao;

                    HistoricoBancarioModel::add($user, $comissao, "PARTICIPAÇÃO: Bônus de participação {$user->getParticipacao()}%", $lacamento, "participacao");

                }
            }

            if ($comissoes) {
                $lacamento->setComissao($comissoes);
                $lacamento->save();
            }

            HistoricoModel::add("Registrou o ganho do periodo {$lacamento->getDataInicio(true)} até {$lacamento->getDataFim(true)}", $lacamento, Admin::getLogged());

            return [
                'result' => 1,
                'message' => 'Lançamento realizado com sucesso',
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {

        $parans = inputPost();

        $parans += ['page' => 1, 'forpage' => 30];

        $busca = GanhosMensaisModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-bordered table-hover');

            $totais = [
                'valor' => 0,
                'comissao' => 0,
                'liquido' => 0,
            ];

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('#', ['width' => 70])
                ->addCell('Data Lançamento')
                ->addCell('Período')
                ->addCell('Valor')
                ->addCell('Comissões')
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 10])
                ->addTSection('tbody');

            /** @var GanhoMensalVO $v */
            foreach ($busca->getRegistros() as $v) {

                $totais['valor'] += $v->getValor();
                $totais['comissao'] += $v->getComissao();
                $totais['liquido'] += $v->getLiquido();

                $t
                    ->addRow()
                    ->addCell($v->getId(), 'text-center')
                    ->addCell(str_replace(' ', ' às ', $v->getInsert(true)), 'text-center')
                    ->addCell("{$v->getDataInicio(true)} até {$v->getDataFim(true)}", 'text-center')
                    ->addCell('R$ ' . $v->getValor(true), 'text-center text-success')
                    ->addCell('R$ ' . $v->getComissao(true), 'text-center text-danger');
            }

            $t
                ->addTSection('tfoot')
                ->addRow()
                ->addCell('Subtotal', 'text-right', null, ['colspan' => 4])
                ->addCell('R$ ' . Number::real($totais['valor']), 'text-center')
                ->addRow('text-danger')
                ->addCell('Comissões', 'text-right', null, ['colspan' => 4])
                ->addCell('R$ ' . Number::real($totais['comissao']), 'text-center')
                ->addRow('text-success')
                ->addCell('Líquido', 'text-right', null, ['colspan' => 4])
                ->addCell('R$ ' . Number::real($totais['liquido']), 'text-center');

            echo (new PanelBootstrap())
                ->setBody($t)
                ->setFooter($busca, ['class' => 'text-right']);

        } else {

            echo <<<HTML
<div class="alert alert-warning">
    Nenhum lançamento realizado até o momento.
</div>
HTML;


        }
    }

}
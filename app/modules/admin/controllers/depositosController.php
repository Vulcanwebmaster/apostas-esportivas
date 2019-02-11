<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 04/08/2017
 * Time: 14:23
 */

namespace app\modules\admin\controllers;


use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\Number;
use app\helpers\PanelBootstrap;
use app\helpers\Table;
use app\models\DadosModel;
use app\models\financeiro\DepositosModel;
use app\models\helpers\ArquivosModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\financeiro\DepositoVO;

class depositosController extends Controller
{

    function indexAction()
    {
        $this->view('admin/depositos', [
            'isAdm' => $this->isAdm(),
            'user' => Admin::getLogged(),
            'title' => 'Depósitos',
        ]);
    }

    function isAdm()
    {
        switch (Admin::getLogged()->getType()) {
            case UsersModel::TYPE_DEVELOPER:
            case UsersModel::TYPE_MASTER:
            case UsersModel::TYPE_ADMINISTRADOR:
                return true;
                break;
            default:
                return false;
        }
    }

    function confirmarAction()
    {
        try {

            if (!$this->isAdm()) {
                throw new \Exception('Somente administradores podem realizar essa alteração');
            }

            $deposito = DepositosModel::getByLabel('token', inputPost('deposito'));

            if (!$deposito instanceof DepositoVO) {
                throw new \Exception('Depósito inválido');
            } else if ($deposito->getStatus() != 1) {
                throw new \Exception('Depósito não pode mais ser alterado');
            }

            $deposito->setStatus(inputPost('valor'));
            $deposito->save();

            if ($deposito->getStatus() == DepositosModel::STATUS_APROVADO) {
                $user = $deposito->voUser();
                HistoricoBancarioModel::add($user, $deposito->getValor(), "<b>DEPÓSITO</b> - Depósito aprovado (#{$deposito->getId()})", $deposito, "deposito");
            }

            return [
                'message' => 'Alterado com sucesso',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function save(DepositoVO $deposito)
    {
        try {

            if ($deposito->getId()) {
                throw new \Exception('Um depósito não pode ser alterado');
            }

            Conn::startTransaction();

            $user = Admin::getLogged();

            if (empty($_FILES['upcomprovante']) or !is_uploaded_file($_FILES['upcomprovante']['tmp_name'])) {
                throw new \Exception('Envie o comprovante anexado.');
            }

            $deposito->setUser($user->getId());
            $deposito->save(inputPost());

            ArquivosModel::addArquivo($deposito, 'upcomprovante');

            HistoricoModel::add("Registrou um depósito #{$deposito->getId()} no valor de R$ {$deposito->getValor(true)}", $deposito, $user);

            Conn::commit();

            return [
                'message' => 'Seu depósito entregou em análise, assim que for aprovado o saldo será liberado.',
                'result' => 1,
            ];

        } catch (\Exception $ex) {
            Conn::rollBack();
            return $ex;
        }
    }

    function listAction()
    {

        $parans = inputPost();

        if (!$this->isAdm()) {
            $parans['user'] = Admin::getIdLogged();
        }

        $parans += ['page' => 1, 'forpage' => 30];

        $busca = $this->getModel()->busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-bordered table-hover');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('#', ['width' => 70])
                ->addCell('Data', ['width' => 120])
                ->addCell('Cliente/CPF')
                ->addCell('Valor', ['width' => 150])
                ->addCell('Situação')
                ->addCell('Ações', $this->isAdm() ? ['width' => 160] : false)
                ->addTSection('tbody');

            $total = 0;

            /** @var DepositoVO $v */
            foreach ($busca->getRegistros() as $v) {

                $user = $v->voUser();

                $acoes = '';

                if ($this->isAdm()) {

                    if ($arquivo = ArquivosModel::getArquivo($v)) {
                        $acoes .= "<a target='_blank' href='{$arquivo->getSource(true)}' class='btn btn-success' ><i class='fa fa-download'></i></a>";
                    }

                    if ($v->getStatus() == 1) {
                        $acoes .= "<div class='btn btn-success' data-confirmar='{$v->getToken()}' data-value='2'><i class='fa fa-check'></i></div>";
                        $acoes .= "<div class='btn btn-danger' data-confirmar='{$v->getToken()}' data-value='0'><i class='fa fa-times'></i></div>";
                    }
                }

                $total += $v->getValor();

                $t
                    ->addRow()
                    ->addCell($v->getId(), 'text-center')
                    ->addCell($v->getData(true), 'text-center')
                    ->addCell("{$user->getNome()} ({$user->getLogin()})<br />{$user->getCpf()}")
                    ->addCell('R$ ' . $v->getValor(true), 'text-center')
                    ->addCell($v->getStatusTitle(), 'text-center')
                    ->addCell('<div class="btn-group">' . $acoes . '</div>', $this->isAdm() ? 'text-center' : false);
            }

            $t
                ->addTSection('tfoot')
                ->addRow()
                ->addCell('Total', 'text-right', null, ['colspan' => 3])
                ->addCell('R$ ' . Number::real($total), 'text-center')
                ->addCell('', ['colspan' => 2])
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 10]);

            echo (new PanelBootstrap())
                ->setBody($t)
                ->setFooter($busca, ['class' => 'text-right']);

        } else {

            echo <<<HTML
<div class="alert alert-warning">
    Nenhum depósito encontrado
</div>
HTML;

        }
    }

    function getModel()
    {
        return DepositosModel::instance();
    }

}
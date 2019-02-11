<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 04/08/2017
 * Time: 14:25
 */

namespace app\modules\admin\controllers;


use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\PanelBootstrap;
use app\helpers\Table;
use app\models\financeiro\SaquesModel;
use app\models\helpers\ArquivosModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\financeiro\SaqueVO;

class saquesController extends Controller
{

    function indexAction()
    {
        $this->view('admin/saques', [
            'isAdm' => $this->isAdm(),
        ]);
    }

    function isAdm()
    {
        switch (Admin::getLogged()->getType()) {
            case UsersModel::TYPE_DEVELOPER:
            case UsersModel::TYPE_ADMINISTRADOR:
            case UsersModel::TYPE_MASTER:
                return true;
                break;
            default:
                return false;
        }
    }

    function csvAction()
    {
        if (Admin::isMaster()) {

            ob_clean();

            $data = date('Y-m-d');


            header('Content-type: text/csv; charset=ISO-8859-1');
            header("Content-disposition: Attachment; filename=saques-{$data}.csv");

            $termos = 'WHERE a.status != 99';

            $places = [];

            if (inputPost('status') !== '') {
                $termos .= ' AND a.status = :status';
                $places['status'] = inputPost('status');
            }

            if ($value = Date::data(inputPost('dataInicial'))) {
                $termos .= " AND a.data >= :dataInicial";
                $places['dataInicial'] = $value;
            }

            if ($value = Date::data(inputPost('dataFinal'))) {
                $termos .= " AND a.data <= :dataFinal";
                $places['dataFinal'] = $value;
            }

            /** @var SaqueVO[] $saques */
            $saques = SaquesModel::lista($termos, $places);

            echo "id;tipo;valor;banco;agencia;conta;tipoconta;variacao;nome;cpf;cnpj;picpay";

            $total = 0;

            /** @var SaqueVO $v */
            foreach ($saques as $v) {

                $total += $v->getValor();

                $values = [
                    $v->getId(),
                    $v->getTipo(),
                    'R$ ' . $v->getValor(true),
                    $v->getBanco(),
                    $v->getAgencia(),
                    $v->getConta(),
                    $v->getContaTipo(),
                    $v->getVariacao(),
                    $v->getNomeCompleto(),
                    $v->getCpf(),
                    $v->getCnpj(),
                    $v->getPicpay(),
                ];

                echo PHP_EOL;
                echo utf8_decode(implode(";", $values));
            }

            echo PHP_EOL . "Total: R$ " . Number::real($total);

        } else {
            location();
        }

    }

    function dadosbancariosAction()
    {
        return [
            'dados' => Admin::getLogged()->getDadosBancarios(true),
            'result' => 1,
        ];
    }

    function listAction()
    {

        $parans = inputPost();

        if (!$this->isAdm()) {
            $parans['user'] = Admin::getIdLogged();
        }

        $parans += ['page' => 1, 'forpage' => 500];

        $busca = $this->getModel()->busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-bordered table-hover');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('#', ['width' => 70])
                ->addCell('Data', ['width' => 120])
                ->addCell('Cliente/Conta')
                ->addCell('Valor', ['width' => 120])
                ->addCell('Situação')
                ->addCell('Ações', $this->isAdm() ? ['width' => 160] : false)
                ->addTSection('tbody');

            $total = 0;

            /** @var SaqueVO $v */
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

                $documento = $v->getCpf() ?: $v->getCnpj();

                if ($v->getTipo() == 'picpay') {
                    $dadosConta = "<div>Picpay: {$v->getPicpay()}</div>";
                } else {
                    $dadosConta = <<<HTML
<div>{$user->getNome()} - {$user->getLogin()} - {$user->getCpf()}</div>
<hr class="m-0" />
<div bt-1><b>AG:</b> {$v->getAgencia()} / <b>Conta:</b> {$v->getConta()} / <b>Banco:</b> {$v->getBanco()}</div>
<div><b>Cliente:</b> {$v->getNomeCompleto()} / <b>Documento:</b> {$documento}</div>
<div><b>Tipo de conta:</b> {$v->getContaTipo()} / <b>Variação:</b> {$v->getVariacao()}</div>
HTML;
                }

                $total += $v->getValor();


                $t
                    ->addRow()
                    ->addCell($v->getId(), 'text-center')
                    ->addCell($v->getData(true), 'text-center')
                    ->addCell($dadosConta)
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
    Nenhum saque encontrado
</div>
HTML;

        }
    }

    function getModel()
    {
        return SaquesModel::instance();
    }

    function confirmarAction()
    {
        try {

            Conn::startTransaction();

            if (!$this->isAdm()) {
                throw new \Exception('Somente administradores');
            }

            $saque = SaquesModel::getByLabel('token', inputPost('saque'));
            $status = (int)inputPost('valor');

            if (!$saque instanceof SaqueVO) {
                throw new \Exception('Saque inválido');
            } else if ($saque->getStatus() != 1) {
                throw new \Exception('Saque não pode mais ser alterado');
            }

            if ($status == SaquesModel::STATUS_APROVADO) {
                ArquivosModel::addArquivo($saque, 'comprovante');
                $saque->setStatus(SaquesModel::STATUS_APROVADO);
                HistoricoModel::add("Confirmou o saque #{$saque->getId()}", $saque, Admin::getLogged());
            } else {
                $valorExtorno = $saque->getValor() + $saque->getTaxa();
                $saque->setStatus(SaquesModel::STATUS_DESAPROVADO);
                HistoricoBancarioModel::add($saque->voUser(), $valorExtorno, "<b>SAQUE</b> - Saque (#{$saque->getId()}) - Não foi possível realizar o saque", $saque, "estorno");
                HistoricoModel::add("Reprovou o saque #{$saque->getId()}", $saque, Admin::getLogged());
            }

            $saque->save();


            Conn::commit();

            return [
                'message' => 'Realizado',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            Conn::rollBack();

            return $ex;
        }
    }

    function save(SaqueVO $saque)
    {
        try {

            if ($saque->getId()) {
                throw new \Exception('Não é possível atualizar um saque');
            }

            $user = Admin::getLogged();
            $saque->setUser($user->getId());
            $saque->set(inputPost());

            if (inputPost('principal')) {
                $saque
                    ->voUser()
                    ->setDadosBancarios([
                        'tipo' => $saque->getTipo(),
                        'agencia' => $saque->getAgencia(),
                        'conta' => $saque->getConta(),
                        'banco' => $saque->getBanco(),
                        'nomecompleto' => $saque->getNomeCompleto(),
                        'cpf' => $saque->getCpf(),
                        'cnpj' => $saque->getCnpj(),
                        'contatipo' => $saque->getContaTipo(),
                        'variacao' => $saque->getVariacao(),
                    ])->save();
            }

            SaquesModel::addSaque($saque);

            HistoricoModel::add("Solicitou um saque no valor de R$ {$saque->getValor(true)}", $saque, $user);

            return [
                'result' => 1,
                'message' => 'Saque solicitado com sucesso.',
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}

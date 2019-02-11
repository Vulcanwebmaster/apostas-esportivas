<?php

namespace app\modules\admin\controllers\apostas;

use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\Table;
use app\models\ApostaJogosModel;
use app\models\ApostasModel;
use app\models\CotacoesModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\vo\ApostaJogoVO;
use app\vo\ApostaVO;
use app\vo\CotacaoVO;
use Exception;

class apostaController extends Controller
{

    /**
     * Impressão da Aposta
     */
    function imprimirAction()
    {

        ini_set('max_execution_time', 5);

        $aposta = ApostasModel::getByLabel('token', url_parans(0));
        if ($aposta instanceof ApostaVO) {

            $html = $this->view('admin/apostas/pdf', [
                'aposta' => $aposta,
            ], null, true);

            displayPdf($html, 'aposta-' . $aposta->getId(), 300, 500);

        } else {
            exit('Aposta inválida.');
        }
    }

    function excluirAction()
    {
        try {

            if (!Admin::isMaster())
                throw new Exception("Somente administradores");

            $aposta = ApostasModel::getByLabel('token', inputPost('id'));
            if (!$aposta instanceof ApostaVO) {
                throw new Exception("Aposta inváldida");
            }

            if ($aposta->getStatus() == ApostasModel::STATUS_ATIVA) {
                # Extornando valor da aposta
                HistoricoBancarioModel::add($aposta->voUser(), $aposta->getValor(), "Cancelamento de aposta #{$aposta->getId()}", $aposta, 'cancelamento');
                # Extornando prêmio
                if ($aposta->getGanhou() and $aposta->getPago()) {
                    HistoricoBancarioModel::add($aposta->voUser(), -$aposta->getRetornoValido(), "Extorno de prêmio por aposta cancelada #{$aposta->getId()}", $aposta, 'cancelamento');
                }
            }

            $aposta
                ->setStatus(ApostasModel::STATUS_CANCELADA)
                ->save();

            return [
                'message' => 'Aposta cancelada com sucesso',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function cancelarAction()
    {
        try {

            $aposta = ApostasModel::getByLabel('token', inputPost('aposta'));
            if (!$aposta instanceof ApostaVO) {
                throw new Exception("Aposta inválida");
            } else if (!Admin::isMaster() and $aposta->getUser() != Admin::getIdLogged()) {
                throw new Exception("Você não tem permissão para cancelar essa aposta");
            } else if (!$aposta->getIsEditavel()) {
                throw new Exception("Não é possível cancelar essa aposta");
            }

            foreach ($aposta->voJogos() as $a) {
                if (!$a->getIsEditavel()) {
                    throw new Exception("Não será possível cancelar o jogo `{$a->voJogo()->getDescricao()}`");
                }
            }

            $valor = $aposta->getValor();

            HistoricoBancarioModel::add($aposta->voUser(), $valor, "<b>APOSTA</b> - Reembolso de cancelamento da Aposta (#{$aposta->getId()})", $aposta, "cancelamento");
            HistoricoBancarioModel::add($aposta->voUser(), -$valor * 0.1, "<b>TARIFA</b> - Tarifa referente ao cancelamento da Aposta (#{$aposta->getId()})", $aposta, "cancelamento");

            $aposta->setStatus(ApostasModel::STATUS_CANCELADA);
            $aposta->save();

            return [
                'message' => 'Aposta cancelada com sucesso',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function pagamentoAction()
    {
        try {

            Conn::startTransaction();

            if (!Admin::isMaster()) {
                throw new Exception("Somente um administrador/master pode antecipar o pagamento de uma aposta.");
            }

            $aposta = ApostasModel::getByLabel('token', inputPost('aposta'));
            if (!$aposta instanceof ApostaVO) {
                throw new Exception("Aposta inválida");
            } else if ($aposta->getPago()) {
                throw new Exception("Aposta já recebeu o pagamento");
            } else if (!$aposta->getGanhou()) {
                throw new Exception("Aposta não foi premiada");
            }

            // Registrando a atencipação
            $admin = Admin::getLogged();
            HistoricoModel::add("O usuário `{$admin->getLogin()}` antecipou o prêmio da aposta #{$aposta->getId()}", $aposta, $admin);

            // Adicionando o prêmio
            HistoricoBancarioModel::add($aposta->voUser(), $aposta->getRetornoValido(), "<b>PRÊMIO</b> - Prêmio referente a Aposta (#{$aposta->getId()})", $aposta, "premio");

            $termos = <<<SQL
UPDATE `{$aposta->getTable()}` AS a
SET a.databaixa = :hoje, a.update = :update, a.possivelganhador = 0, a.pago = 1
WHERE a.id = {$aposta->getId()}
SQL;

            $places = [
                'hoje' => date("Y-m-d"),
                'update' => __NOW__,
            ];

            Conn::getConn()->prepare($termos)->execute($places);

            Conn::commit();

            return [
                'message' => 'Pagamento antecipado com sucesso',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            Conn::rollBack();
            return $ex;
        }
    }

    function cancelarjogoAction()
    {
        try {

            Conn::startTransaction();

            $aposta = ApostasModel::getByLabel('token', inputPost('aposta'));

            $jogo = ApostaJogosModel::getByLabel('token', inputPost('jogo'));

            if (!$aposta instanceof ApostaVO) {
                throw new Exception("Aposta inválida");
            } else if (!Admin::isMaster() and $aposta->getUser() != Admin::getIdLogged()) {
                throw new Exception("Você não tem permissão para cancelar essa aposta");
            } else if (!$jogo instanceof ApostaJogoVO) {
                throw new Exception("Jogo inválido");
            }

            ApostasModel::cancelarJogo($jogo);

            Conn::commit();

            return [
                'aposta' => $aposta->toArray(true),
                'message' => 'Cancelamento realizado com sucesso',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            Conn::rollBack();
            return $ex;
        }
    }

    function editarAction()
    {
        try {

            $aposta = ApostasModel::getByLabel('token', url_parans(0));

            if (!$aposta instanceof ApostaVO) {
                throw new Exception("Aposta inválida");
            } else if (!Admin::isMaster() and $aposta->getUser() != Admin::getIdLogged()) {
                throw new Exception("Permissão inválida");
            }


        } catch (Exception $ex) {
            location(url_referer());
        }
    }

    function jogosAction()
    {
        try {

            $aposta = ApostasModel::getByLabel('token', url_parans(0));
            if (!$aposta instanceof ApostaVO) {
                throw new Exception('Aposta inválida');
            }

            $voJogos = $aposta->voJogos(true);
            $editavel = $aposta->getIsEditavel() ? true : false;
            $comecou = false;

            $jogos = [];

            foreach ($voJogos as $a) {

                $jogo = $a->voJogo();

                if ($editavel and !$a->getIsEditavel()) {
                    $editavel = false;
                }

                if ($jogo->jaComecou()) {
                    $comecou = true;
                }

                $jogoEditavel = ($aposta->getStatus() == 1 and !$aposta->getVerificado() and $a->getIsEditavel() and count($voJogos) > 0);

                $jogos[] = [
                    'id' => $jogo->getId(),
                    'editavel' => $jogoEditavel,
                    'token' => $a->getToken(),
                    'data' => $jogo->getData(true) . ' às ' . $jogo->getHora(),
                    'timecasa' => $jogo->getTimeCasaTitle(),
                    'timefora' => $jogo->getTimeForaTitle(),
                    'campeonato' => $jogo->getCampeonatoTitle(),
                    'cotacao' => strtoupper($a->getCotacaoSigla()) . ' (' . $a->getCotacaoValor(true) . ')',
                    'verificado' => $a->getVerificado() ? true : false,
                    'perdeu' => !$a->getAcertou() ? true : false,
                    'ganhou' => $a->getAcertou() ? true : false,
                    'tempo' => $a->getTempoTitle(),
                    'cancelado' => $a->getStatus() != 1,
                ];
            }

            return [
                'total' => count($jogos),
                'jogos' => $jogos,
                'editavel' => ($editavel and !$comecou),
                'result' => 1,
            ];

        } catch (Exception $ex) {
            return $ex;
        }
    }

    function atualizaJogosAction()
    {
        try {

            Conn::startTransaction();

            if (!Admin::isMaster()) {
                throw new Exception('Somente administradores');
            }

            $aposta = ApostasModel::getByLabel('token', inputPost('aposta'));

            if (!$aposta instanceof ApostaVO) {
                throw new Exception('Aposta inválida');
            }

            $jogos = $aposta->voJogos();
            $jogosUpdate = filter_input(INPUT_POST, 'jogos', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $aposta->setCotacao(1);

            if (!$jogosUpdate) {
                throw new Exception("Nenhum jogo foi alterado na aposta #{$aposta->getId()}");
            }

            # Atualizando cotações
            if ($jogosUpdate && $jogos) {
                foreach ($jogos as $key => $v) {

                    $cotacao = CotacoesModel::getByLabel('campo', $jogosUpdate[$v->getId()] ?? 0);

                    if ($cotacao instanceof CotacaoVO and $cotacao->getCampo() != $v->getCotacaoCampo()) {

                        if ($v->voJogo()->jaComecou()) {
                            throw new Exception("O jogo `{$v->voJogo()->getDescricao()}` não aceita mais alterações na aposta");
                        }

                        $cotacaoValor = $v->voJogo()->getCotacoes(true)[$v->getTempo()][$cotacao->getCampo()] ?? 1;

                        $v->setTipo($cotacao->getCampo());
                        $v->setCotacaoCampo($cotacao->getCampo());
                        $v->setCotacaoTitle($cotacao->getTitulo());
                        $v->setCotacaoGrupo($cotacao->getGrupo());
                        $v->setCotacaoSigla($cotacao->getSigla());
                        $v->setCotacaoValor($cotacaoValor);
                        $v->save();

                    }

                    $aposta->setCotacao($aposta->getCotacao() * $v->getCotacaoValor());
                }
            }

            # Salvando aposta
            $aposta->Save();

            Conn::commit();

            return [
                'message' => 'Aposta atualizada com sucesso.',
                'result' => 1,
            ];

        } catch (Exception $ex) {

            Conn::rollBack();

            return $ex;
        }
    }

    /**
     * Tabela de jogos da aposta
     */
    function tabelaJogosAction()
    {

        $check = url_parans(1) == 'check';

        $v = ApostasModel::getByLabel('token', url_parans(0));
        if ($v instanceof ApostaVO) {
            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified lista-table tabela-aposta', ['data-token' => $v->getToken()]);

            $t->addTSection('thead');
            $t->addRow();
            $t->addCell('Times/Campeonato', ['colspan' => 2]);
            $t->addCell('Data/Hora', ['width' => 120]);
            $t->addCell('Tipo/Cotação', ['width' => 120]);

            $t->addTSection('tbody');

            # Cotações
            $cotacoes = \app\models\CotacoesModel::getCotacoesAtivas();
            foreach ($cotacoes as $key => $cotacao) {
                $cotacoes[$key] = formOption($cotacao->getSigla(), $cotacao->getCampo());
            }
            $cotacoes = implode('', $cotacoes);

            foreach ($v->voJogos() as $jogo) {
                if ($jogo instanceof ApostaJogoVO) {

                    if ($jogo->getVerificado()) {
                        $class = $jogo->getAcertou() ? 'success' : 'danger';
                    } else {
                        $class = 'default';
                    }

                    if ($jogo->voJogo()->getStatus() == 2) {
                        $resultado = "{$jogo->voJogo()->getTimeCasaPlacar()} x {$jogo->voJogo()->getTimeForaPlacar()}";
                    } else {
                        $resultado = 'x';
                    }

                    $t->addRow('item-aposta-jogo ' . $class, ['data-id' => $jogo->getId(), 'data-cotacao' => $jogo->getTipo()]);
                    $t->addCell($jogo->getJogo(), ['width' => 80, 'class' => 'text-center']);
                    $t->addCell("{$jogo->voJogo()->getTimeCasaTitle()} {$resultado} {$jogo->voJogo()->getTimeForaTitle()}<br /><b>{$jogo->voJogo()->getCampeonatoTitle()}</b>", 'text-center');
                    $t->addCell("{$jogo->voJogo()->getData(true)}<br />{$jogo->voJogo()->getHora()}", 'text-center');

                    if (Admin::isDeveloper() and !$jogo->getVerificado()) {
                        $t->addCell(formSelect('tipo', $cotacoes, ['class' => 'input-sm', 'data-cotacao' => $jogo->getTipo()]), 'text-center');
                    } else {
                        $placar = "";
                        $t->addCell("<b>{$jogo->getCotacaoValor(true)}</b> <br/> {$jogo->getCotacaoTitle()} {$placar}", 'text-center');
                    }
                }
            }

            echo <<<HTML
<div class='table-responsive' >{$t}</div>
<p class='text-center' >
    Cotação: <b>{$v->getCotacaoValida(true)}</b><br />
    Valor apostado: <b>R$ {$v->getValor(true)}</b><br />
    Retorno: <b>R$ {$v->getRetornoValido(true)}</b><br />
    Apostador: <b>{$v->getUserNome()}</b>
</p>
HTML;

        } else {
            echo 'Aposta inválida.';
        }
    }

}
    
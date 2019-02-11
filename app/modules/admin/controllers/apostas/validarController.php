<?php

namespace app\modules\admin\controllers\apostas;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\ApostasModel;
use app\modules\admin\Admin;
use app\vo\ApostaJogoVO;
use app\vo\ApostaVO;
use Exception;

class validarController extends Controller
{

    function indexAction()
    {
        $this->view('apostas/validar');
    }

    function detalhesAction()
    {

        try {

            $aposta = ApostasModel::getByLabel('id', inputPost('pule'));

            if (!$aposta instanceof ApostaVO) {
                throw new Exception('Aposta inválida');
            }

            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified');

            $t->addTSection('thead');
            $t->addRow();
            $t->addCell('Times/Campeonato', ['colspan' => 2]);
            $t->addCell('Data/Hora', ['width' => 120]);
            $t->addCell('Tipo/Cotação', ['width' => 120]);

            $t->addTSection('tbody');

            foreach ($aposta->voJogos() as $jogo) {
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
                        $t->addCell('<b>' . $jogo->getCotacaoTitle() . '</b><br />' . $jogo->getCotacaoValor(), 'text-center');
                    } else {
                        $placar = "";
                        $t->addCell("<b>{$jogo->getCotacaoValor(true)}</b> <br/> {$jogo->getCotacaoTitle()} {$placar}", 'text-center');
                    }
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive'>{$t}</div>");

            switch ($aposta->getStatus()) {
                case ApostasModel::STATUS_AGUARDANDO_PAGAMENTO:
                    echo '<div class="text-center">'
                        . '<button type="button" data-token="' . $aposta->getToken() . '" class="btn btn-validar btn-success">'
                        . 'Receber/Validar Aposta'
                        . '</button>'
                        . '</div>';
                    break;
                case ApostasModel::STATUS_NPAGA:
                    echo '<div class="text-center alert alert-warning">'
                        . 'Aposta cancelado por falta de pagamento'
                        . '</div>';
                    break;
                case ApostasModel::STATUS_EXCLUIDA:
                    echo '<div class="text-center alert alert-warning">'
                        . 'Aposta foi excluída'
                        . '</div>';
                    break;
                case ApostasModel::STATUS_CANCELADA:
                    echo '<div class="text-center alert alert-warning">'
                        . 'Aposta foi cancelada'
                        . '</div>';
                    break;
                case ApostasModel::STATUS_ATIVA:
                    if ($aposta->get('ganhou')) {
                        echo '<div class="text-center alert alert-success">'
                            . '<i class="fa fa-check"></i> Aposta premiada'
                            . '</div>';
                    }
                    break;
            }
        } catch (Exception $ex) {
            echo '<div class="alert alert-warning">' . $ex->getMessage() . '</div>';
        }
    }

}
    
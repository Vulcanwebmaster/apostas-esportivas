<?php

namespace app\modules\admin\controllers\jogos;

use app\core\Controller;
use app\helpers\Number;
use app\models\CotacoesModel;
use app\models\HistoricoModel;
use app\models\JogosModel;
use app\modules\admin\Admin;
use app\vo\JogoVO;
use Exception;

class jogoController extends Controller
{

    public function __construct()
    {
        if (!IS_AJAX) {
            location();
        } else if (!Admin::isMaster()) {
            json('Somente para administradores.');
        }
    }

    public function excluirAction()
    {
        try {

            $v = JogosModel::getByLabel('token', inputPost('id'));

            if (!$v instanceof JogoVO) {
                throw new \Exception('Jogo inválido');
            }

            JogosModel::cancelar($v);

            HistoricoModel::add("Cancelou o jogo #{$v->getId()}", $v, Admin::getLogged());

            return [
                'message' => 'Registro excluído com sucesso',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function update_infoAction()
    {
        try {

            # Médodo
            $method = inputPost('field');
            if (!$method) {
                throw new Exception('Método inválido');
            }

            # Valor
            $value = inputPost('value');
            if (!$value) {
                throw new Exception('Valor inválido');
            }

            # Jogo
            $jogo = JogosModel::getByLabel('id', inputPost('jogo'));
            if (!$jogo instanceof JogoVO) {
                throw new Exception('Jogo inválido');
            }

            # Salvando valor da cotação
            foreach (CotacoesModel::getCotacoesAtivas() as $cotacao) {
                if ($method == $cotacao->getCampo()) {
                    HistoricoModel::add("Alterou a cotação `{$cotacao->getTitulo()}` do jogo", $jogo);
                    json('Cotação atualizada com sucesso');
                }
            }

            # Campo
            if (!$method or !method_exists($jogo, "set{$method}")) {
                throw new Exception('Valor inválido');
            } else {
                $jogo->Save([$method => $value]);
                HistoricoModel::add('Alterou informação do jogo', $jogo);
            }

            HistoricoModel::add("Alterou as informações do jogo #{$jogo->getId()}", $jogo, Admin::getLogged());

            json('Jogo atualizado com sucesso.', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function placarAction()
    {
        try {

            $jogo = JogosModel::getByLabel('token', inputPost('jogo'));

            if (!$jogo instanceof JogoVO) {
                throw new Exception('Jogo inválido');
            } else if (!IS_LOCAL and !Admin::isDeveloper() and !$jogo->jaComecou()) {
                throw new Exception('O placar só pode ser definido após o início do jogo.');
            }

            $jogo->input('timecasaplacarprimeiro');
            $jogo->input('timecasaplacarsegundo');
            $jogo->input('timeforaplacarprimeiro');
            $jogo->input('timeforaplacarsegundo');

            if ($jogo->getStatus() == 1) {
                JogosModel::definePlacar($jogo);
                $msg = 'Definiu';
            } else {
                JogosModel::redefinirPlacar($jogo);
                $msg = 'Redefiniu';
            }

            HistoricoModel::add("{$msg} o placar do jogo #{$jogo->getId()}", $jogo, Admin::getLogged());

            json('Placar definido com sucesso.', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function save(JogoVO $jogo)
    {
        try {

            if ($jogo->getStatus() != 1) {
                throw new Exception('Jogo não pode mais ser alterado.');
            }

            $id = $jogo->getId();

            $cotacoes = inputPost()['cotacoes'];

            if (!empty($cotacoes['tempo90'])) {
                $cotacoes = [
                    '90' => $cotacoes['tempo90'],
                    'pt' => $cotacoes['tempopt'],
                    'st' => $cotacoes['tempost'],
                ];
            }

            foreach ($cotacoes as $tempo => $valores) {
                foreach ($valores as $campo => $valor) {
                    $cotacoes[$tempo][$campo] = Number::float($valor);
                }
            }

            $jogo
                ->setCotacoes($cotacoes)
                ->input('campeonato')
                ->input('data')
                ->input('hora')
                ->input('timecasa')
                ->input('timefora')
                ->input('limite1')
                ->input('limite2')
                ->input('limite3')
                ->Save();

            if ($id) {
                HistoricoModel::add("Atualizou o jogo #{$jogo->getId()}", $jogo, Admin::getLogged());
            } else {
                HistoricoModel::add("Adicionou o jogo #{$jogo->getId()}", $jogo, Admin::getLogged());
            }

            json('Salvo com sucesso.', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }


    function getModel()
    {
        return JogosModel::Instance();
    }

}
    
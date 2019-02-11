<?php

namespace app\modules\api\controllers;

use app\core\Controller;
use app\helpers\STR;
use app\models\ApostasModel;
use app\models\DadosModel;
use app\models\HistoricoBancarioModel;
use app\modules\api\API;
use app\modules\api\serialize\ApostaSerialize;
use app\vo\ApostaVO;

class apostasController extends Controller
{

    function listAction()
    {
        try {

            $user = API::getUser();

            $parans = inputGet();
            $parans += ['page' => 1, 'forpage' => 30];

            $busca = ApostasModel::busca($parans += ['user' => $user->getId()], $parans['page'], $parans['forpage']);

            $linkNext = $linkPrev = null;
            $results = [];

            foreach ($busca->getRegistros() as $v) {
                $results[] = new ApostaSerialize($v);
            }

            if ($busca->getCurrentPage() < $busca->getTotalPaginas())
                $linkNext = 'apostas/list?' . http_build_query(['page' => $busca->getCurrentPage() + 1] + $parans);

            if ($busca->getCurrentPage() > 1)
                $linkPrev = 'apostas/list?' . http_build_query(['page' => $busca->getCurrentPage() - 1] + $parans);

            return [
                'count' => $busca->getCount(),
                'next' => $linkNext,
                'prev' => $linkPrev,
                'results' => $results,
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function consultarAction()
    {
        try {

            API::getUser();

            $codigo = inputPost('codigo');

            if (!$codigo)
                throw new \Exception("Informe o código da aposta");

            $codigo = str_replace(' ', null, $codigo);

            $bilhete = ApostasModel::getByLabel('codigobilhete', $codigo);

            if (!$bilhete instanceof ApostaVO)
                throw new \Exception("Código inválido");

            return [
                'aposta' => new ApostaSerialize($bilhete),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function impressaoAction()
    {
        try {

            $dados = DadosModel::get();

            $regras = strip_tags($dados->getRegrasAposta());

            $aposta = ApostasModel::getByLabel('token', IS_POST ? inputPost('token') : url_parans(0));
            if (!$aposta instanceof ApostaVO)
                throw new \Exception("Aposta inválida");

            $hr = "--------------------------------------------";

            $content = <<<HTML
{$dados->getBanca()}
{$hr}
Data: {$aposta->getData(true)} às {$aposta->getHora()}
Colaborador: {$aposta->getUserNome()}
Cliente: {$aposta->getApostadorNome()}
{$hr}
Jogos
{$hr}\n
HTML;

            foreach ($aposta->voJogos(true) as $v) {

                $jogos = $v->voJogo();

                $content .= <<<HTML
Futebol: {$jogos->getData(true)} às {$jogos->getHora()}
{$jogos->getTimeCasaTitle()} x {$jogos->getTimeForaTitle()}
{$v->getCotacaoTitle()} {$v->getCotacaoValor(true)}
Status: {$v->getStatusTitle()}
{$hr}\n
HTML;

            }

            $codigo = preg_replace('/(.{3})/', '$1 ', $aposta->getCodigoBilhete());

            $content .= <<<HTML
Quantidade de jogos: {$aposta->getJogos()}
Cotação: {$aposta->getCotacaoValida(true)}
Valor da aposta: R$ {$aposta->getValor(true)}
Possível retorno: R$ {$aposta->getRetornoValido(true)}
{$hr}
Bilhete
{$codigo}
{$hr}
{$regras}
HTML;

            $content = STR::rmAcentos($content);

            if (!IS_POST)
                exit('<pre>' . $content . '</pre>');

            return [
                'content' => str_replace("\r", "", $content),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function validarAction()
    {
        try {

            $user = API::getUser();

            $aposta = ApostasModel::getByLabel('token', inputPost('token'));

            if (!$aposta instanceof ApostaVO) {
                throw new \Exception('Aposta inválida');
            } else if ($aposta->getStatus() != ApostasModel::STATUS_AGUARDANDO_PAGAMENTO) {
                throw new \Exception('Aposta não pode mais ser validada');
            } else if ($user->getCredito() < $aposta->getValor()) {
                throw new \Exception('Saldo insuficiente para validar a aposta');
            } else if ($aposta->getUser()) {
                throw new \Exception('Aposta pertence a outro colaborador');
            }

            foreach ($aposta->voJogos() as $v) {
                $jogo = $v->voJogo();
                if ($jogo->getStatus() != 1) {
                    throw new \Exception("A partida {$jogo->getDescricao()} não está mais disponível");
                } else if ($jogo->jaComecou()) {
                    throw new \Exception("A partida {$jogo->getDescricao()} já se iniciou");
                }
            }

            $aposta->setUser($user->getId());
            $aposta->setStatus(ApostasModel::STATUS_ATIVA);
            $aposta->save();

            // Abatendo do valor
            HistoricoBancarioModel::add($user, -$aposta->getValor(), "Validação de aposta {$aposta->getCodigoBilhete()}", $aposta, 'validacao');

            return [
                'message' => 'Aposta validada com sucesso',
                'saldo' => $user->getCredito(),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
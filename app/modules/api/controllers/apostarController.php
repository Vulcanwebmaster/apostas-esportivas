<?php

namespace app\modules\api\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\core\Model;
use app\models\ApostaJogosModel;
use app\models\ApostasModel;
use app\models\ClientesModel;
use app\models\CotacoesModel;
use app\models\DadosModel;
use app\models\helpers\OptionsModel;
use app\models\HistoricoBancarioModel;
use app\models\JogosModel;
use app\modules\api\API;
use app\modules\api\serialize\ApostaSerialize;
use app\vo\ApostaJogoVO;
use app\vo\ApostaVO;
use app\vo\ClienteVO;
use app\vo\CotacaoVO;
use app\vo\helpers\OptionVO;
use app\vo\JogoVO;

class apostarController extends Controller
{

    function jogosAction()
    {
        try {

            $cotacoes = $this->cotacoes();
            $jogos = $this->jogos();

            return [
                    'hoje' => date('Y-m-d'),
                    'amanha' => date('Y-m-d', strtotime('+1day')),
                    'cotacoes' => $cotacoes,
                    'grupos' => $this->grupos(),
                    'result' => 1,
                ] + $jogos;

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function cotacoes()
    {

        $termos = <<<SQL
SELECT a.id, a.sigla, a.titulo AS title, a.campo, a.cor, a.grupo, a.principal
FROM `sis_cotacoes` AS a
WHERE a.status = 1 
ORDER BY a.ordem ASC, a.titulo ASC
SQL;

        $cotacoes = Model::pdoRead()->FullRead($termos)->getResult();

        foreach ($cotacoes as &$c) {
            $c['id'] = (int)$c['id'];
            $c['principal'] = (bool)$c['principal'];
            $c['grupoTitle'] = CotacoesModel::GRUPOS[$c['grupo']] ?? null;
        }

        return $cotacoes;
    }

    function jogos()
    {

        $termos = <<<SQL
SELECT
    a.id,
    a.campeonato,
    d.title AS campeonatoTitle,
    b.title AS casa,
    c.title AS fora,
    a.data,
    a.hora,
    d.pais,
    a.cotacoes
    
FROM
    `sis_jogos` AS a
    
INNER JOIN
    `sis_times` AS b ON b.id = a.timecasa AND b.status = 1
    
INNER JOIN
    `sis_times` AS c ON c.id = a.timefora AND c.status = 1
    
INNER JOIN
    `sis_campeonatos` AS d ON d.id = a.campeonato AND d.status = 1
        
WHERE 
    a.status = 1 AND a.data >= :hoje
    AND (a.data > :hoje OR a.hora > :hora)
    
ORDER BY
    d.title ASC, a.data ASC, a.hora ASC
SQL;

        $places = [
            'hoje' => date('Y-m-d'),
            'hora' => date("H:i:s"),
        ];

        $paises = [];
        $paisesIds = [];
        $campeonatos = [];
        $result = [];

        $registros = Model::pdoRead()->FullRead($termos, $places)->getResult();

        foreach ($registros as $i => $v) {
            $registros[$i]['cotacoes'] = $v['cotacoes'] = json_decode($v['cotacoes'], true);
            $registros[$i]['id'] = (int)$v['id'];

            $campeonatos[(int)$v['campeonato']] = [
                'id' => (int)$v['campeonato'],
                'pais' => (int)$v['pais'],
                'title' => $v['campeonatoTitle'],
                'jogos' => [],
            ];

            $paisesIds[(int)$v['pais']] = $v['pais'];
        }

        foreach ($campeonatos as $id => $c) {
            foreach ($registros as $v) {
                if ($v['campeonato'] == $c['id']) {
                    $campeonatos[$id]['jogos'][] = $v;
                }
            }
        }


        if ($paisesIds) {

            /** @var OptionVO $pais */
            foreach (OptionsModel::lista("WHERE a.id IN(" . implode(', ', $paisesIds) . ") ORDER BY a.ordem ASC, a.title ASC") as $pais) {
                $paises[] = [
                    'id' => $pais->getId(),
                    'title' => $pais->getTitle(),
                    'img' => $pais->imgCapa()->redimensiona(0, 50),
                ];
            }

            if (in_array(0, $paisesIds)) {
                $paises[] = [
                    'id' => 0,
                    'title' => 'Outros',
                    'img' => source_images('default.jpg'),
                ];
            }
        }

        return [
            'paises' => $paises,
            'campeonatos' => array_values($campeonatos),
        ];

    }

    function grupos()
    {
        $grupos = [];
        foreach (CotacoesModel::GRUPOS as $id => $title) {
            $grupos[] = ['id' => $id, 'title' => $title];
        }
        return $grupos;
    }

    function apostarAction()
    {
        try {

            Conn::startTransaction();

            $user = API::getUser();

            $cliente = null;
            $valor = (float)inputPost('valor');
            $jogos = inputPost('jogos') ?: [];
            $config = DadosModel::get();
            $tCotacao = 1;

            if (!inputPost('cliente')) {
                if (inputPost('clienteId') > 0) {
                    $cliente = ClientesModel::getByLabel('id', inputPost('clienteId'));
                    if ($cliente instanceof ClienteVO) {
                        if ($cliente->getUser() != $user->getId()) {
                            throw new \Exception("Cliente pertence a outro colaborador");
                        }
                    } else {
                        throw new \Exception("Cliente inválido");
                    }
                } else {
                    throw new \Exception("Informe o cliente da aposta");
                }
            }

            /** @var ApostaJogoVO[] $apostaJogos */
            $apostaJogos = [];


            if ($valor < $config->getApostaMinima()) {
                throw new \Exception("O valor mínimo para aposta é de R$ {$config->getApostaMinima(true)}");
            } else if ($valor > $config->getApostaMaxima()) {
                throw new \Exception("O valor máximo para aposta é de R$ {$config->getApostaMaxima(true)}");
            }

            if ($user->getCredito() < $valor) {
                throw new \Exception("Saldo insuficiente para concluír a aposta");
            }

            foreach ($jogos as $v) {

                $jogo = JogosModel::getByLabel('id', $v['jogo']);
                $cotacao = CotacoesModel::getByLabel('campo', $v['cotacao']);

                if (!$jogo instanceof JogoVO) {
                    throw new \Exception("Jogo inválido");
                } else if (!$cotacao instanceof CotacaoVO) {
                    throw new \Exception("Cotação inválida");
                } else if ($cotacao->getStatus() != 1) {
                    throw new \Exception("Cotação foi desativada");
                } else if ($jogo->jaComecou() or $jogo->getStatus() != 1) {
                    throw new \Exception("Jogo `{$jogo->getDescricao()}` não está mais recebendo apostas");
                }

                $valorCotacao = (float)$jogo->getCotacoes(true)[$v['tempo']][$cotacao->getCampo()] ?? 1;

                if ($valorCotacao <= 1) {
                    throw new \Exception("Cotação inválida");
                }

                $tCotacao *= $valorCotacao;

                $apostaJogos[] = ApostaJogosModel::newValueObject([
                    'jogo' => $jogo->getId(),
                    'valor' => $valor,
                    'tempo' => $v['tempo'],
                    'tipo' => $cotacao->getCampo(),
                    'cotacaotitle' => $cotacao->getTitulo(),
                    'cotacaosigla' => $cotacao->getSigla(),
                    'cotacaoGrupo' => $cotacao->getGrupo(),
                    'cotacaovalor' => $valorCotacao,
                    'jogos' => count($jogos),
                    'cotacaocampo' => $cotacao->getCampo(),
                ]);

            }

            /** @var ApostaVO $aposta */
            $aposta = ApostasModel::newValueObject();

            $aposta->setValor($valor);
            $aposta->setData(date('Y-m-d'));
            $aposta->setCotacaoMaxima($config->getCotacaoMaxima());
            $aposta->setRetornoMaximo($config->getRetornoMaximo());
            $aposta->setCotacao($tCotacao);
            $aposta->setJogos(count($jogos));
            $aposta->setUser($user->getId());

            if ($cliente) {
                $aposta->setApostadorNome($cliente->getNome());
                $aposta->setCliente($cliente->getId());
            } else {
                $aposta->setApostadorNome(inputPost('cliente'));
                $aposta->setApostadorTelefone(inputPost('telefone'));
            }

            $aposta->save();

            // Salvando jogos
            foreach ($apostaJogos as $v) {
                $v->setAposta($aposta->getId());
                $v->save();
            }

            HistoricoBancarioModel::add($user, -$valor, "Pagamento de aposta #{$aposta->getId()}", $aposta, 'aposta');

            ApostasModel::pagarComissoes($aposta);

            Conn::commit();

            return [
                'aposta' => new ApostaSerialize($aposta),
                'message' => 'Aposta realizada com sucesso',
                'saldo' => $user->getCredito(),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            Conn::rollBack();
            return $ex;
        }
    }

}
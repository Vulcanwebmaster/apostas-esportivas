<?php

namespace app\modules\website\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\core\Model;
use app\models\ApostaJogosModel;
use app\models\ApostasModel;
use app\models\CotacoesModel;
use app\models\DadosModel;
use app\models\helpers\OptionsModel;
use app\models\HistoricoBancarioModel;
use app\models\JogosModel;
use app\modules\admin\Admin;
use app\vo\ApostaJogoVO;
use app\vo\ApostaVO;
use app\vo\CotacaoVO;
use app\vo\JogoVO;

class apostarController extends Controller
{

    function indexAction()
    {
        $this->view('website/page/aposta');
    }

    function jogosAction()
    {
        $cotacoes = $this->cotacoes();
        $jogos = $this->jogos();

        return [
            'cotacoes' => $cotacoes,
            'grupos' => CotacoesModel::GRUPOS,
            'paises' => $jogos,
        ];
    }

    function cotacoes()
    {

        $termos = <<<SQL
SELECT a.sigla, a.titulo AS title, a.campo, a.cor, a.grupo, a.principal
FROM `sis_cotacoes` AS a
WHERE a.status = 1 
ORDER BY a.ordem ASC, a.titulo ASC
SQL;

        return Model::pdoRead()->FullRead($termos)->getResult();
    }

    function jogos()
    {

        $termos = <<<SQL
SELECT
    a.id,
    a.campeonato AS campeonatoId,
    d.pais,
    d.title AS campeonato,
    b.title AS casa,
    c.title AS fora,
    a.data,
    a.hora,
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
        $campeonatos = [];
        $result = [];
        $registros = Model::pdoRead()->FullRead($termos, $places)->getResult();

        foreach ($registros as $i => $v) {
            $paises[] = $v['pais'];
            $registros[$i]['dateTime'] = date('c', strtotime("{$v['data']} {$v['hora']}"));
            $registros[$i]['cotacoes'] = $v['cotacoes'] = json_decode($v['cotacoes'], true);
            if (!in_array($v['campeonatoId'], $campeonatos))
                $campeonatos[(int)$v['campeonatoId']] = $v['campeonato'];
        }


        if ($paises = array_unique($paises)) {
            $paises = OptionsModel::lista('WHERE a.id IN(' . implode(', ', $paises) . ') ORDER BY a.ordem ASC, a.title ASC LIMIT :limit', [
                'limit' => count($paises),
            ]);
        }

        $i = 0;
        foreach ($campeonatos as $id => $campeonato) {
            $result[$i]['id'] = $id;
            $result[$i]['title'] = $campeonato;
            foreach ($registros as $v) {
                if ((int)$v['campeonatoId'] == $id) {
                    $result[$i]['pais'] = (int)$v['pais'];
                    $result[$i]['jogos'][] = $v;
                }
            }
            $i++;
        }

        $resultPaises = [];

        foreach ($paises as $pais) {

            $dados = [
                'id' => $pais->getId(),
                'title' => $pais->getTitle(),
                'img' => $pais->imgCapa()->getSource(true),
                'campeonatos' => [],
            ];

            foreach ($result as $i => $c) {
                if ($c['pais'] == $pais->getId()) {
                    $dados['campeonatos'][] = $c;
                    unset($result[$i]);
                }
            }

            $resultPaises[] = $dados;
        }

        if ($result) {

            $dados = [
                'id' => 0,
                'title' => 'Outros',
                'img' => source_images('default.jpg'),
                'campeonatos' => []
            ];

            foreach ($result as $i => $v) {
                $dados['campeonatos'][] = $v;
                unset($result[$i]);
            }

            $resultPaises[] = $dados;
        }

        return $resultPaises;

    }

    function imprimirAction()
    {
        try {
            $aposta = ApostasModel::getByLabel('token', url_parans(0));

            if (!$aposta instanceof ApostaVO) {
                throw new \Exception('Aposta inválida');
            }

            $this->view('website/page/pre-bilhete', [
                'aposta' => $aposta,
            ]);

        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function apostarAction()
    {
        try {

            Conn::startTransaction();

            $user = Admin::getLogged();

            $valor = (float)inputPost('valor');
            $jogos = inputPost('jogos') ?: [];
            $config = DadosModel::get();
            $tCotacao = 1;

            /** @var ApostaJogoVO[] $apostaJogos */
            $apostaJogos = [];

            if ($valor < $config->getApostaMinima()) {
                throw new \Exception("O valor mínimo para aposta é de R$ {$config->getApostaMinima(true)}");
            } else if ($valor > $config->getApostaMaxima()) {
                throw new \Exception("O valor máximo para aposta é de R$ {$config->getApostaMaxima(true)}");
            }

            if ($user) {
                if ($user->getCredito() < $valor) {
                    throw new \Exception("Saldo insuficiente para concluír a aposta");
                }
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

                $apostaJogos[] = (ApostaJogosModel::newValueObject([
                    'jogo' => $jogo->getId(),
                    'valor' => $valor,
                    'tempo' => $v['tempo'],
                    'tipo' => $cotacao->getCampo(),
                    'cotacaovalor' => $valorCotacao,
                    'cotacaotitle' => $cotacao->getTitulo(),
                    'cotacaogrupo' => $cotacao->getGrupo(),
                    'cotacaosigla' => $cotacao->getSigla(),
                    'jogos' => count($jogos),
                    'cotacaocampo' => $cotacao->getCampo(),
                ]));

            }

            /** @var ApostaVO $aposta */
            $aposta = ApostasModel::newValueObject();

            $aposta->setValor($valor);
            $aposta->setData(date('Y-m-d'));
            $aposta->setCotacaoMaxima($config->getCotacaoMaxima());
            $aposta->setRetornoMaximo($config->getRetornoMaximo());
            $aposta->setCotacao($tCotacao);
            $aposta->setJogos(count($jogos));

            if ($user) {
                $aposta->setUser($user->getId());
                $aposta->setApostadorNome(inputPost('cliente') ?: $user->getNome());
                $aposta->setApostadorTelefone(inputPost('telefone') ?: $user->getTelefone());
                $aposta->setStatus(ApostasModel::STATUS_ATIVA);
            } else {
                $aposta->setApostadorNome(inputPost('cliente'));
                $aposta->setApostadorTelefone(inputPost('telefone'));
                $aposta->setStatus(ApostasModel::STATUS_AGUARDANDO_PAGAMENTO);
            }

            $aposta->save();

            // Salvando jogos
            foreach ($apostaJogos as $v) {
                $v->setAposta($aposta->getId());
                $v->save();
            }

            if ($user) {
                HistoricoBancarioModel::add($user, -$valor, "Pagamento de aposta #{$aposta->getId()}", $aposta, 'aposta');
                ApostasModel::pagarComissoes($aposta);
            }

            Conn::commit();

            return [
                'message' => 'Aposta realizada com sucesso',
                'codigo' => $aposta->getCodigoBilhete(),
                'link' => url('apostar/imprimir', [$aposta->getToken()]),
                'saldo' => $user ? $user->getCredito() : 0,
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            Conn::rollBack();
            return $ex;
        }
    }

}
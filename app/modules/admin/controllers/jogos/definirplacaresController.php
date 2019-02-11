<?php

namespace app\modules\admin\controllers\jogos;

use app\core\Controller;
use app\core\crud\Conn;
use app\core\Model;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\jogos\VerificaApostaJogo;
use app\helpers\Number;
use app\helpers\Table;
use app\models\ApostaJogosModel;
use app\models\ApostasModel;
use app\models\JogosModel;
use app\modules\admin\Admin;
use app\vo\ApostaJogoVO;
use app\vo\JogoVO;
use GuzzleHttp\Client;

class definirplacaresController extends Controller
{

    function indexAction()
    {
        $this->view('admin/jogos/placares');
    }

    function importarPlacaresAction()
    {
        try {

            ini_set('memory_limit', '500M');
            ini_set('max_execution_time', 5 * 60);

            $client = new Client(['base_url' => 'https://www.jhonlennon.com.br/marjosports/', 'verify' => false]);

            $termos = <<<SQL
WHERE 
    a.refimport IS NOT NULL AND a.refimport != '' 
    AND a.status = 1 
    AND (a.data < curdate() OR a.data = curdate() AND a.hora < curtime());
SQL;

            /** @var JogoVO[] $jogos */
            $jogos = JogosModel::lista($termos);

            if (!$jogos) {
                throw new \Exception("Nenhum jogo foi alterado.");
            }

            $totalJogos = count($jogos);
            $totalDefinidos = 0;

            $message = '';

            foreach ($jogos as $jogo) {

                $response = $client->post('resultados', [
                    'verify' => false,
                    'body' => [
                        'refid' => $jogo->getRefImport(),
                    ]
                ])->getBody()->getContents();

                $placar = json_decode($response, true);

                if ($placar and $placar['result'] == 1) {

                    $placar = $placar['resultado'];

                    if ($placar['refid'] == $jogo->getRefImport()) {

                        $jogo->setTimeCasaPlacarPrimeiro($placar['timecasaplacarprimeiro']);
                        $jogo->setTimeCasaPlacarSegundo($placar['timecasaplacarsegundo']);
                        $jogo->setTimeForaPlacarPrimeiro($placar['timeforaplacarprimeiro']);
                        $jogo->setTimeForaPlacarSegundo($placar['timeforaplacarsegundo']);

                        JogosModel::definePlacar($jogo);

                        $totalDefinidos++;

                        $message .= "{$jogo->getTimeCasaTitle()} {$jogo->getTimeCasaPlacar()}x{$jogo->getTimeForaPlacar()} {$jogo->getTimeForaTitle()}\n";

                    }

                    sleep(1);
                }

            }

            return [
                'message' => "{$message}{$totalDefinidos}/{$totalJogos} jogos foram definidos os placares.",
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function simulacaoAction()
    {
        Conn::startTransaction();

        $verifica = new VerificaApostaJogo;

        $jogos = filter_input(INPUT_POST, 'jogos', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $apostas = [];

        $jogosAcertados = 0;
        $jogosTotal = 0;
        $valoresApostados = 0;

        $t = new Table(null, 'table table-striped table-hover table-bordered table-minified lista-table');

        $t
            ->addTSection('thead')
            ->addRow()
            ->addCell('Times/Campeonato')
            ->addCell('Data/Hora', ['width' => 120])
            ->addCell('Tipo/Cotação', ['width' => 120])
            ->addTSection('tbody');

        foreach ((array)$jogos as $token => $placares) {
            $jogo = JogosModel::getByLabel('token', $token, true);

            if ($jogo instanceof JogoVO) {

                $jogo->input('timecasaplcarprimeiro');
                $jogo->input('timecasaplcarsegundo');
                $jogo->input('timeforaplcarprimeiro');
                $jogo->input('timeforaplcarsegundo');
                $jogo->Save();

                foreach (ApostaJogosModel::lista('WHERE a.jogo = :jogo', ['jogo' => $jogo->getId()]) as $apostaJogo) {
                    $jogosTotal++;

                    if ($apostaJogo instanceof ApostaJogoVO) {

                        # Verificando acerto
                        if ($verifica->verificaAposta($apostaJogo)) {
                            $jogosAcertados++;

                            $t
                                ->addRow()
                                ->addCell("{$jogo->getTimeCasaTitle()} x {$jogo->getTimeForaTitle()}<br />{$jogo->getCampeonatoTitle()}")
                                ->addCell("{$jogo->getData(true)}<br />{$jogo->getHora()}", 'text-center')
                                ->addCell("{$apostaJogo->getCotacaoTitle()}<Br />{$apostaJogo->getCotacaoValor(true)}", 'text-center');
                        }

                        # Adicionando a apostas afetadas
                        if (!in_array($apostaJogo->getAposta(), $apostas)) {
                            $valoresApostados += $apostaJogo->getValor();

                            $apostas[] = $apostaJogo->getAposta();
                        }
                    }
                }
            }
        }

        echo $t;

        $q = null;

        if ($apostas) {
            $q = Model::pdoRead()->FullRead("SELECT SUM(IF(a.ganhou, 1, 0)) AS ganhas, SUM(IF(a.ganhou, a.retornovalido, 0)) AS totalPerdido "
                . 'FROM `' . ApostasModel::getTable() . '` AS a WHERE a.id IN(' . implode(', ', $apostas) . ') ', [
            ])->getResult();
        }

        echo '<div class="text-center" >'
            . '<p>'
            . '<b>Apostas Ganhas:</b> ' . ($q ? $q[0]['ganhas'] : 0) . '<br/>'
            . '<b>Valores apostados:</b> R$ ' . Number::real($valoresApostados) . ' <br/>'
            . '<b>Valores a receber:</b> R$ ' . Number::real($q ? $q[0]['totalPerdido'] : 0) . ' <br/>'
            . '<b>Qtd. Jogos:</b> ' . $jogosAcertados . '/' . $jogosTotal . ' <br/>'
            . '</p>'
            . '</div>';

        Conn::rollBack();
    }

    function listAction()
    {
        $dtInicial = Date::data(inputPost('dataInicial'));
        $dtFinal = Date::data(inputPost('dataFinal'));
        $busca = JogosModel::busca(extend(inputPost(), [
            'dataInicial' => $dtInicial,
            'dataFinal' => $dtFinal,
            'status' => 1,
        ]), inputPost('page') ?: 1, 20);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-minified table-hover table-bordered table-striped list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('ID', ['width' => 70])
                ->addCell('Campeonato')
                ->addCell('Casa/Fora')
                ->addCell('Ações', ['width' => 50])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 4])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof JogoVO) {

                    $title = <<<HTML
{$v->getTimeCasaTitle()} <img src="{$v->voTimeCasa()->imgCapa()->redimensiona(0, 15)}" /> x <img src="{$v->voTimeFora()->imgCapa()->redimensiona(0, 15)}" /> {$v->getTimeForaTitle()}
<br />
<small>{$v->getData(true)} ás {$v->getHora(true)}</small>
HTML;


                    $t
                        ->addRow('tr-jogo', ['data-token' => $v->getToken()])
                        ->addCell($v->getId(), 'text-center')
                        ->addCell($v->getCampeonatoTitle())
                        ->addCell($title, 'text-center')
                        ->addCell("<div class='btn btn-primary' data-placar='{$v->getToken()}' data-title=\"" . htmlspecialchars($title) . "\"><i class='fa fa-check'></i> Definir</div>");
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive' >{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning no-margin" >'
                . '<i class="fa fa-warning" ></i> Nenhum jogo encontrado.'
                . '</div>';
        }
    }

}
    
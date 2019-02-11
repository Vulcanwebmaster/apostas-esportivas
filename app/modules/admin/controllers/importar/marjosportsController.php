<?php

namespace app\modules\admin\controllers\importar;

use app\core\Controller;
use app\core\crud\Conn;
use app\core\Model;
use app\helpers\Cache;
use app\helpers\Utils;
use app\models\CotacoesModel;
use app\models\JogosModel;
use GuzzleHttp\Client;

class marjosportsController extends Controller
{

    function indexAction()
    {
        $this->view('admin/importar/jogos', [
            'cotacoes' => CotacoesModel::getCotacoesAtivas(),
            'tempos' => JogosModel::TEMPOS,
            'grupos' => CotacoesModel::GRUPOS,
        ]);
    }

    function jogosAction()
    {

        $cache = new Cache('marjosports', '+15minutes');

        if (!$jogos = $cache->getContent()) {
            $client = new Client(['base_url' => 'https://www.jhonlennon.com.br/marjosports/']);
            $jogos = json_decode($client->get('jogos', ['verify' => false])->getBody()->getContents(), true);
            $cache->setContent($jogos);
        }

        $times = [];

        foreach ($jogos['times'] as $key => $time) {
            $times["time{$key}"] = $time;
        }

        if ($times) {

            $keys = ':' . implode(', :', array_keys($times));

            $termos = <<<SQL
SELECT a.title, b.source
FROM `sis_times` AS a, `sis_imagens` AS b
WHERE a.title IN({$keys}) AND b.ref = 'sis_times' AND b.refid = a.id AND b.position = 1 AND b.status = 1
SQL;

            $imagens = [];

            foreach (Model::pdoRead()->FullRead($termos, $times)->getResult() as $img) {
                $imagens[url_paranformat($img['title'])] = $img['source'];
            }

            foreach ($jogos['jogos'] as &$jogo) {
                $jogo['timecasaimg'] = Utils::redimensionaImg(0, 15, $imagens[url_paranformat($jogo['timecasa'])] ?? 'default.jpg');
                $jogo['timeforaimg'] = Utils::redimensionaImg(0, 15, $imagens[url_paranformat($jogo['timefora'])] ?? 'default.jpg');
            }

        }

        return $jogos;
    }

    function importarAction()
    {
        try {

            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', 0.5 * 60 * 60);

            $post = filter_input_array(INPUT_POST);

            $jogos = json_decode($post['jogos'] ?? '[]', true) ?: [];

            $termos = <<<SQL
INSERT INTO 
    `sis_jogos` (`insert`, `update`, `token`, `campeonato`, `datacadastro`, `data`, `hora`, `timecasa`, `timefora`, `status`, `cotacoes`, `refimport`, `limite1`, `limite2`, `limite3`)

SELECT 
    NOW(), NOW(), :token, campeonato.id, CURDATE(), :data, :hora, timecasa.id, timefora.id, 1, :cotacoes, :refimport, 300, 500, 1000

FROM 
    `sis_times` AS timecasa, `sis_times` AS timefora, `sis_campeonatos` AS campeonato
    
WHERE 
    timecasa.title = :timecasa     
    AND timefora.title = :timefora 
    AND campeonato.title = :campeonato

LIMIT 1

ON DUPLICATE KEY UPDATE 
    `cotacoes` = :cotacoes, 
    `data` = :data, 
    `hora` = :hora, 
    `update` = NOW();     
SQL;

            $prepare = Conn::getConn()->prepare($termos);

            $total = count($jogos);
            $alterados = 0;
            $criados = 0;
            $erros = 0;
            $timerecuperados = 0;
            $referencias = [];

            foreach ($jogos as $i => $jogo) {

                if ($i > 0 and $i % 10 === 0) {
                    sleep(1);
                }

                if ($jogo['refid']) {

                    $places = [
                        'token' => Utils::gerarToken(),
                        'data' => $jogo['data'],
                        'campeonato' => $jogo['campeonato'],
                        'timecasa' => $jogo['timecasa'],
                        'timefora' => $jogo['timefora'],
                        'hora' => $jogo['hora'],
                        'cotacoes' => json_encode($jogo['cotacoes']),
                        'refimport' => $jogo['refid'],
                    ];

                    $prepare->execute($places);

                    if ($prepare->rowCount()) {
                        $referencias[] = $jogo['refid'];
                    }

                    if ($prepare->rowCount() == 1) {
                        $criados++;
                    } else if ($prepare->rowCount() == 2) {
                        $alterados++;
                    } else {
                        $erros++;
                    }

                }

            }

            if ($referencias) {

                $referencias = implode("', '", $referencias);

                $prepare = Conn::getConn()->prepare("
UPDATE 
    `sis_times` AS time, `sis_campeonatos` AS campeonato, `sis_jogos` AS jogo
    
SET 
    time.status = 1, 
    campeonato.status = 1
    
WHERE
    jogo.refimport IN('{$referencias}')
    AND time.id IN(jogo.timecasa, jogo.timefora) 
    AND (time.status != 1 OR campeonato.status != 1)
    AND jogo.campeonato = campeonato.id");

                $prepare->execute();
                $timerecuperados = $prepare->rowCount();

            }

            return [
                'message' => "{$criados} jogos criados.\n{$alterados} jogos alterados.\n{$erros} jogos com times ou campeonatos inexistentes.\n{$timerecuperados} times e campeonatos recuperados.\n-----------------------\nTotal de jogos: {$total}\n\nOBS: Caso algum jogo não seja criado vá até as telas de times e campeonatos e importe a lista atualizada.",
                'result' => 1,
            ];
        } catch (\Exception $exception) {
            return $exception;
        }
    }

}
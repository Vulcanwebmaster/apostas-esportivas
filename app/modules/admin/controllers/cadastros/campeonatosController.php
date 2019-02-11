<?php

namespace app\modules\admin\controllers\cadastros;

use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\Utils;
use app\models\CampeonatosModel;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;
use app\vo\admin\MenuVO;
use GuzzleHttp\Client;

class campeonatosController extends Controller
{

    use save;
    use excluir;

    function indexAction(MenuVO $p)
    {
        $this->view('admin/cadastros/campeonatos', ['title' => 'Campeonato']);
    }

    function optionsAction()
    {
        echo CampeonatosModel::options();
    }

    function importarAction()
    {
        try {

            $client = new Client(['base_url' => 'https://www.jhonlennon.com.br/marjosports/']);
            $campeonatos = json_decode($client->get('campeonatos', ['verify' => false])->getBody()->getContents(), true)['campeonatos'] ?? [];

            $termos = <<<SQL
INSERT INTO `sis_campeonatos` (`insert`, `update`, `token`, `title`, `status`, `pais`)
SELECT NOW(), NOW(), :token, :campeonato, 1, 1 FROM DUAL
WHERE NOT EXISTS (SELECT b.title FROM `sis_campeonatos` AS b WHERE b.title = :campeonato LIMIT 1)
LIMIT 1
SQL;

            $prepare = Conn::getConn()->prepare($termos);

            $total = 0;

            foreach ($campeonatos as $time) {
                $prepare->execute([
                    'token' => Utils::gerarToken(),
                    'campeonato' => $time,
                ]);

                $total += $prepare->rowCount();
            }

            $count = count($campeonatos);

            return [
                'message' => "Foi importado {$total} campeonatos de {$count}",
                'result' => 1,
            ];

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 20];

        $busca = CampeonatosModel::busca($parans, $parans['page'], $parans['forpage']);

        $this->view('admin/cadastros/campeonatos', [
            'busca' => $busca
        ], 'list');
    }

    function getModel()
    {
        return CampeonatosModel::Instance();
    }

}
    
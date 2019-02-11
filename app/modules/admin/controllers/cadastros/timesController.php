<?php

namespace app\modules\admin\controllers\cadastros;

use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\Utils;
use app\models\TimesModel;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;
use app\vo\admin\MenuVO;
use GuzzleHttp\Client;

class timesController extends Controller
{

    use save;
    use excluir;

    function indexAction(MenuVO $p)
    {
        $this->view('admin/cadastros/times');
    }

    function optionsAction()
    {
        echo TimesModel::options();
    }

    function importarAction()
    {
        try {

            $client = new Client(['base_url' => 'https://www.jhonlennon.com.br/marjosports/']);
            $times = json_decode($client->get('times', ['verify' => false])->getBody()->getContents(), true)['times'] ?? [];

            $termos = <<<SQL
INSERT INTO `sis_times` (`insert`, `update`, `token`, `title`, `status`)
SELECT NOW(), NOW(), :token, :time, 1 FROM DUAL
WHERE NOT EXISTS (SELECT b.title FROM `sis_times` AS b WHERE b.title = :time LIMIT 1)
LIMIT 1
SQL;

            $prepare = Conn::getConn()->prepare($termos);
			
            $total = 0;

            foreach ($times as $time) {
                $prepare->execute([
                    'token' => Utils::gerarToken(),
                    'time' => $time,
                ]);

                $total += $prepare->rowCount();
            }

            $count = count($times);

            return [
                'message' => "Foi importado {$total} times de {$count}",
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

        $busca = TimesModel::busca($parans, $parans['page'], $parans['forpage']);

        $this->view('admin/cadastros/times', [
            'busca' => $busca,
        ], 'list');
    }

    function getModel()
    {
        return TimesModel::Instance();
    }

}
    
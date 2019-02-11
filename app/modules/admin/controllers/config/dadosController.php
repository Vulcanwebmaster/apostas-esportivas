<?php

namespace app\modules\admin\controllers\config;

use app\core\Controller;
use app\models\DadosModel;
use app\models\HistoricoModel;
use app\modules\admin\Admin;
use app\vo\admin\MenuVO;
use Exception;

class dadosController extends Controller
{

    function indexAction(MenuVO $p)
    {
        $this->view('admin/configuracoes/configuracoes', [
            'config' => DadosModel::get(),
            'types' => [
                'jogador' => 'Jogador',
                'consultor' => 'Consultor',
                'franqueado' => 'Franqueado',
            ],
            'jogos' => [
                1 => '(1 jogo)',
                2 => '(2 jogos)',
                3 => '(3 a 5 jogos)',
                4 => '(6 a 10 jogos)',
                5 => '(11 jogos acima)',
            ]
        ]);
    }

    public function insertAction()
    {
        if (!IS_AJAX) {
            location();
        }

        try {

            if (!Admin::isMaster()) {
                throw new Exception('Somente para desenvolvedores.');
            }

            $config = DadosModel::get();

            $config
                ->save(inputPost())
                ->imgAddCapa('logo', 'logo', true)
                ->imgAddCapa('background', 'background', true);

            HistoricoModel::add("Alterou as configurações do sistema", $config, Admin::getLogged());

            return [
                'message' => 'Configurações atualizadas com sucesso.',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function bloqueioAction()
    {
        if (Admin::isMaster()) {
            $config = DadosModel::get();
            $config->setBloqueado($config->getBloqueado() ? 0 : 1);
            $config->Save();
        }
        location(url_referer());
    }

}
    
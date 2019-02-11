<?php

namespace app\modules\admin\controllers\config;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\HistoricoModel;
use app\vo\HistoricoVO;

class logsController extends Controller
{

    function indexAction()
    {
        $this->view('admin/config/logs');
    }

    function listAction()
    {
        $busca = HistoricoModel::busca(inputPost(), inputPost('page') ?: 1, 50);

        $this->view('admin/config/logs', [
            'busca' => $busca,
        ], 'list');

    }

}
    
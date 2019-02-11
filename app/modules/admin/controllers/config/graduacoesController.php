<?php

namespace app\modules\admin\controllers\config;

use app\core\Controller;
use app\models\GraduacoesModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;

class graduacoesController extends Controller
{

    use save;
    use excluir;

    public function __construct()
    {
        if (!Admin::isMaster())
            location();
    }

    function indexAction()
    {
        $this->view('admin/config/graduacoes');
    }

    function listAction()
    {
        $busca = GraduacoesModel::busca(inputPost(), 1, 50);
        $this->view('admin/config/graduacoes', [
            'busca' => $busca,
        ], 'list');
    }

    function getModel()
    {
        return GraduacoesModel::instance();
    }

}
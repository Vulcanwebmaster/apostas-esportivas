<?php

namespace app\modules\admin\controllers\informacoes;

use app\core\Controller;
use app\models\CotacoesModel;
use app\modules\admin\Admin;

class cotacoesController extends Controller
{

    function indexAction()
    {
        $this->view('admin/informacoes/cotacoes',[
            'grupos' => CotacoesModel::GRUPOS,
            'cotacoes' => CotacoesModel::getCotacoesAtivas(),
        ]);
    }

}
    
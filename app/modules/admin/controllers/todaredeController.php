<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\models\IndicacoesModel;
use app\modules\admin\Admin;

class todaredeController extends Controller
{

    function indexAction()
    {
        $user = Admin::getLogged();
        $this->view('admin/rede/toda-rede', [
            'indicacoes' => IndicacoesModel::getResumo($user),
        ]);
    }

}
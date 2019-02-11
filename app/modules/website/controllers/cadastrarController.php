<?php

namespace app\modules\website\controllers;

use app\core\Controller;
use app\helpers\Seo;
use app\models\financeiro\SaquesModel;

class cadastrarController extends Controller
{

    function indexAction(){
        Seo::setTitle('Cadastre-se');
        $this->view('website/page/cadastrar',[
            'bancos' => SaquesModel::optionsBancos(),
        ]);
    }

}
<?php

namespace app\modules\api\controllers;

use app\core\Controller;
use app\models\DadosModel;

class indexController extends Controller
{

    function indexAction()
    {

        $dados = DadosModel::get();

        return [
            'title' => $dados->getBanca(),
            'apostaMin' => $dados->getApostaMinima(),
            'apostaMax' => $dados->getApostaMaxima(),
            'cotacaoMin' => $dados->getCotacaoMinima(),
            'cotacaoMax' => $dados->getCotacaoMaxima(),
            'minJogos' => $dados->getMinJogos(),
            'retornoMaximo' => $dados->getRetornoMaximo(),
            'logotipo' => $dados->imgCapa(true, 'logo')->getSource(true),
            'background' => $dados->imgCapa(true, 'background')->getSource(true),
            'result' => 1,
        ];
    }

    function validarAction()
    {
        return [
            'url' => url(null, null, 'api'),
            'result' => 1,
        ];
    }

}
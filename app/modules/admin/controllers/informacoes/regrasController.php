<?php

namespace app\modules\admin\controllers\informacoes;

use app\core\Controller;
use app\models\DadosModel;
use app\modules\admin\Admin;

class regrasController extends Controller
{

    function indexAction()
    {
        $config = DadosModel::get();
        $this->view('admin/informacoes/regras', [
            'title' => 'Regras',
            'field' => 'regulamento',
            'regra' => $config->getRegulamento(),
        ]);
    }

    function impressorasACtion()
    {
        $config = DadosModel::get();
        $this->view('admin/informacoes/regras', [
            'title' => 'Impressoras',
            'field' => 'textoimpressoras',
            'regra' => $config->getTextoImpressoras(),
        ]);
    }

    function apostaACtion()
    {
        $config = DadosModel::get();
        $this->view('admin/informacoes/regras', [
            'title' => 'Regras da aposta PDF',
            'field' => 'regrasaposta',
            'regra' => $config->getRegrasAposta(),
        ]);
    }

}
    
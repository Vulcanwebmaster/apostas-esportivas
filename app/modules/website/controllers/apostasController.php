<?php

namespace app\modules\website\controllers;

use app\core\Controller;
use app\models\ApostasModel;
use app\modules\admin\Admin;
use app\vo\ApostaVO;

class apostasController extends Controller
{

    function indexAction()
    {
        $this->view('website/page/apostas');
    }

    /**
     * Impressão da Aposta
     */
    function imprimirAction()
    {

        $aposta = ApostasModel::getByLabel('token', url_parans(0));

        if ($aposta instanceof ApostaVO) {

            $toHtml = url_parans(1) == 'html';

            $html = $this->view('admin/apostas/pdf', [
                'aposta' => $aposta,
                'jogos' => $aposta->voJogos(),
            ], null, !$toHtml);

            if (!$toHtml)
                displayPdf($html, 'aposta-' . $aposta->getId(), 300, 500);

        }
    }

    function listAction()
    {
        try {

            $user = Admin::getLogged();

            if (!$user) {
                throw new \Exception("Você precisa fazer login para listar as apostas");
            }

            $parans = inputPost();
            $parans['user'] = $user->getId();
            $parans += ['page' => 1, 'forpage' => 30];

            $busca = ApostasModel::busca($parans, $parans['page'], $parans['forpage']);

            $this->view('website/page/apostas', [
                'busca' => $busca,
            ], 'list');

        } catch (\Exception $ex) {
            $this->view('website/page/apostas', [
                'message' => $ex->getMessage(),
            ], 'list');
        }
    }

}
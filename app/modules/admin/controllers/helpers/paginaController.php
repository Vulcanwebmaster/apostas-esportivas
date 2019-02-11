<?php

namespace app\modules\admin\controllers\helpers;

use app\core\Controller;
use app\models\helpers\PaginasModel;
use app\vo\admin\MenuVO;
use app\vo\helpers\PaginaVO;
use Exception;

class paginaController extends Controller
{

    function indexAction(MenuVO $p)
    {
        $vars = $p->getVariaveis(true);
        $pagina = PaginasModel::getByRef($vars['ref'], (int)@$vars['refid'], true);
        $this->view('admin/helpers/pagina', [
            'vars' => $vars += ['_titulo' => 1, '_texto' => 1],
            'v' => $pagina,
        ]);
    }

    function updateAction()
    {
        try {

            $v = PaginasModel::getByLabel('id', inputPost('id'));

            if (!$v instanceof PaginaVO) {
                throw new Exception('Página inválida');
            }

            $v
                ->input('title')
                ->input('descricao')
                ->input('texto')
                ->Save()
                ->imgAdd('upimagens');

            return ['message' => 'Página atualizada com sucesso', 'result' => 1];
        } catch (Exception $ex) {
            return $ex;
        }
    }

}
    
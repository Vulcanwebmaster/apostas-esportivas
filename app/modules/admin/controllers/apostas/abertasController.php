<?php

namespace app\modules\admin\controllers\apostas;

use app\core\Controller;
use app\modules\admin\Admin;

class abertasController extends Controller
{

    function indexAction()
    {
        $this->view('admin/apostas/listar', [
            'type' => 'abertas',
            'searchValues' => [
                'verificado' => 0,
            ],
        ]);
    }

}
    
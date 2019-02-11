<?php

namespace app\modules\admin\controllers\config;

use app\core\Controller;
use app\models\LicencasModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;

class licencasController extends Controller
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
        $this->view('admin/config/licencas');
    }

    function listAction()
    {
        $busca = LicencasModel::busca(inputPost(), 1, 50);
        $this->view('admin/config/licencas', [
            'busca' => $busca,
        ], 'list');
    }

    function getModel()
    {
        return LicencasModel::instance();
    }

}
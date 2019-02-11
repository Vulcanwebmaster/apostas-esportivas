<?php

namespace app\modules\website;

use app\APP;
use app\helpers\Seo;
use app\models\DadosModel;
use app\modules\admin\Admin;

class Site
{

    public function __construct()
    {
        if (!IS_AJAX) {
            $this->assets();
        }

        if (APP::getCurrentModule() == 'site2')
            view_vars('responsive', true);

        view_vars('user', Admin::getLogged());

        view_vars('isMaster', Admin::isMaster());
        view_vars('isDev', Admin::isDeveloper());

    }

    function assets()
    {
        $dados = DadosModel::get();
        Seo::setTitle($dados->getBanca());
    }

}
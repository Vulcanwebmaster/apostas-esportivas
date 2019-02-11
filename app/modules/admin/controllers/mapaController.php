<?php

namespace app\modules\admin\controllers;

class mapaController extends \app\core\Controller
{

    function indexAction()
    {
        view_load('admin/sys/mapa', null, false);
    }

}
    
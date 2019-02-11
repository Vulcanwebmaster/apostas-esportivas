<?php

namespace app\modules\auth\controllers;

use app\core\Controller;
use app\models\UsersModel;

class indexController extends Controller
{

    function indexAction()
    {
        location(url(null, null, 0));
    }

    function logOutAction()
    {
        UsersModel::Instance()->logOut();
        location();
    }

}

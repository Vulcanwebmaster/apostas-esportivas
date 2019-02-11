<?php

namespace app\modules\auth\controllers;

use app\core\Controller;
use app\models\UsersModel;
use app\modules\admin\Admin;

class loginController extends Controller
{

    function insertAction()
    {
        try {

            $user = UsersModel::login(inputPost('username'), inputPost('password'));

            UsersModel::setLogged($user);

            setcookie('user', $user->getToken(), strtotime('+1year'), '/');

            return [
                'message' => "{$this->tratamento()} {$user->getNome()}",
                'url' => url(null, null, (Admin::isMaster() or Admin::isGerente()) ? 'admin' : null),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function tratamento()
    {
        $hr = (int)date('H');

        if ($hr >= 12 and $hr <= 18) {
            return 'Boa tarde';
        } else if ($hr >= 5 and $hr <= 11) {
            return 'Bom dia';
        } else {
            return 'Boa noite';
        }
    }

}
<?php

namespace app\modules\api;

use app\models\UsersModel;
use app\vo\UserVO;

class API
{

    public function __construct()
    {
        ini_set('display_errors', true);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: *");

        if (IS_OPTIONS)
            json([
                'title' => 'API de Jogos Online',
                'url' => base_url(),
            ], 1);
    }

    /**
     * @return UserVO
     * @throws \Exception
     */
    public static function getUser()
    {

        $token = getenv('HTTP_APPTOKEN');

        $user = current(UsersModel::lista('WHERE a.appid = :token AND a.status = 1 LIMIT 1', [
            'token' => $token,
        ]));

        if (!$user instanceof UserVO) {
            throw new \Exception("Sua sessão expirou tente fazer login novamente", 401);
        }

        return $user;

    }

}
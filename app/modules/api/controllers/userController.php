<?php

namespace app\modules\api\controllers;

use app\core\Controller;
use app\helpers\Utils;
use app\helpers\VALIDAR;
use app\models\UsersModel;
use app\modules\api\API;
use app\modules\api\serialize\UserSerialize;

class userController extends Controller
{

    function loginAction()
    {
        try {

            $username = inputPost('username');
            $password = inputPost('password');

            VALIDAR::username($username);

            // Acessando
            $user = UsersModel::LogIn($username, $password);

            $user->setAppId(Utils::gerarToken())->save();

            return [
                'appToken' => $user->getAppId(),
                'message' => 'Seja bem vindo, ' . $user->getNome() . '!',
                'user' => new UserSerialize($user),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function alterarSenhaAction()
    {
        try {

            $user = API::getUser();

            $senha = password(inputPost('senha'));
            $nSenha = inputPost('nsenha');
            $rSenha = inputPost('rsenha');

            if ($senha != $user->getSenha()) {
                throw new \Exception("Senha incorreta, verifica sua senha atual");
            } else if (!$nSenha) {
                throw new \Exception("Informe a nova senha");
            } else if ($nSenha != $rSenha) {
                throw new \Exception("Senhas incompatíveis");
            }

            VALIDAR::password($nSenha);

            $user->setSenha($nSenha)->save();

            return [
                'message' => 'Senha alterada com sucesso',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function logoutAction()
    {
        try {

            $user = API::getUser();

            $user->setAppId('')->save();

            return [
                'message' => 'Saiu da sessão',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function dadosAction()
    {
        try {

            $user = API::getUser();

            return [
                'user' => new UserSerialize($user),
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
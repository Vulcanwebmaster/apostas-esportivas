<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 27/07/2017
 * Time: 21:32
 */

namespace app\modules\admin\controllers;


use app\core\Controller;
use app\helpers\SMail;
use app\models\HistoricoModel;
use app\models\IndicacoesModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\UserVO;

class mensagemController extends Controller
{

    function indexAction()
    {
        $user = Admin::getLogged();

        $indicadores = IndicacoesModel::getIndicadores($user);
        $indicados = IndicacoesModel::getIndicados($user);

        $this->view('admin/helpers/enviar-mensagem', [
            'indicadores' => $indicadores,
            'indicados' => $indicados
        ]);
    }

    function insertAction()
    {
        try {

            $mensagem = inputPost('mensagem');
            $assunto = inputPost('assunto');

            if (!trim($mensagem)) {
                throw new \Exception('Preencha o campo com sua mensagem');
            } else if (!trim($assunto)) {
                throw new \Exception('Informe o assunto da mensagem');
            }

            /** @var UserVO[] $pessoas */
            $pessoas = [];

            $smail = new SMail();

            $smail->setContent("UolBet: {$assunto}", $mensagem);
            $smail->setFrom(Admin::getLogged()->getNome(), Admin::getLogged()->getEmail());

            foreach ($_POST['pessoas_array'] as $token) {
                $user = UsersModel::getByLabel('token', $token);
                if ($user instanceof UserVO) {
                    $pessoas[] = $user;
                    $smail->addAddress($user->getNome(), $user->getEmail());
                }
            }

            if (!$pessoas) {
                throw new \Exception('Selecione no mínimo um destinatário');
            }

            $smail->Send();

            HistoricoModel::add("Enviou uma mensagem", null, Admin::getLogged());

            return [
                'message' => 'Mensagem enviada com sucesso',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
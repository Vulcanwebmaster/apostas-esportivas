<?php

namespace app\modules\admin\controllers\config;

use app\models\HistoricoModel;
use app\models\SmtpModel;
use app\modules\admin\Admin;
use app\vo\admin\MenuVO;
use app\vo\SmtpVO;

class smtpController extends \app\core\Controller
{

    function indexAction(MenuVO $Pagina)
    {
        $this->view('admin/configuracoes/smtp', [
            'smtp' => SmtpModel::getConfig(),
        ]);
    }

    /** @return SmtpModel */
    function getModel()
    {
        return SmtpModel::Instance();
    }

    function Save(SmtpVO $v)
    {
        try {

            if (!Admin::isMaster()) {
                throw new \Exception("Somente administradores");
            } else if (!$v->getId()) {
                throw new \Exception('Configurações inválidas.');
            }

            $v->save(inputPost());

            HistoricoModel::add("Alterou as configurações de SMTP do sistema", $v, Admin::getLogged());

            json('Configurações salvas com sucesso.', 1);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
    
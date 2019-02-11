<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\models\HistoricoModel;
use app\models\LicencasModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\vo\LicencaVO;

class upgradeController extends Controller
{

    function indexAction()
    {
        $this->view('admin/licencas/upgrade', [
            'licencas' => LicencasModel::getLicencas(),
        ]);
    }

    function migrarAction()
    {

        $user = Admin::getLogged();

        try {
            $licenca = LicencasModel::getByLabel('id', inputPost('licenca'));

            if (!$licenca instanceof LicencaVO) {
                throw new \Exception("Licença inválida");
            } else if ($user->getLicenca() == $licenca->getId()) {
                throw new \Exception("Sua licença já é {$licenca->getTitle()}");
            }

            $user->setPagouPlano(0);
            $user->setDataValidade('');
            $user->setLicenca($licenca->getId());

            UsersModel::ativarPlano($user);

            HistoricoModel::add("Migrou para a licença {$licenca->getTitle()}", null, $user);

            return [
                'result' => 1,
                'message' => 'Migração realizada com sucesso! Confira seu histórico financeiro para acompanhar os seus ganhos com a nova licença.',
            ];
        } catch (\Exception $ex) {
            HistoricoModel::add("Tentou migrar de licença", null, $user);
            return $ex;
        }
    }

}
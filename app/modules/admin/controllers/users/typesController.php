<?php

namespace app\modules\admin\controllers\users;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\UsersModel;
use app\models\UsersTypesModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\save;
use app\vo\admin\MenuVO;
use app\vo\UserTypeVO;

class typesController extends Controller
{

    use excluir;
    use save;

    function indexAction(MenuVO $p)
    {
        $this->view('admin/forms/usuarios_tipos',[
            'types' => UsersTypesModel::options(Admin::getLogged()->getType()),
        ]);
    }

    /** @return UsersTypesModel */
    function getModel()
    {
        return UsersTypesModel::Instance();
    }


    function listAction()
    {

        /* @var $v UserTypeVO */
        $t = (new Table(null, 'table table-bordered table-striped table-hover'))
            ->addTSection('thead')
            ->addRow()
            ->addCell('ID', 'text-center', null,['width' => 90])
            ->addCell('Título')
            ->addCell('Permissões')
            ->addCell('Ações', ['width' => 120])
            ->addTSection('tbody');

        foreach (UsersModel::getUserTypes(Admin::getLogged()->getType()) as $v) {
            $t->addRow()
                ->addCell($v->getId(), 'text-center')
                ->addCell($v->gettitle())
                ->addCell(call_user_func(function (array $Permissoes) {
                    $html = '';
                    foreach ($Permissoes as $permissao) {
                        $type = UsersTypesModel::getByLabel('id', $permissao);
                        if ($type instanceof UserTypeVO)
                            $html .= '<div>' . $type->getTitle() . '</div>';
                    }
                    return $html;
                }, $v->getPermissoes(true)))
                ->addCell('<div class="btn-group" >'
                    . '<div class="btn btn-default" data-editar="' . $v . '" ><i class="fa fa-edit" ></i></div>'
                    . '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" ></i></div>'
                    . '</div>', 'text-center');
        }

        echo (new Panel)
            ->setBody('<div class="table-responsive" >' . $t . '</div>');
    }

}
    
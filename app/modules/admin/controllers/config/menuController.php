<?php

namespace app\modules\admin\controllers\config;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\admin\MenuModel;
use app\models\HistoricoModel;
use app\models\ModulesModel;
use app\models\UsersTypesModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\status;
use app\vo\admin\MenuVO;
use Exception;

class menuController extends Controller
{

    use excluir;
    use status;

    public function indexAction(MenuVO $p)
    {
        $this->view('admin/sys/menu', [
            'permissoes' => UsersTypesModel::Instance()->options(Admin::getLogged()->getType()),
            'optModules' => ModulesModel::options(),
            'page' => $p,
        ]);
    }

    public function Save(MenuVO $v)
    {
        try {

            $novo = !$v->getId();
            $v->save(inputPost());

            HistoricoModel::add($novo ? "Criou o menu #{$v->getId()}" : "Alterou o menu #{$v->getId()}", $v, Admin::getLogged());

            json('Registro inserido/atualizado com sucesso!', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function listAction()
    {

        $options = '';

        foreach (ModulesModel::Instance()->lista('WHERE a.status = 1 ORDER BY a.ordem ASC, a.title ASC') as $module) {

            if ($menu = $this->getModel()->getMenu(0, $module->getUri(), null)) {

                $t = (new Table(null, 'table table-hover table-bordered table-striped'))
                    ->addTSection('thead')
                    ->addRow()
                    ->addCell('#', ['width' => 50])
                    ->addCell('Posição', ['width' => 50])
                    ->addCell('Título')
                    ->addCell('Permissões')
                    ->addCell('Ações', ['width' => 120])
                    ->addTSection('tbody');

                $this->trMenu($t, $menu);

                $options .= '<optgroup label="' . htmlspecialchars($module->getTitle()) . '" >'
                    . $this->getRoots($menu)
                    . '</optgroup>';

                echo (new Panel)
                    ->setHeader('<h3 class="panel-title" >' . $module->getTitle() . ' - <u>' . $module->getURI() . '</u></h3>')
                    ->setBody('<div class="table-responsive" >' . $t . '</div>');
            }
        }

        echo "<script>"
            . "$('#form-this').find('[name=root]').html(\"" . addslashes(formOption('-- Selecione --', 0) . $options) . "\");"
            . "</script>";
    }

    /** @return MenuModel */
    function getModel()
    {
        return MenuModel::Instance();
    }

    /**
     * @param Table $t
     * @param array $menus
     * @param int $root
     */
    public function trMenu(Table &$t, array $menus, int $root = 0)
    {
        foreach ($menus as $key => $v) {
            if ($v->getRoot() == $root) {

                if ($v->getStatus() == 0) {
                    $class = 'danger';
                } else if ($v->getPrincipal()) {
                    $class = 'success';
                } else if (!$v->getRoot()) {
                    $class = 'info';
                } else {
                    $class = '';
                }

                $t->addRow($class)
                    ->addCell($v->getId(), 'text-center')
                    ->addCell($v->getOrdem(), 'text-center')
                    ->addCell(($v->getIcone() ? "<i class=\"{$v->getIcone()}\" ></i> " : null) . $v->getTitle())
                    ->addCell($v->getPermissoesTitles())
                    ->addCell('<div class="btn-group" >'
                        . '<div class="btn btn-default" data-status="' . $v->getToken() . '" ><i class="fa fa-eye' . ($v->getStatus() == 1 ? '' : '-slash') . '" data-toggle="tooltip" title="Status" ></i></div>'
                        . '<div class="btn btn-default" data-editar="' . $v . '" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></div>'
                        . '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" data-toggle="tooltip" title="Excluir" ></i></div>'
                        . '</div>'
                        , 'text-center');

                $this->trMenu($t, $menus, $v->getId());
            }
        }
    }

    /**
     * @param MenuVO[] $menu
     * @param int $root
     * @param int $nivel
     * @return string
     */
    private function getRoots(array $menu, $root = 0, $nivel = 0)
    {
        $html = '';

        foreach ($menu as $v) {
            if ($v->getRoot() == $root) {
                $html .= formOption(trim(str_pad('', $nivel, '-', STR_PAD_LEFT) . ' ' . $v->getTitle()), $v->getId());
                $html .= $this->getRoots($menu, $v->getId(), $nivel + 1);
            }
        }

        return $html;
    }

}
    
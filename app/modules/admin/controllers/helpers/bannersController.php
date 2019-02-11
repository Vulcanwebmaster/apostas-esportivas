<?php

namespace app\modules\admin\controllers\helpers;

use app\core\Controller;
use app\helpers\PanelBootstrap;
use app\helpers\Table;
use app\models\helpers\BannersModel;
use app\traits\ctrl\excluir;
use app\traits\ctrl\status;
use app\vo\admin\MenuVO;
use app\vo\helpers\BannerVO;

class bannersController extends Controller
{

    use excluir;
    use status;

    function indexAction(MenuVO $page = null)
    {
        $this->view('admin/helpers/banners', [
            'page' => $page,
            'vars' => $page->getVariaveis(true),
        ]);
    }


    public function save(BannerVO $v)
    {
        try {

            $v->save($_POST);
            $v->imgAddCapa('updesktop', 'desktop', true);
            $v->imgAddCapa('upmobile', 'mobile', true);

            return [
                'result' => 1,
                'message' => 'Salvo com sucesso',
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {
        $busca = $this->getModel()->busca(inputPost() + ['orderby' => 'title'], (int)inputPost('page') ?: 1, 10);

        $ref = inputPost('ref');

        if ($busca->getCount()) {

            $t = (new Table(null, 'table table-bordered table-striped table-hover'));
            $t->addTSection('thead')
                ->addRow()
                ->addCell('<i class="fa fa-sort-amount-asc"></i>', 'text-center', null, ['width' => 50])
                ->addCell('<i class="fa fa-desktop"></i>', 'text-center', null, ['width' => 50])
                ->addCell('<i class="fa fa-mobile"></i>', 'text-center', null, ['width' => 50]);

            if (inputPost('_periodo')) {
                $t
                    ->addCell('Início', ['width' => 120])
                    ->addCell('Fim', ['width' => 120]);
            }

            if (inputPost('_title')) {
                $t->addCell('Título');
            }

            $t->addCell('Ações', ['width' => 50])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 10])
                ->addTSection('tbody');

            /* @var $v BannerVO */
            foreach ($busca->getRegistros() as $v) {

                $t->addRow()
                    ->addCell($v->getOrdem(), 'text-center')
                    ->addCell('<img src="' . $v->imgCapa(true, 'desktop')->redimensiona(80, 40, 'preenchimento') . '" />', 'text-center')
                    ->addCell('<img src="' . $v->imgCapa(true, 'mobile')->redimensiona(80, 40, 'preenchimento') . '" />', 'text-center');

                if (inputPost('_periodo')) {
                    $t->addCell($v->getInicio(true), 'text-center')
                        ->addCell($v->getFim(true), 'text-center');
                }

                if (inputPost('_title')) {
                    $t->addCell($v->getTitle());
                }

                $t->addCell('<div class="btn-group" >'
                    . '<div class="btn btn-default" data-status="' . $v->getToken() . '" ><i class="fa fa-eye' . ($v->getstatus() != 1 ? '-slash' : null) . '" ></i></div>'
                    . '<div class="btn btn-default" data-editar="' . $v . '" ><i class="fa fa-edit" ></i></div>'
                    . '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-trash" ></i></div>'
                    . '</div>', 'text-center');
            }

            echo (new PanelBootstrap)
                ->setHeader('<h3 class="panel-title" >Lista</h3>')
                ->setBody($t->display())
                ->setFooter($busca->display(), ['class' => 'text-right']);
        } else {
            echo <<<HTML
<div class="alert alert-warning" >
    <i class="fa fa-warning" ></i> Nenhuma imagem cadastrada até o momento
</div>
HTML;

        }
    }

    /** @return BannersModel */
    function getModel()
    {
        return BannersModel::instance();
    }

}
    
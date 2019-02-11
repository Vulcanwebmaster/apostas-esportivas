<?php

namespace app\modules\admin\controllers\jogos;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\JogosModel;
use app\vo\JogoVO;

class encerradosController extends Controller
{

    function indexAction()
    {
        $this->view('admin/jogos/encerrados');
    }

    function listAction()
    {

        $parans = inputPost();
        $parans['status'] = 2;
        $parans += ['page' => 1, 'forpage' => 20];

        $busca = JogosModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-minified table-hover table-bordered table-striped list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('ID', ['width' => 70])
                ->addCell('Campeonato')
                ->addCell('Casa/Fora')
                ->addCell('Ações', ['width' => 90])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 4])
                ->addTSection('tbody');

            /** @var JogoVO $v */
            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof JogoVO) {


                    $title = <<<HTML
{$v->getTimeCasaTitle()} <img src="{$v->voTimeCasa()->imgCapa()->redimensiona(0, 15)}" /> x <img src="{$v->voTimeFora()->imgCapa()->redimensiona(0, 15)}" /> {$v->getTimeForaTitle()}
<br />
<small>{$v->getData(true)} ás {$v->getHora(true)}</small>
HTML;

                    $t
                        ->addRow()
                        ->addCell($v->getId(), 'text-center')
                        ->addCell($v->getCampeonatoTitle())
                        ->addCell($title, 'text-center')
                        ->addCell(strtr('<div class="btn-group" >'
                            . '<a class="btn btn-default" href="admin/jogos/adicionar/editar/{token}" ><i class="fa fa-edit" data-toggle="tooltip" title="Editar" ></i></a>'
                            . '<div class="btn btn-default" data-title="{title}" data-redefinir="{token}"><i class="fa fa-recycle" data-toggle="tooltip" title="Redefinir"></i></div>'
                            . '</div>', [
                            '{token}' => $v->getToken(),
                            '{title}' => htmlspecialchars($title),
                        ]), 'text-center');
                }
            }

            echo (new Panel)
                ->setBody("<div class='table-responsive' >{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning no-margin" >'
                . '<i class="fa fa-warning" ></i> Nenhum jogo encontrado.'
                . '</div>';
        }
    }

}
    
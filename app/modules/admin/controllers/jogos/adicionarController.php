<?php

namespace app\modules\admin\controllers\jogos;

use app\APP;
use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\CotacoesModel;
use app\models\HistoricoModel;
use app\models\JogosModel;
use app\modules\admin\Admin;
use app\vo\admin\MenuVO;
use app\vo\JogoVO;
use Exception;

class adicionarController extends Controller
{


    public function indexAction(MenuVO $p)
    {
        $this->view('admin/jogos/adicionar');
    }

    function novoAction()
    {
        $this->form(JogosModel::newValueObject(), 'Novo Jogo');
    }

    function form(JogoVO $jogo, string $title)
    {
        $this->view('admin/jogos/form', [
            'v' => $jogo,
            'cotacoes' => CotacoesModel::getCotacoesAtivas('a.ordem ASC, a.titulo ASC, a.grupo ASC'),
            'tempos' => JogosModel::TEMPOS,
            'title' => $title,
        ]);
    }

    function editarAction()
    {
        $jogo = JogosModel::getByLabel('token', url_parans(0));
        if ($jogo instanceof JogoVO) {
            $this->form($jogo, 'Editar Jogo');
        } else {
            location(url_referer());
        }
    }

    function todosAction()
    {
        if (!IS_AJAX) {
            location();
        }

        try {

            $jogosAdd = 0;

            $jogos = filter_input(INPUT_POST, 'jogos', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);


            foreach ($jogos as $dados) {
                $jogo = JogosModel::newValueObject($dados)->Save();
                $jogosAdd++;
            }

            if (!$jogosAdd) {
                throw new Exception('Nenhum jogo foi adicionado.');
            }

            HistoricoModel::add("Adicionou {$jogosAdd} jogos.", null, Admin::getLogged());

            json($jogosAdd > 1 ? "{$jogosAdd} jogos adicionados." : "Jogo adicionado com sucesso.", 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function listAction()
    {

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 20, 'status' => 1];

        $busca = JogosModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-hover table-bordered table-minified list-table');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('ID', ['width' => 50])
                ->addCell('Data cadastro', ['width' => 180])
                ->addCell('Campeonato')
                ->addCell('Time x Fora')
                ->addCell('Ações', ['width' => 100])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 5])
                ->addTSection('tbody');

            foreach ($busca->getRegistros() as $v) {
                if ($v instanceof JogoVO) {
                    $t
                        ->addRow()
                        ->addCell($v->getId(), 'text-center')
                        ->addCell(str_replace(' ', ' - ', $v->getInsert(true)), 'text-center')
                        ->addCell($v->getCampeonatoTitle())
                        ->addCell("{$v->getTimeCasaTitle()} <img src=\"{$v->voTimeCasa()->imgCapa()->redimensiona(0, 15)}\" /> <b> x </b> <img src=\"{$v->voTimeFora()->imgCapa()->redimensiona(0, 15)}\" /> {$v->getTimeForaTitle()}<br /><small>{$v->getData(true)} ás {$v->getHora(true)}</small>", 'text-center')
                        ->addCell('<div class="btn-group" >'
                            . '<a class="btn btn-default" href="' . url(APP::getControllerName() . '/editar', [$v->getToken()]) . '" ><i class="fa fa-edit" ></i></a>'
                            . '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-trash" ></i></div>'
                            . '</div>', 'text-center');
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
    
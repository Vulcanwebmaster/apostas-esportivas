<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Table;
use app\models\IndicacoesModel;
use app\modules\admin\Admin;
use app\vo\admin\MenuVO;
use app\vo\IndicacaoVO;

class indicacoesController extends Controller
{

    function indexAction(MenuVO $p = null)
    {
        $vars = $p ? $p->getVariaveis(true) : [];
        $this->view('admin/rede/indicacoes', [
            'vars' => $vars,
        ]);
    }

    function csvAction()
    {

        ob_clean();

        header('Content-type: text/csv; charset=ISO-8859-1');
        header('Content-disposition: Attachament; filename=indicados.csv');

        echo "nome;email";

        foreach (IndicacoesModel::getIndicados(Admin::getLogged(), 1) as $indicacao) {
            $indicado = $indicacao->voIndicado();

            if ($indicado) {
                echo PHP_EOL;
                echo utf8_decode("{$indicado->getNome()};{$indicado->getEmail()}");
            }
        }

    }

    function indicacoesAction()
    {

        $logged = Admin::getLogged();
        $indicados = IndicacoesModel::getIndicados($logged);
        $result = [];

        // Listando as indicações
        foreach (range(1, 5) as $nivel) {
            foreach ($indicados as $key => $indicacao) {
                if ($indicacao->getNivel() == $nivel) {

                    $indicado = $indicacao->voIndicado();

                    $direto = IndicacoesModel::getIndicadorDireto($indicado);

                    $result[] = [
                        'token' => $indicacao->getToken(),
                        'id' => $indicado->getId(),
                        'nivel' => $nivel,
                        'indicador' => $direto ? $direto->getIndicador() : null,
                        'login' => $indicado->getLogin(),
                        'licenca' => ucfirst($indicado->getLicencaTitle()) . ' "' . ($indicado->getPagouPlano() ? 'Ativo' : 'Inativo') . '"',
                        'ativo' => $indicado->estaEmDia() ? 1 : 0,
                        'indicados' => 0,
                        'apostas' => $indicado->getQtdeApostas(),
                        'graduacao' => $indicado->getGraduacaoTitle(),
                    ];

                    unset($indicados[$nivel]);

                }
            }
        }

        // Contando as indicaçoes diretas dentro da rede
        foreach ($result as &$indicado) {
            foreach ($result as $v) {
                if ($v['indicador'] == $indicado['id']) {
                    $indicado['indicados']++;
                }
            }
        }

        return [
            'indicados' => $result,
        ];
    }

    function listAction()
    {

        $parans = inputPost();
        $parans += ['page' => 1, 'forpage' => 20];
        $parans['indicador'] = Admin::getIdLogged();

        $busca = IndicacoesModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-striped table-bordered table-hover');

            $t
                ->addTSection('thead')
                ->addRow()
                ->addCell('Nível', ['width' => 50])
                ->addCell('Indicado/Login')
                ->addCell('DT/Cadastro')
                ->addCell('Licença')
                ->addCell('Telefone')
                ->addCell('E-mail')
                ->addCell('Cidade/UF')
                ->addCell('Detalhes', ['width' => 30])
                ->addTSection('tfoot')
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 10])
                ->addTSection('tbody');

            /** @var IndicacaoVO $indicacao */
            foreach ($busca->getRegistros() as $indicacao) {

                $indicado = $indicacao->voIndicado();
                $showInfo = ($indicacao->getNivel() == 1 or Admin::isMaster());

                $detalhes = [
                    'nome' => $indicado->getNome(),
                    'graduacao' => $indicado->getGraduacaoTitle(),
                    'apostas' => $indicado->get('qtdeapostas'),
                    'indicados' => $indicado->get('qtdeindicados'),
                ];


                $t
                    ->addRow()
                    ->addCell($indicacao->getNivel(), 'text-center')
                    ->addCell("{$indicado->getNome()}<br /><b>{$indicado->getLogin()}</b>")
                    ->addCell($indicado->getDataCadastro(true), 'text-center')
                    ->addCell(ucfirst($indicado->getLicencaTitle()) . ($indicado->getPagouPlano() ? ' (Ativo)' : ' (Inativo)'), 'text-center')
                    ->addCell($showInfo ? $indicado->getTelefone() : '(**) *****-****', 'text-center')
                    ->addCell($showInfo ? $indicado->getEmail() : '**********')
                    ->addCell($indicado->getCidadeTitle() . '/' . $indicado->getUf())
                    ->addCell('<div class="btn btn-info" data-detalhes="' . htmlspecialchars(json_encode($detalhes)) . '"><i class="fa fa-eye"></i></div>', 'text-center');
            }

            echo (new Panel())
                ->setBody("<div class='table-responsive'>{$t}</div>")
                ->setFooter($busca, ['class' => 'text-right']);

        } else {
            echo <<<HTML
<div class="alert alert-warning">
    Nenhuma indicação encontrada.
</div>
HTML;

        }
    }

}
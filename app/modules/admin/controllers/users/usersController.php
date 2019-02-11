<?php

namespace app\modules\admin\controllers\users;

use app\core\Controller;
use app\helpers\bootstrap\Panel;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Table;
use app\models\DadosModel;
use app\models\GraduacoesModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\models\UsersTypesModel;
use app\modules\admin\Admin;
use app\traits\ctrl\excluir;
use app\traits\ctrl\status;
use app\vo\admin\MenuVO;
use app\vo\UserVO;
use Exception;

class usersController extends Controller
{

    use excluir;
    use status;

    public function indexAction(MenuVO $p)
    {
        $this->view('admin/usuarios/lista', [
            'vars' => $p->getVariaveis(true) + ['type' => UsersModel::TYPE_CLIENTE],
            'graduacoes' => GraduacoesModel::getGraduacoes(),
        ]);
    }

    function optionsAction()
    {
        echo UsersModel::options(null, Admin::getLogged()->getType());
    }

    function csvAction()
    {
        if (Admin::isMaster()) {

            ob_clean();

            header('Content-type: text/csv; charset=ISO-8859-1');
            header('Content-disposition: Attachament; filename=emails.csv');

            $busca = UsersModel::busca(inputGet(), 1, 99999);

            echo "nome;email";

            /** @var UserVO $v */
            foreach ($busca->getRegistros() as $v) {
                echo PHP_EOL;
                echo utf8_decode("{$v->getNome()};{$v->getEmail()}");
            }

        } else {
            location();
        }
    }

    function creditoAction()
    {
        try {


            if (!Admin::isMaster()) {
                throw new Exception('Função disponível apenas para administradores');
            }

            $adm = UsersModel::getLogged();
            $user = UsersModel::getByLabel('token', inputPost('user'));
            $add = inputPost('acao') != 'remover';

            if (!$user instanceof UserVO) {
                throw new Exception('Usuário inválido');
            }

            foreach ([
                         'credito' => 'créditos',
                     ] as $key => $title) {

                if ($valor = Number::float(inputPost($key)) and $valor > 0) {

                    if (!$add) {
                        $valor = -$valor;
                    }

                    $valorDesc = Number::real($valor);

                    if ($valor > 0) {
                        $descricao = "<b>({$adm->getLogin()})</b> adicionou {$valorDesc} {$title} a sua conta";
                    } else {
                        $descricao = "<b>({$adm->getLogin()})</b> removeu {$valorDesc} {$title} da sua conta";
                    }

                    HistoricoBancarioModel::add($user, $valor, $descricao, $adm, 'administrador');

                    HistoricoModel::add("Adicionou {$title} ao usuário #{$user->getId()}", $user, Admin::getLogged());

                }

            }

            return [
                'message' => 'Transação realizada com sucesso',
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Atualiza as informações do usuário
     * @param UserVO $user
     * @throws Exception
     */
    public function save(UserVO $user)
    {
        try {

            $novo = !$user->getId();

            if ($novo)
                $user->setUser(Admin::getIdLogged());

            /*
            if ($user->getId() and !Admin::isMaster()) {
                throw new Exception('Só o administrador pode editar um registro.');
            }
            */

            $type = UsersModel::getType(inputPost('type'), Admin::getLogged()->getType());

            if (!$user->getId()) {
                $user->setType($type->getId());
            }

            if (!$type or (!Admin::isMaster() and !UsersTypesModel::verificaPermissao(Admin::getLogged(), $user->voType()))) {
                throw new Exception('Você não tem permissão para gerenciar esse tipo de conta.');
            }

            if (inputPost('senha')) {
                $user->setSenha(inputPost('senha'));
            }

            /*
             * Setando valores
             */
            $user
                ->set(inputPost())
                ->setType($type->getId());

            /*
             * Verificando limite de contas do sistema
             */
            if (Admin::getLogged()->getType() != 1) {

                # Tipo de conta
                if (!$user->getId() and $type->getId() != 1) {
                    $limite = DadosModel::get()->getLimiteUsuarios();

                    # Limite do sistema
                    if ($limite > 0) {

                        # Total da cadastros realizados
                        $total = UsersModel::lista("WHERE a.status != 99 AND a.type != 1", null, true);

                        # Limite ultrapassado
                        if ($total >= $limite) {
                            throw new Exception("Limite de {$limite} contas já foi atingido. Entre em contato com o " . (Admin::getLogged()->getType() == 2 ? 'desenvolvedor' : 'administrador') . " para mais informações.");
                        }
                    }
                }
            }

            $user
                ->save()
                ->imgAddCapa('filefoto');

            HistoricoModel::add($novo ? "Criou o usuário #{$user->getId()}" : "Alterou os dados do usuário #{$user->getId()}", $user, Admin::getLogged());

            json('Registro salvo com sucesso!', 1);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Lista os usuários
     */
    function listAction()
    {

        $parans = inputPost();

        if (!Admin::isMaster())
            $parans['user'] = Admin::getIdLogged();

        $parans += ['page' => 1, 'forpage' => 20];

        $busca = UsersModel::busca($parans, $parans['page'], $parans['forpage']);

        if ($busca->getCount()) {

            $t = new Table(null, 'table table-bordered table-hover table-striped');

            $t->addTSection('thead');
            $t->addRow();
            $t->addCell('ID', ['width' => 70]);
            $t->addCell('DT/Cadastro', ['width' => 120]);
            $t->addCell('<i class="fa fa-image" ></i>', 'text-center', 'th', ['width' => 70]);
            $t->addCell('Nome/E-mail');
            $t->addCell('Gerente');
            $t->addCell('Créditos', ['width' => 150]);

            if (Admin::isMaster()) {
                $t->addCell('Ações', ['width' => '120']);
            }

            $t->addTSection('tbody');

            $totalReal = 0;

            /** @var UserVO $v */
            foreach ($busca->getRegistros() as $v) {

                $totalReal += $v->getCredito();

                if ($gerente = $v->voUser()) {
                    $gerente = <<<HTML
<b>{$gerente->getNome()}</b> ({$gerente->getLogin()})
<div>{$gerente->getEmail()}</div>
HTML;
                }

                $t->addRow();
                $t->addCell($v->getId(), 'text-center');
                $t->addCell(Date::formatData($v->getInsert()), 'text-center');
                $t->addCell('<img src="' . $v->imgCapa()->Redimensiona(40, 40) . '" class="img-responsive center-block" />');
                $t->addCell("<b>{$v->getNome()}</b> ({$v->getLogin()})<br />{$v->getEmail()}");
                $t->addCell($gerente);
                $t->addCell('R$ ' . $v->getCredito(true), 'text-center');

                //if (Admin::isMaster()) {

                    $acoes = '';

                    //if ($v->getId() != Admin::getIdLogged()) {
                        $acoes .= '<div class="btn btn-default" data-status="' . $v->getToken() . '" ><i class="fa fa-eye' . ($v->getStatus() == 0 ? '-slash' : null) . '" ></i></div>';
                    //}

                    $acoes .= '<div class="btn btn-default" data-editar="' . $v . '" ><i class="fa fa-edit" ></i></div>';

                    //if (Admin::isMaster()) {
                        $acoes .= "<div class='btn btn-warning' data-credito='{$v->getToken()}'><i class='fa fa-dollar'></i></div>";
                    //}

                    //if ($v->getId() != Admin::getIdLogged()) {
                        $acoes .= '<div class="btn btn-danger" data-excluir="' . $v->getToken() . '" ><i class="fa fa-remove" ></i></div>';
                    ///}

                    $t->addCell('<div class="btn-group" >'
                        . $acoes
                        . '</div>', 'text-center');
                //}
            }

            $t
                ->addTSection('tfoot')
                ->addRow()
                ->addCell('Total', 'text-right', null, ['colspan' => 5])
                ->addCell('R$ ' . Number::real($totalReal), 'text-center')
                ->addCell('', Admin::isMaster())
                ->addRow()
                ->addCell($busca->getPageDescription(), ['colspan' => 8]);

            echo (new Panel)
                ->setBody('<div class="table-responsive" >' . $t . '</div>')
                ->setFooter($busca, ['class' => 'text-right']);
        } else {
            echo '<div class="alert alert-warning no-margin" >'
                . '<i class="fa fa-warning" ></i> Nenhum usuário encontrado.'
                . '</div>';
        }
    }

    /** @return UsersModel */
    function getModel()
    {
        return UsersModel::Instance();
    }

}
    
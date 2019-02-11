<?php

namespace app\modules\admin\controllers\informacoes;

use app\core\Controller;
use app\core\Model;
use app\helpers\Seo;
use app\models\ApostasModel;
use app\models\DadosModel;
use app\models\EstadosModel;
use app\models\helpers\ImagensModel;
use app\models\UsersModel;
use app\modules\admin\Admin;
use app\models\CidadesModel;

class sistemaController extends Controller
{

    function indexAction()
    {
        Seo::addJs('https://maps.google.com/maps/api/js');
        Seo::addJs('cdn/js/gmaps.js');

        $config = DadosModel::get();
        $tUsers = UsersModel::getTable();
        $tCidades = CidadesModel::getTable();
        $tEstados = EstadosModel::getTable();

        $cambistas = Model::pdoRead()->FullRead("SELECT "
            . "a.id, a.latitude, a.longitude, a.nome, a.telefone, a.celular, a.email, "
            . "a.cep, a.logradouro, a.numero, a.bairro, a.complemento, cidade.title AS cidade, estado.uf "
            . "FROM `{$tUsers}` AS a "
            . "INNER JOIN `{$tCidades}` AS cidade ON cidade.id = a.cidade "
            . "INNER JOIN `{$tEstados}` AS estado ON estado.id = cidade.estado "
            . "WHERE "
            . "(:todos = 1 OR a.type = :type) AND "
            . "a.status = 1 ", [
            'todos' => (IS_LOCAL or Admin::isDeveloper()) ? 1 : 0,
            'type' => UsersModel::TYPE_ADMINISTRADOR,
        ])->getResult();

        foreach ($cambistas as &$v) {
            $v['foto'] = ImagensModel::capa(UsersModel::getTable(), $v['id'])->Redimensiona(60, 60);
        }

        $this->view('admin/informacoes/sistema', [
            'apostas' => ApostasModel::lista('WHERE a.status = 1', null, true),
            'usuarios' => UsersModel::lista('WHERE a.type > 1 AND a.status != 99', null, true),
            'limite' => $config->getLimiteUsuarios() ?: "Ilimitado",
        ]);
    }

}
    
<?php

namespace app\modules\cron\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\models\HistoricoModel;

class historicoController extends Controller
{

    function indexAction()
    {

        $tb = HistoricoModel::getTable();

        $termos = <<<SQL
DELETE a FROM `{$tb}` AS a WHERE a.insert < :data 
SQL;

        $places = [
            'data' => date('Y-m-d', strtotime('-60days'))
        ];

        Conn::getConn()->prepare($termos)->execute($places);

    }

}
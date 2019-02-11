<?php

namespace app\modules\cron\controllers;

use app\core\Controller;
use app\core\crud\Conn;

class indexController extends Controller
{

    function indexAction()
    {
        echo "Tarefas cron!";
    }

    function diarioAction()
    {
        mysqlController::instance()->backupAction();
        apostasController::instance()->baixaAction();
        contasController::instance()->indexAction();
        historicoController::instance()->indexAction();
    }

    function zeraApostasDiaAction()
    {

        $termos = <<<SQL
UPDATE `sis_users` AS a
SET a.qtdeapostasdia = 0
WHERE a.qtdeapostasdia > 0;
SQL;

        Conn::getConn()->prepare($termos);

        echo "Apostas zeradas";

    }

}
<?php

namespace app\modules\cron\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\models\ApostasModel;
use app\models\HistoricoBancarioModel;
use app\models\HistoricoModel;
use app\models\UsersModel;
use app\vo\ApostaVO;

class apostasController extends Controller
{

    function baixaAction()
    {

        ini_set('memory_limit', '500M');
        ini_set('max_execution_time', '3600');

        $hoje = date('Y-m-d');

        /** @var ApostaVO[] $listaApostas */
        $listaApostas = ApostasModel::lista('WHERE a.verificado = 1 AND a.status = 1 AND a.databaixa IS NULL AND a.ganhou = 1 GROUP BY a.id');

        $this->baixaApostas();

        foreach ($listaApostas as $aposta) {
            $user = $aposta->voUser();
            if ($aposta->getGanhou()){
                HistoricoBancarioModel::add($user, $aposta->getRetornoValido(), "<b>PRÊMIO</b> - Prêmio referente a Aposta (#{$aposta->getId()})", $aposta, "premio");
            }
        }

    }

    /**
     * Define a data das baixas de uma só vez
     */
    function baixaApostas()
    {

        $tb = ApostasModel::getTable();

        $termos = <<<SQL
UPDATE `{$tb}` AS a
SET a.databaixa = :hoje, a.update = :update, a.possivelganhador = 0, a.pago = 1
WHERE a.verificado = 1 AND a.status = 1 AND a.databaixa IS NULL;
SQL;

        $places = [
            'hoje' => date("Y-m-d"),
            'update' => __NOW__,
        ];

        $prepare = Conn::getConn()->prepare($termos);
        $prepare->execute($places);

        if ($prepare->rowCount())
            HistoricoModel::add("CRON: {$prepare->rowCount()} apostas receberam baixa");

    }

}
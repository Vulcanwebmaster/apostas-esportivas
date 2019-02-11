<?php

namespace app\modules\api\controllers;

use app\core\Controller;
use app\models\ApostasModel;
use app\models\HistoricoBancarioModel;
use app\modules\api\API;

class caixaController extends Controller
{

    function indexAction()
    {
        try {

            $user = API::getUser();

            $premios = $this->premios(false);
            $comissoes = $this->comissoes();

            return [
                'results' => [
                    ['color' => 'black', 'label' => 'Total em apostas', 'valor' => $this->vendas()],
                    ['color' => 'red', 'label' => 'Prêmios', 'valor' => $premios],
                    ['color' => 'red', 'label' => 'Prêmios em aberto', 'valor' => $this->premios(true)],
                    ['color' => 'whitesmoke', 'label' => 'Comissões', 'valor' => $comissoes],
                ],
                'total' => $premios + $comissoes,
                'result' => 1,
            ];

        } catch (\Exception $ex) {
            return $ex;
        }
    }

    function premios(bool $emAberto = false)
    {
        $places = $this->places();

        $query = clone ApostasModel::getBuildQuery();
        $query->setSelectFields(['SUM(a.retornovalido) AS total']);
        $termos = "a.user = :user AND (:cliente = 0 OR a.cliente = :cliente) AND a.data BETWEEN :dataInicial AND :dataFinal AND a.status = 1";

        if ($emAberto) {
            $termos .= " AND a.erros = 0 AND a.verificado = 0";
        } else {
            $termos .= " AND a.ganhou = 1";
        }

        $query->setWhere($termos);
        return (float)$query->execute($places)[0]['total'] ?? 0;
    }

    function places()
    {
        return [
            'user' => API::getUser()->getId(),
            'dataInicial' => inputPost('dataInicial') ?: date('Y-m-01'),
            'dataFinal' => inputPost('dataFinal') ?: date('Y-m-d'),
            'cliente' => (int)inputPost('cliente'),
        ];
    }

    function comissoes()
    {
        $places = $this->places();
        unset($places['cliente']);
        $query = clone HistoricoBancarioModel::getBuildQuery();
        $query->setSelectFields(['SUM(a.valor) AS total']);
        $query->setWhere("a.user = :user AND a.data BETWEEN :dataInicial AND :dataFinal AND a.reftype = 'comissao' AND a.status = 1");
        return (float)$query->execute($places)[0]['total'] ?? 0;
    }

    function vendas()
    {
        $places = $this->places();
        $query = clone ApostasModel::getBuildQuery();
        $query->setSelectFields(["SUM(a.valor) AS total"]);
        $query->setWhere("a.user = :user AND (:cliente = 0 OR a.cliente = :cliente) AND a.data BETWEEN :dataInicial AND :dataFinal AND a.status = 1");
        return (float)$query->execute($places)[0]['total'] ?? 0;
    }

}
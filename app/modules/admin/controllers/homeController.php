<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\core\Model;
use app\models\ApostaJogosModel;
use app\models\ApostasModel;
use app\models\DadosModel;
use app\models\JogosModel;
use app\models\TimesModel;
use app\models\UsersModel;

class homeController extends Controller
{

    function indexAction()
    {
        $config = DadosModel::get();

        if (date('Y-m-d') < $config->getPeriodoFinal()) {
            $diasRestantes = round(max(0, (strtotime($config->getPeriodoFinal()) - time()) / (24 * 60 * 60)));
            $diasRestantes = "({$diasRestantes} dias restantes)";
        } else {
            $diasRestantes = '';
        }

        $vars = [
            'apostasInfos' => $this->getApostasInfos(),
            'resumoCadastros' => UsersModel::getResumoCadastros(),
            'possiveisGanhadores' => $this->getPossiveisGanhadores(),
            'jogosMaisApostados' => $this->getJogosMaisApostados(),
            'resumoMes' => $this->getGrafico(),
        ];

        $this->view('admin/sys/principal', $vars);

    }

    function getGrafico()
    {

        $termos = <<<SQL
SELECT 
  a.data,
  SUM(a.valor) AS valor,
  SUM(IF(a.ganhou, a.retornovalido, 0)) AS premio
  
FROM 
  `sis_apostas` AS a
  
WHERE 
  a.status = 1 AND a.data BETWEEN :inicio AND :fim

GROUP BY
  a.data

ORDER BY
  a.data ASC
SQL;

        $places = [
            'inicio' => date('Y-m-01'),
            'fim' => date('Y-m-t'),
        ];

        $registros = Model::pdoRead()->FullRead($termos, $places)->getResult();

        $result = [
            'valor' => 0,
            'premio' => 0,
            'registros' => [],
        ];

        foreach ($registros as $v) {
            $result['valor'] += $v['valor'];
            $result['premio'] += $v['premio'];
            $result['registros'][] = $v;
        }

        $result['liquido'] = $result['valor'] - $result['premio'];

        return $result;

    }

    function getApostasInfos()
    {
        $table = ApostasModel::getTable();
        return Model::pdoRead()->FullRead("SELECT SUM(a.valor) AS valorApostas, COUNT(*) AS totalApostas, SUM(a.retornovalido) AS retorno "
            . "FROM `{$table}` AS a "
            . "WHERE a.data = :hoje AND a.status = 1 ", [
            'hoje' => date('Y-m-d'),
        ])->getResult()[0];
    }

    function getPossiveisGanhadores()
    {
        $table = ApostasModel::getTable();
        $tbUsers = UsersModel::getTable();

        $termos = <<<SQL
SELECT DISTINCT
    a.id, 
    user.nome AS apostador, 
    a.valor, 
    a.retorno 

FROM 
    `{$table}` AS a 
    
INNER JOIN 
    `{$tbUsers}` AS user ON user.id = a.user

WHERE 
    a.possivelganhador = 1 AND a.status = 1 

ORDER BY 
    a.update ASC 

LIMIT 5
SQL;


        return Model::pdoRead()->FullRead($termos)->getResult();
    }

    function getJogosMaisApostados()
    {
        $table = ApostaJogosModel::getTable();
        $tbJogos = JogosModel::getTable();
        $tbTimes = TimesModel::getTable();

        $termos = <<<SQL
SELECT a.jogo, COUNT(a.id) apostas, SUM(a.valor) AS valor, CONCAT(timecasa.title, ' x ', timefora.title) AS times 
FROM `{$table}` AS a 
INNER JOIN `{$tbJogos}` AS jogo ON jogo.id = a.jogo 
INNER JOIN `{$tbTimes}` AS timecasa ON timecasa.id = jogo.timecasa
INNER JOIN `{$tbTimes}` AS timefora ON timefora.id = jogo.timefora
WHERE jogo.status = 1 
GROUP BY a.jogo 
ORDER BY apostas DESC 
LIMIT 5
SQL;


        return Model::pdoRead()->FullRead($termos)->getResult();
    }

}
    
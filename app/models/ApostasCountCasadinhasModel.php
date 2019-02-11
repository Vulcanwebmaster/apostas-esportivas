<?php

namespace app\models;

use app\core\crud\Conn;
use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\ApostaCountCasadinhasVO;
use app\vo\ApostaVO;

class ApostasCountCasadinhasModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_apostas_count_casadinhas';
        $this->valueObject = ApostaCountCasadinhasVO::class;
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $Paranmetros
     * @param int $CurrentPage
     * @param int $PorPagina
     * @param string $OrderBy
     * @return Pagination
     */
    static function busca(array $Paranmetros = null, $CurrentPage = 1, $PorPagina = 10)
    {
        $Termos = 'WHERE a.status != 99 AND a.update > :intervalo ';
        $Places = ['intervalo' => date('Y-m-d 00:00:00', strtotime('-30days'))];

        $OrderBy = 'a.apostas DESC';

        if ($Paranmetros) {
            foreach ($Paranmetros as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $Termos .= " AND a.insert " . ($key == 'dataFinal' ? '<' : '>') . "= :{$key}";
                                $Places[$key] = $data . ' ' . ($key == 'dataFinal' ? '23:59:59' : '00:00:00');
                            }
                            break;
                        case 'jogo':
                            $Termos .= " AND a.jogos RLIKE CONCAT('(^|,)', :{$key}, '(,|$)')";
                            $Places[$key] = $value;
                            break;
                        case 'status':
                            $Termos .= " AND a.{$key} = :{$key}";
                            $Places[$key] = $value;
                            break;
                    }
                }
            }
        }

        return self::listaPagination("{$Termos} ORDER BY {$OrderBy}", $Places, $CurrentPage, $PorPagina);
    }

    /**
     * Incrementa casadinhas
     * @param ApostaVO $aposta
     */
    static function incCasadinha(ApostaVO $aposta)
    {
        # Tabela
        $table = self::getTable();

        # Array de Jogos
        $jogos = [];

        # Listando jogos
        foreach ($aposta->voJogos() as $i => $jogo) {
            $jogos[] = $jogo->getJogo();
        }

        if (count($jogos) > 1) {

            # Colocando em ordem crescente
            sort($jogos);

            # Montando Query
            $prepare = Conn::getConn()->prepare("UPDATE `{$table}` SET `apostas` = `apostas` + 1, `valor` = `valor` + :valor, `retorno` = `retorno` + :retorno WHERE `jogos` = :jogos LIMIT 1;");

            # Executando
            $prepare->execute([
                'jogos' => implode(',', $jogos),
                'valor' => $aposta->getValor(),
                'retorno' => $aposta->getRetornoValido(),
            ]);

            # Caso não tenha alterado nada
            if (!$prepare->rowCount()) {

                # Criando registro
                $casadinha = self::newValueObject();

                if ($casadinha instanceof ApostaCountCasadinhasVO) {
                    $casadinha->setJogos($jogos);
                    $casadinha->setApostas(1);
                    $casadinha->setValor($aposta->getValor());
                    $casadinha->setRetorno($aposta->getRetornoValido());
                    $casadinha->Save();
                }
            }
        }
    }

}
    
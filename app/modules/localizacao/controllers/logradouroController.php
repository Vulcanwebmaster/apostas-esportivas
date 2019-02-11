<?php

namespace app\modules\localizacao\controllers;

use app\core\Controller;
use app\helpers\Mask;
use app\helpers\STR;
use app\models\CidadesModel;
use app\models\EstadosModel;
use Exception;

class logradouroController extends Controller
{

    /**
     * Busca o Endereço a partir do CEP
     * @throws Exception
     */
    public function cepAction()
    {
        //header('Content-type: text/json; charset=UTF-8', true);
        try {

            $cep = Mask::cep(url_parans(0));

            if (!$cep) {
                throw new Exception('CEP inválido.');
            }

            $postCorreios = ['relaxation' => $cep, 'tipoCEP' => 'ALL'];
            $url = 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm';

            $cURL = curl_init($url);

            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_HEADER, false);
            curl_setopt($cURL, CURLOPT_POST, true);
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $postCorreios);

            $saida = curl_exec($cURL);

            curl_close($cURL);

            $saida = str_replace("\r\n", NULL, utf8_encode($saida));

            $campoTabela = "";

            preg_match_all('/<td.*?>(.*?)<\/td>/si', $saida, $campoTabela);

            if (empty($campoTabela[0][0])) {
                throw new Exception('CEP inválido.');
            }

            $rua = $bairro = $cidade = $estado = '';

            # CEP com logradouro completo
            if (!empty($campoTabela[0][3])) {
                $ex = explode('/', $campoTabela[0][2]);
                $rua = strip_tags($campoTabela[0][0]);
                $bairro = strip_tags($campoTabela[0][1]);
                $cidade = trim(strip_tags(preg_replace('/\(.*/', NULL, $ex[0])));
                $uf = $estado = strip_tags(preg_replace('/^([A-Z]{2}).*/', '$1', $ex[1]));
            } # CEP geral
            else {
                $cidade = strip_tags($campoTabela[0][0]);
                $uf = $estado = strip_tags($campoTabela[0][1]);
            }

            if ($e = EstadosModel::getByLabel('uf', $estado)) {

                # Estado
                $estado = [
                    'id' => $e->getId(),
                    'estado' => $e->getTitle(),
                    'uf' => $e->getUF(),
                ];

                # Cidade
                if ($c = current(CidadesModel::lista("WHERE a.title = :cidade AND a.estado = :estado LIMIT 1", ['estado' => $e->getId(), 'cidade' => trim(STR::acentosUtf8($cidade))]))) {
                    $cidade = [
                        'id' => $c->getId(),
                        'cidade' => $c->getTitle(),
                        'estado' => $c->getEstadoTitle(),
                        'uf' => $c->getUF(),
                    ];
                }
            }

            echo json_encode([
                'logradouro' => trim(STR::acentosUtf8($rua)),
                'bairro' => trim(STR::acentosUtf8($bairro)),
                'cidade' => $cidade,
                'estado' => $estado,
                'uf' => $uf,
                'cep' => Mask::cep($cep),
                'result' => 1,
            ]);
        } catch (Exception $ex) {
            echo json_encode([
                'message' => $ex->getMessage(),
                'result' => 0,
            ]);
        }
    }

}
    
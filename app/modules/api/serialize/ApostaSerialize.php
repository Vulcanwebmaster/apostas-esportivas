<?php

namespace app\modules\api\serialize;

use app\models\ApostasModel;
use app\vo\ApostaVO;

class ApostaSerialize implements \JsonSerializable
{

    /**
     * @var ApostaVO
     */
    private $aposta;

    public function __construct(ApostaVO $aposta)
    {
        $this->aposta = $aposta;
    }

    function jsonSerialize()
    {
        $v = $this->aposta;

        $aceitaApostar = $v->getStatus() == ApostasModel::STATUS_AGUARDANDO_PAGAMENTO;

        if ($aceitaApostar) {
            foreach ($v->voJogos() as $jogo) {
                if ($jogo->voJogo()->jaComecou()) {
                    $aceitaApostar = false;
                    $v->setStatus(ApostasModel::STATUS_NPAGA)->save();
                    break;
                }
            }
        }

        return [
            'id' => $v->getId(),
            'token' => $v->getToken(),
            'data' => date('d/m/Y \à\s H\hi', strtotime($v->getInsert())),
            'codigo' => trim(preg_replace('/(.{3})/', '$1 ', $v->getCodigoBilhete())),
            'url' => url('apostas/imprimir', [$v->getToken()], 0),
            'valor' => $v->getValor(true),
            'retorno' => $v->getRetorno(true),
            'cotacao' => $v->getCotacao(true),
            'cliente' => $v->getApostadorNome(),
            'jogos' => $v->getJogos(),
            'podeValidar' => $aceitaApostar,
            'validou' => $v->getVerificado() ? true : false,
            'ganhou' => $v->getGanhou() ? true : false,
            'status' => $v->getStatus(),
            'statusTitle' => $v->getStatusTitle(),
            'statusClass' => $v->getStatusClass(),
        ];
    }

}
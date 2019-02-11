<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\JogosModel;

class ApostaCountCasadinhasVO extends ValueObject
{

    private $jogos;
    private $apostas;
    private $valor;
    private $retorno;

    /**
     * Lista de jogos
     * @return JogoVO[]
     */
    function voJogos()
    {
        return JogosModel::lista("WHERE a.id IN(" . implode(', ', $this->getJogos(true)) . ");", null, false, true, true);
    }

    function getJogos($toArray = false)
    {
        if ($toArray) {
            return explode(',', $this->jogos);
        } else {
            return $this->jogos;
        }
    }

    function setJogos($jogos)
    {
        if (is_array($jogos)) {
            # Organizando
            sort($jogos);

            # Separando por virgula
            $jogos = implode(',', $jogos);
        }
        $this->jogos = $jogos;
    }

    function getApostas()
    {
        return (int)$this->apostas;
    }

    public function setApostas($apostas)
    {
        $this->apostas = $apostas;
        return $this;
    }

    public function getValor($toReal = false)
    {
        return $this->formatValue($this->valor, 'real', $toReal);
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function getRetorno()
    {
        return $this->retorno;
    }

    public function setRetorno($retorno)
    {
        $this->retorno = $retorno;
        return $this;
    }

}
    
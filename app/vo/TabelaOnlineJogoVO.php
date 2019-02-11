<?php

namespace app\vo;

use app\core\ValueObject;

class TabelaOnlineJogoVO extends ValueObject
{

    private $type;
    private $ref;
    private $campeonato;
    private $timeCasa;
    private $timeFora;
    private $link;
    private $data;
    private $hora;
    private $casa;
    private $empate;
    private $fora;
    private $gmCasa;
    private $gmFora;
    private $amb;
    private $nAmb;
    private $dplCasa;
    private $dplFora;
    private $cm;
    private $fm;
    private $pCerto;
    private $placarZerado;
    private $umFaz;
    private $mais2gm;
    private $menos2gm;
    private $penalty;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getRef()
    {
        return $this->ref;
    }

    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    public function getCampeonato()
    {
        return $this->campeonato;
    }

    public function setCampeonato($campeonato)
    {
        $this->campeonato = $campeonato;
        return $this;
    }

    public function getTimeCasa()
    {
        return $this->timeCasa;
    }

    public function setTimeCasa($timeCasa)
    {
        $this->timeCasa = $timeCasa;
        return $this;
    }

    public function getTimeFora()
    {
        return $this->timeFora;
    }

    public function setTimeFora($timeFora)
    {
        $this->timeFora = $timeFora;
        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    public function getData($formatar = false)
    {
        return $this->formatValue($this->data, 'data', $formatar);
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }

    public function getCasa($toReal = false)
    {
        return $this->formatValue($this->casa, 'real', $toReal);
    }

    public function setCasa($casa)
    {
        $this->casa = $casa;
        return $this;
    }

    public function getEmpate($toReal = false)
    {
        return $this->formatValue($this->empate, 'real', $toReal);
    }

    public function setEmpate($empate)
    {
        $this->empate = $empate;
        return $this;
    }

    public function getFora($toReal = false)
    {
        return $this->formatValue($this->fora, 'real', $toReal);
    }

    public function setFora($fora)
    {
        $this->fora = $fora;
        return $this;
    }

    public function getGmCasa($toReal = false)
    {
        return $this->formatValue($this->gmCasa, 'real', $toReal);
    }

    public function setGmCasa($gmCasa)
    {
        $this->gmCasa = $gmCasa;
        return $this;
    }

    public function getGmFora($toReal = false)
    {
        return $this->formatValue($this->gmFora, 'real', $toReal);
    }

    public function setGmFora($gmFora)
    {
        $this->gmFora = $gmFora;
        return $this;
    }

    public function getAmb($toReal = false)
    {
        return $this->formatValue($this->amb, 'real', $toReal);
    }

    public function setAmb($amb)
    {
        $this->amb = $amb;
        return $this;
    }

    public function getNAmb($toReal = false)
    {
        return $this->formatValue($this->nAmb, 'real', $toReal);
    }

    public function setNAmb($nAmb)
    {
        $this->nAmb = $nAmb;
        return $this;
    }

    public function getDplCasa($toReal = false)
    {
        return $this->formatValue($this->dplCasa, 'real', $toReal);
    }

    public function setDplCasa($dplCasa)
    {
        $this->dplCasa = $dplCasa;
        return $this;
    }

    public function getDplFora($toReal = false)
    {
        return $this->formatValue($this->dplFora, 'real', $toReal);
    }

    public function setDplFora($dplFora)
    {
        $this->dplFora = $dplFora;
        return $this;
    }

    public function getCm($toReal = false)
    {
        return $this->formatValue($this->cm, 'real', $toReal);
    }

    public function setCm($cm)
    {
        $this->cm = $cm;
        return $this;
    }

    public function getFm($toReal = false)
    {
        return $this->formatValue($this->fm, 'real', $toReal);
    }

    public function setFm($fm)
    {
        $this->fm = $fm;
        return $this;
    }

    public function getPCerto($toReal = false)
    {
        return $this->formatValue($this->pCerto, 'real', $toReal);
    }

    public function setPCerto($pCerto)
    {
        $this->pCerto = $pCerto;
        return $this;
    }

    public function getPlacarZerado($toReal = false)
    {
        return $this->formatValue($this->placarZerado, 'real', $toReal);
    }

    public function setPlacarZerado($placarZerado)
    {
        $this->placarZerado = $placarZerado;
        return $this;
    }

    public function getUmFaz($toReal = false)
    {
        return $this->formatValue($this->umFaz, 'real', $toReal);
    }

    public function setUmFaz($umFaz)
    {
        $this->umFaz = $umFaz;
        return $this;
    }

    public function getMais2gm($toReal = false)
    {
        return $this->formatValue($this->mais2gm, 'real', $toReal);
    }

    public function setMais2gm($mais2gm)
    {
        $this->mais2gm = $mais2gm;
        return $this;
    }

    public function getMenos2gm($toReal = false)
    {
        return $this->formatValue($this->menos2gm, 'real', $toReal);
    }

    public function setMenos2gm($menos2gm)
    {
        $this->menos2gm = $menos2gm;
        return $this;
    }

    public function getPenalty($toReal = false)
    {
        return $this->formatValue($this->penalty, 'real', $toReal);
    }

    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
        return $this;
    }

}
    
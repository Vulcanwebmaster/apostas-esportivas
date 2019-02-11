<?php

namespace app\vo;

use app\core\ValueObject;
use app\helpers\Date;
use app\models\CampeonatosModel;
use app\models\TimesModel;
use app\traits\vo\token;

class JogoVO extends ValueObject
{

    use token;

    private $type;
    private $typeRef;
    private $campeonato;
    private $data;
    private $hora;
    private $timeCasa;
    private $timeCasaPlacarPrimeiro;
    private $timeCasaPlacarSegundo;
    private $timeFora;
    private $timeForaPlacarPrimeiro;
    private $timeForaPlacarSegundo;
    private $limite1;
    private $limite2;
    private $limite3;
    private $apostas;
    private $maxApostas;
    private $valorApostas;
    private $cotacoes;
    private $refImport;
    private $dataBaixa;

    public function check()
    {
    }

    /**
     * @return mixed
     */
    public function getMaxApostas()
    {
        return $this->maxApostas;
    }

    /**
     * @param mixed $maxApostas
     * @return $this
     */
    public function setMaxApostas($maxApostas)
    {
        $this->maxApostas = $maxApostas;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefImport()
    {
        return $this->refImport;
    }

    /**
     * @param mixed $refImport
     * @return $this
     */
    public function setRefImport($refImport)
    {
        $this->refImport = $refImport;
        return $this;
    }

    /**
     * @param bool $formatar
     * @return string
     */
    public function getDataCadastro($formatar = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $formatar);
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return "{$this->getTimeCasaTitle()} x {$this->getTimeForaTitle()}";
    }

    public function getTimeCasaTitle()
    {
        return $this->voTimeCasa() ? $this->voTimeCasa()->getTitle() : null;
    }

    /**
     * @return TimeVO
     */
    public function voTimeCasa()
    {
        return TimesModel::getByLabel('id', $this->getTimeCasa());
    }

    /**
     * @return mixed
     */
    public function getTimeCasa()
    {
        return (int)$this->timeCasa;
    }

    /**
     * @param $timeCasa
     * @return $this
     */
    public function setTimeCasa($timeCasa)
    {
        $this->timeCasa = $timeCasa;
        return $this;
    }

    public function getTimeForaTitle()
    {
        return $this->voTimeFora() ? $this->voTimeFora()->getTitle() : null;
    }

    /**
     * @return TimeVO
     */
    public function voTimeFora()
    {
        return TimesModel::getByLabel('id', $this->getTimeFora());
    }

    /**
     * @return mixed
     */
    public function getTimeFora()
    {
        return (int)$this->timeFora;
    }

    /**
     * @param $timeFora
     * @return $this
     */
    public function setTimeFora($timeFora)
    {
        $this->timeFora = $timeFora;
        return $this;
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getDataBaixa($formatar = false)
    {
        return $this->formatValue($this->dataBaixa, 'datetime', $formatar);
    }

    /**
     * @param mixed $dataBaixa
     * @return $this
     */
    public function setDataBaixa($dataBaixa)
    {
        $this->dataBaixa = $dataBaixa;
        return $this;
    }

    /**
     * Verifica se a partida já se iniciou
     * @return bool
     */
    public function jaComecou()
    {

        $data = new \DateTime();
        $dataJogo = new \DateTime("{$this->getData()} {$this->getHora()}:00");

        return $data > $dataJogo;
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->data, 'date', $formatar);
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getHora()
    {
        return substr(Date::time($this->hora), 0, 5);
    }

    /**
     * @param $hora
     * @return $this
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }

    public function getDiaSemana()
    {
        if ($data = $this->getData()) {
            $w = date("w", strtotime($data));
            return ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'][$w];
        }
    }

    /**
     * Saldo total de gols
     * @return int
     */
    public function getTotalGols()
    {
        return $this->getTimeCasaPlacar() + $this->getTimeForaPlacar();
    }

    /**
     * @return int
     */
    public function getTimeCasaPlacar()
    {
        return $this->getTimeCasaPlacarPrimeiro() + $this->getTimeCasaPlacarSegundo();
    }

    /**
     * @return mixed
     */
    public function getTimeCasaPlacarPrimeiro()
    {
        return (int)$this->timeCasaPlacarPrimeiro;
    }

    /**
     * @param mixed $timeCasaPlacarPrimeiro
     * @return $this
     */
    public function setTimeCasaPlacarPrimeiro($timeCasaPlacarPrimeiro)
    {
        $this->timeCasaPlacarPrimeiro = $timeCasaPlacarPrimeiro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeCasaPlacarSegundo()
    {
        return (int)$this->timeCasaPlacarSegundo;
    }

    /**
     * @param mixed $timeCasaPlacarSegundo
     * @return $this
     */
    public function setTimeCasaPlacarSegundo($timeCasaPlacarSegundo)
    {
        $this->timeCasaPlacarSegundo = $timeCasaPlacarSegundo;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeForaPlacar()
    {
        return $this->getTimeForaPlacarPrimeiro() + $this->getTimeForaPlacarSegundo();
    }

    /**
     * @return mixed
     */
    public function getTimeForaPlacarPrimeiro()
    {
        return (int)$this->timeForaPlacarPrimeiro;
    }

    /**
     * @param mixed $timeForaPlacarPrimeiro
     * @return $this
     */
    public function setTimeForaPlacarPrimeiro($timeForaPlacarPrimeiro)
    {
        $this->timeForaPlacarPrimeiro = $timeForaPlacarPrimeiro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeForaPlacarSegundo()
    {
        return (int)$this->timeForaPlacarSegundo;
    }

    /**
     * @param mixed $timeForaPlacarSegundo
     * @return $this
     */
    public function setTimeForaPlacarSegundo($timeForaPlacarSegundo)
    {
        $this->timeForaPlacarSegundo = $timeForaPlacarSegundo;
        return $this;
    }

    /**
     * Saldo total de gols
     * @return int
     */
    public function getTotalGolsPrimeiro()
    {
        return $this->getTimeCasaPlacarPrimeiro() + $this->getTimeForaPlacarPrimeiro();
    }

    /**
     * Saldo total de gols
     * @return int
     */
    public function getTotalGolsSegundo()
    {
        return $this->getTimeCasaPlacarSegundo() + $this->getTimeForaPlacarSegundo();
    }

    /**
     * @return mixed
     */
    public function getCotacoes($toJson = false)
    {
        return $toJson ? (json_decode($this->cotacoes, true) ?: []) : $this->cotacoes;
    }

    /**
     * @param mixed $cotacoes
     * @return $this
     */
    public function setCotacoes($cotacoes)
    {
        $this->cotacoes = is_array($cotacoes) ? json_encode($cotacoes) : $cotacoes;
        return $this;
    }

    /**
     * Retorna o ganhador do jogo
     * @return string casa|fora|empate
     */
    public function getGanhador()
    {
        if ($this->getTimeCasaPlacar() > $this->getTimeForaPlacar()) {
            return 'casa';
        } else if ($this->getTimeCasaPlacar() < $this->getTimeForaPlacar()) {
            return 'fora';
        } else {
            return 'empate';
        }
    }

    /**
     * Retorna o ganhador do primeiro tempo
     * @return string casa|fora|empate
     */
    public function getGanhadorPrimeiro()
    {
        if ($this->getTimeCasaPlacarPrimeiro() > $this->getTimeForaPlacarPrimeiro()) {
            return 'casa';
        } else if ($this->getTimeCasaPlacarPrimeiro() < $this->getTimeForaPlacarPrimeiro()) {
            return 'fora';
        } else {
            return 'empate';
        }
    }

    /**
     * Retorna o ganhador do segundo tempo
     * @return string casa|fora|empate
     */
    public function getGanhadorSegundo()
    {
        if ($this->getTimeCasaPlacarSegundo() > $this->getTimeForaPlacarSegundo()) {
            return 'casa';
        } else if ($this->getTimeCasaPlacarSegundo() < $this->getTimeForaPlacarSegundo()) {
            return 'fora';
        } else {
            return 'empate';
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeRef()
    {
        return $this->typeRef;
    }

    /**
     * @param $typeRef
     * @return $this
     */
    public function setTypeRef($typeRef)
    {
        $this->typeRef = $typeRef;
        return $this;
    }

    public function getCampeonatoTitle()
    {
        return $this->voCampeonato() ? $this->voCampeonato()->getTitle() : null;
    }

    /**
     * @return CampeonatoVO
     */
    public function voCampeonato()
    {
        return CampeonatosModel::getByLabel('id', $this->getCampeonato());
    }

    /**
     * @return mixed
     */
    public function getCampeonato()
    {
        return (int)$this->campeonato;
    }

    /**
     * @param $campeonato
     * @return $this
     */
    public function setCampeonato($campeonato)
    {
        $this->campeonato = $campeonato;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimite1($formatar = false)
    {
        return $this->formatValue($this->limite1, 'real', $formatar);
    }

    /**
     * @param $limite1
     * @return $this
     */
    public function setLimite1($limite1)
    {
        $this->limite1 = $limite1;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimite2($formatar = false)
    {
        return $this->formatValue($this->limite2, 'real', $formatar);
    }

    /**
     * @param $limite2
     * @return $this
     */
    public function setLimite2($limite2)
    {
        $this->limite2 = $limite2;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimite3($formatar = false)
    {
        return $this->formatValue($this->limite3, 'real', $formatar);
    }

    /**
     * @param $limite3
     * @return $this
     */
    public function setLimite3($limite3)
    {
        $this->limite3 = $limite3;
        return $this;
    }

    /**
     * @return int
     */
    function getApostas()
    {
        return (int)$this->apostas;
    }

    /**
     * @param $apostas
     * @return $this
     */
    public function setApostas($apostas)
    {
        $this->apostas = $apostas;
        return $this;
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    function getValorApostas($toReal = false)
    {
        return $this->formatValue($this->valorApostas, 'real', $toReal);
    }

    /**
     * @param $valorApostas
     * @return $this
     */
    public function setValorApostas($valorApostas)
    {
        $this->valorApostas = $valorApostas;
        return $this;
    }

}
    
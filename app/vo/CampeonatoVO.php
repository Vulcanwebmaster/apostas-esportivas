<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\helpers\OptionsModel;
use app\vo\helpers\OptionVO;

class CampeonatoVO extends ValueObject
{

    private $pais;
    private $title;
    private $times;

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     * @return $this
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaisTitle()
    {
        if ($pais = $this->voPais()){
            return $pais->getTitle();
        }else{
            return 'Não definido';
        }
    }

    /**
     * @return OptionVO
     */
    public function voPais()
    {
        return OptionsModel::getByLabel('id', $this->getPais());
    }

    /**
     * @return mixed
     */
    public function getTimes($toArray = false)
    {
        return $this->formatValue($this->times, 'array', $toArray);
    }

    /**
     * @param mixed $times
     * @return $this
     */
    public function setTimes($times)
    {
        $this->times = $times;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return trim($this->title);
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


}
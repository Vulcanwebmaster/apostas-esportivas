<?php

namespace app\vo;

use app\core\ValueObject;
use app\traits\vo\user;
use app\traits\vo\voRef;

class HistoricoVO extends ValueObject
{

    use user;
    use voRef;

    private $descricao;
    private $ip;

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param $descricao
     * @return $this
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferencia()
    {
        if ($this->getRef())
            return "table-{$this->getRef()}-id-{$this->getRefId()}";
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

}
    
<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\CotacoesModel;
use Exception;

class CotacaoVO extends ValueObject
{

    private $titulo;
    private $principal = 0;
    private $grupo = 1;
    private $sigla;
    private $campo;
    private $ordem;
    private $cor;
    private $descricao;

    /**
     * @return string
     */
    public function getGrupoTitle()
    {
        return CotacoesModel::GRUPOS[$this->getGrupo()] ?? 'Inválido';
    }

    /**
     * @return mixed
     */
    public function getGrupo()
    {
        return (int)$this->grupo;
    }

    /**
     * @param mixed $grupo
     * @return $this
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * @param int $principal
     * @return $this
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrdem()
    {
        return (int)$this->ordem;
    }

    /**
     * @param $ordem
     * @return $this
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * @param $cor
     * @return $this
     */
    public function setCor($cor)
    {
        $this->cor = $cor;
        return $this;
    }

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
     * @throws Exception
     */
    public function check()
    {
        if (!$this->getTitulo()) {
            throw new Exception('Informe o título da cotação');
        } else if (!$this->getSigla()) {
            throw new Exception('Informe a sigla da cotação');
        } else if (!$this->getCampo()) {
            throw new Exception('Informe o nome do campo');
        } else if (!$this->getQuery()) {
            throw new Exception('Informe a query da cotação');
        }

        $termos = 'WHERE a.campo = :campo AND a.id != :id AND a.status != 99 LIMIT 1';
        $places = ['campo' => $this->getCampo(), 'id' => $this->getId()];
        if ($this->voModel()->lista($termos, $places, true)) {
            throw new Exception('Campo já está sendo utilizado em outra cotação');
        }
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param $titulo
     * @return $this
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param $sigla
     * @return $this
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * @return null
     */
    public function getCampo()
    {
        return ($this->campo and preg_match("/^[a-z][a-z0-9]{0,}$/", $this->campo)) ? $this->campo : null;
    }

    /**
     * @param $campo
     * @return $this
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

}
    
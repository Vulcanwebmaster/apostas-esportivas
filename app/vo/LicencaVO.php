<?php

namespace app\vo;

use app\core\ValueObject;

class LicencaVO extends ValueObject
{

    private $ordem;
    private $title;
    private $descricao;
    private $texto;
    private $valorPlano;
    private $valorAdesao;
    private $recargaMensal;
    private $comissaoIndicacao;
    private $comissaoJogos1;
    private $comissaoJogos2;
    private $comissaoJogos3;
    private $comissaoJogos4;
    private $comissaoJogos5;
    private $comissaoApuracao1;
    private $comissaoApuracao2;
    private $comissaoApuracao3;
    private $comissaoApuracao4;
    private $comissaoApuracao5;

    /**
     * @return mixed
     */
    public function getOrdem()
    {
        return (int) $this->ordem;
    }

    /**
     * @param mixed $ordem
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
    public function getTitle()
    {
        return $this->title;
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

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     * @return $this
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     * @return $this
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorPlano($format = false)
    {
        return $this->formatValue($this->valorPlano, 'real', $format);
    }

    /**
     * @param mixed $valorPlano
     * @return $this
     */
    public function setValorPlano($valorPlano)
    {
        $this->valorPlano = $valorPlano;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorAdesao($format = false)
    {
        return $this->formatValue($this->valorAdesao, 'real', $format);
    }

    /**
     * @param mixed $valorAdesao
     * @return $this
     */
    public function setValorAdesao($valorAdesao)
    {
        $this->valorAdesao = $valorAdesao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecargaMensal($format = false)
    {
        return $this->formatValue($this->recargaMensal, 'real', $format);
    }

    /**
     * @param mixed $recargaMensal
     * @return $this
     */
    public function setRecargaMensal($recargaMensal)
    {
        $this->recargaMensal = $recargaMensal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoIndicacao($format = false)
    {
        return $this->formatValue($this->comissaoIndicacao, 'real', $format);
    }

    /**
     * @param mixed $comissaoIndicacao
     * @return $this
     */
    public function setComissaoIndicacao($comissaoIndicacao)
    {
        $this->comissaoIndicacao = $comissaoIndicacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogos1($format = false)
    {
        return $this->formatValue($this->comissaoJogos1, 'real', $format);
    }

    /**
     * @param mixed $comissaoJogos1
     * @return $this
     */
    public function setComissaoJogos1($comissaoJogos1)
    {
        $this->comissaoJogos1 = $comissaoJogos1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogos2($format = false)
    {
        return $this->formatValue($this->comissaoJogos2, 'real', $format);
    }

    /**
     * @param mixed $comissaoJogos2
     * @return $this
     */
    public function setComissaoJogos2($comissaoJogos2)
    {
        $this->comissaoJogos2 = $comissaoJogos2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogos3($format = false)
    {
        return $this->formatValue($this->comissaoJogos3, 'real', $format);
    }

    /**
     * @param mixed $comissaoJogos3
     * @return $this
     */
    public function setComissaoJogos3($comissaoJogos3)
    {
        $this->comissaoJogos3 = $comissaoJogos3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogos4($format = false)
    {
        return $this->formatValue($this->comissaoJogos4, 'real', $format);
    }

    /**
     * @param mixed $comissaoJogos4
     * @return $this
     */
    public function setComissaoJogos4($comissaoJogos4)
    {
        $this->comissaoJogos4 = $comissaoJogos4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogos5($format = false)
    {
        return $this->formatValue($this->comissaoJogos5, 'real', $format);
    }

    /**
     * @param mixed $comissaoJogos5
     * @return $this
     */
    public function setComissaoJogos5($comissaoJogos5)
    {
        $this->comissaoJogos5 = $comissaoJogos5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoApuracao1($format = false)
    {
        return $this->formatValue($this->comissaoApuracao1, 'real', $format);
    }

    /**
     * @param mixed $comissaoApuracao1
     * @return $this
     */
    public function setComissaoApuracao1($comissaoApuracao1)
    {
        $this->comissaoApuracao1 = $comissaoApuracao1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoApuracao2($format = false)
    {
        return $this->formatValue($this->comissaoApuracao2, 'real', $format);
    }

    /**
     * @param mixed $comissaoApuracao2
     * @return $this
     */
    public function setComissaoApuracao2($comissaoApuracao2)
    {
        $this->comissaoApuracao2 = $comissaoApuracao2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoApuracao3($format = false)
    {
        return $this->formatValue($this->comissaoApuracao3, 'real', $format);
    }

    /**
     * @param mixed $comissaoApuracao3
     * @return $this
     */
    public function setComissaoApuracao3($comissaoApuracao3)
    {
        $this->comissaoApuracao3 = $comissaoApuracao3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoApuracao4($format = false)
    {
        return $this->formatValue($this->comissaoApuracao4, 'real', $format);
    }

    /**
     * @param mixed $comissaoApuracao4
     * @return $this
     */
    public function setComissaoApuracao4($comissaoApuracao4)
    {
        $this->comissaoApuracao4 = $comissaoApuracao4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoApuracao5($format = false)
    {
        return $this->formatValue($this->comissaoApuracao5, 'real', $format);
    }

    /**
     * @param mixed $comissaoApuracao5
     * @return $this
     */
    public function setComissaoApuracao5($comissaoApuracao5)
    {
        $this->comissaoApuracao5 = $comissaoApuracao5;
        return $this;
    }

}
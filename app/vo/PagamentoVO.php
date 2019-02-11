<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 09/06/2017
 * Time: 10:02
 */

namespace app\vo;


use app\core\ValueObject;
use app\models\PagamentosModel;
use app\traits\vo\user;

class PagamentoVO extends ValueObject
{

    use user;

    private $type = PagamentosModel::TYPE_CREDITO;
    private $dataVencimento;
    private $dataStatus;
    private $link;
    private $codigoBarras;
    private $dados;
    private $descricao;
    private $valor;

    /**
     * @return mixed
     */
    public function getDados()
    {
        return $this->dados;
    }

    /**
     * @param mixed $dados
     * @return $this
     */
    public function setDados($dados)
    {
        $this->dados = $dados;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataVencimento($formatar = false)
    {
        return $this->formatValue($this->dataVencimento, 'data', $formatar);
    }

    /**
     * @param mixed $dataVencimento
     * @return $this
     */
    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataStatus($formatar = false)
    {
        return $this->formatValue($this->dataStatus, 'data', $formatar);
    }

    /**
     * @param mixed $dataStatus
     * @return $this
     */
    public function setDataStatus($dataStatus)
    {
        $this->dataStatus = $dataStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * @param mixed $codigoBarras
     * @return $this
     */
    public function setCodigoBarras($codigoBarras)
    {
        $this->codigoBarras = $codigoBarras;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
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
    public function getValor($formatar = false)
    {
        return $this->formatValue($this->valor, 'real', $formatar);
    }

    /**
     * @param mixed $valor
     * @return $this
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

}
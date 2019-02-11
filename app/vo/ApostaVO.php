<?php

namespace app\vo;

use app\core\ValueObject;
use app\models\ApostaJogosModel;
use app\models\ApostasModel;
use app\models\DadosModel;
use app\traits\cliente;
use app\traits\vo\token;
use app\traits\vo\user;
use Exception;

class ApostaVO extends ValueObject
{

    use token;
    use user;
    use cliente;

    private $codigoBilhete;
    private $data;
    private $cotacao;
    private $cotacaoMaxima;
    private $valor;
    private $casadinha;
    private $jogos;
    private $verificado;
    private $retornoMaximo;
    private $ganhou;
    private $dataBaixa;
    private $apostadorNome;
    private $apostadorTelefone;

    public function getStatusClass()
    {
        switch ($this->getStatus()) {
            case ApostasModel::STATUS_ATIVA:
                if ($this->get('ganhou') and $this->getVerificado()) {
                    return 'info';
                } else if ($this->get('erros') > 0) {
                    return 'danger';
                } else {
                    return 'default';
                }
                break;
            case ApostasModel::STATUS_AGUARDANDO_PAGAMENTO:
                return 'default';
                break;
            case ApostasModel::STATUS_EXCLUIDA:
            case ApostasModel::STATUS_CANCELADA:
            case ApostasModel::STATUS_NPAGA:
                return 'warning';
                break;
        }
    }

    /**
     * @return int
     */
    public function getVerificado()
    {
        return $this->verificado ? 1 : 0;
    }

    /**
     * @param $verificado
     * @return $this
     */
    public function setVerificado($verificado)
    {
        $this->verificado = $verificado;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        switch ($this->getStatus()) {
            case ApostasModel::STATUS_ATIVA:
                if ($this->get('ganhou') and $this->getVerificado()) {
                    return 'Ganhou';
                } else if ((int)$this->get('erros') > 0) {
                    return 'Perdeu';
                } else {
                    return 'Aguardando jogos';
                }
                break;
            case ApostasModel::STATUS_AGUARDANDO_PAGAMENTO:
                return 'Aguardando pagamento';
                break;
            case ApostasModel::STATUS_EXCLUIDA:
                return "Excluída";
                break;
            case ApostasModel::STATUS_CANCELADA:
                return 'Cancelada';
                break;
            case ApostasModel::STATUS_NPAGA:
                return 'Não paga';
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getCodigoBilhete()
    {
        if (!$this->codigoBilhete) {
            $this->codigoBilhete = ApostasModel::gerarCodigo();
            if ($this->getId())
                $this->save();
        }
        return $this->codigoBilhete;
    }

    /**
     * @param mixed $codigoBilhete
     * @return $this
     */
    public function setCodigoBilhete($codigoBilhete)
    {
        $this->codigoBilhete = $codigoBilhete;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApostadorNome()
    {
        return $this->apostadorNome;
    }

    /**
     * @param mixed $apostadorNome
     * @return $this
     */
    public function setApostadorNome($apostadorNome)
    {
        $this->apostadorNome = $apostadorNome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApostadorTelefone()
    {
        return $this->apostadorTelefone ?: $this->getUserTelefone();
    }

    /**
     * @param mixed $apostadorTelefone
     * @return $this
     */
    public function setApostadorTelefone($apostadorTelefone)
    {
        $this->apostadorTelefone = $apostadorTelefone;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEditavel()
    {
        if (!$this->get('jogosverificados') and $this->getStatus() == 1) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getPago()
    {
        return ($this->get('ganhou') and $this->getDataBaixa());
    }

    /**
     * @return mixed
     */
    public function getDataBaixa($formatar = false)
    {
        return $this->formatValue($this->dataBaixa, 'data', $formatar);
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
     * @return int
     */
    public function getGanhou()
    {
        return $this->ganhou ? 1 : 0;
    }

    /**
     * @param $ganhou
     * @return $this
     */
    public function setGanhou($ganhou)
    {
        $this->ganhou = $ganhou;
        return $this;
    }

    /**
     * Link de impressão da aposta
     * @return string
     */
    public function getPrintLink()
    {
        return url('apostas/aposta/imprimir', [$this->getToken()], 'admin') . '/aposta' . $this->getId() . '.pdf';
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getData($formatar = false)
    {
        return $this->formatValue($this->data, 'data', $formatar);
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

    public function getHora()
    {
        return date('H:i', strtotime($this->getInsert()));
    }

    /** @return ApostaJogoVO[] */
    public function voJogos(bool $comCancelados = false)
    {
        $status = $comCancelados ? "IN(1, 99, 0)" : "= 1";
        $termos = "WHERE a.aposta = :aposta AND a.status {$status} ORDER BY a.id ASC";
        return ApostaJogosModel::lista($termos, [
            'aposta' => $this->getId(),
        ], false, true);
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getRetornoValido($toReal = false)
    {
        $possivelRetorno = $this->getCotacaoValida() * $this->getValor();
        $retorno = min($possivelRetorno, $this->getRetornoMaximo());
        return $this->formatValue($retorno, 'real', $toReal);
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getCotacaoValida($toReal = false)
    {
        return $this->formatValue(min($this->getCotacao(), $this->getCotacaoMaxima()), 'real', $toReal);
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getCotacao($toReal = false)
    {
        return $this->formatValue($this->cotacao, 'real', $toReal);
    }

    /**
     * @param $cotacao
     * @return $this
     */
    public function setCotacao($cotacao)
    {
        $this->cotacao = $cotacao;
        return $this;
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getCotacaoMaxima($toReal = false)
    {
        return $this->formatValue((float)($this->cotacaoMaxima ?: $this->cotacao), 'real', $toReal);
    }

    /**
     * @param $cotacaoMaxima
     * @return $this
     */
    function setCotacaoMaxima($cotacaoMaxima)
    {
        $this->cotacaoMaxima = $cotacaoMaxima;
        return $this;
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getValor($toReal = false)
    {
        return $this->formatValue($this->valor, 'real', $toReal);
    }

    /**
     * @param $valor
     * @return $this
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    function getRetornoMaximo($toReal = false)
    {
        return $this->formatValue($this->retornoMaximo ?: $this->getRetorno(), 'real', $toReal);
    }

    /**
     * @param $retornoMaximo
     * @return $this
     */
    function setRetornoMaximo($retornoMaximo)
    {
        $this->retornoMaximo = $retornoMaximo;
        return $this;
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getRetorno($toReal = false)
    {
        return $this->formatValue($this->getCotacao() * $this->getValor(), 'real', $toReal);
    }

    /**
     * @return int
     */
    public function getCasadinha()
    {
        return $this->casadinha ? 1 : 0;
    }

    /**
     * @param $casadinha
     * @return $this
     */
    public function setCasadinha($casadinha)
    {
        $this->casadinha = $casadinha;
        return $this;
    }

    /**
     * Retorna o nivel de bônus por comissão
     * @return int
     */
    public function getNivelBonusComissao()
    {
        if ($this->getJogos() == 1) {
            return 1;
        } else if ($this->getJogos() == 2) {
            return 2;
        } else if (in_array($this->getJogos(), [3, 4, 5])) {
            return 3;
        } else if (in_array($this->getJogos(), [6, 7, 8, 9, 10])) {
            return 4;
        } else {
            return 5;
        }
    }

    /**
     * @return int
     */
    public function getJogos()
    {
        return (int)$this->jogos;
    }

    /**
     * @param $jogos
     * @return $this
     */
    public function setJogos($jogos)
    {
        $this->jogos = $jogos;
        return $this;
    }

    public function check()
    {
        if (!$this->getId()) {

            $config = DadosModel::get();

            if ($this->getValor() < $config->getApostaMinima()) {
                throw new Exception("Aposta mínima é de R$ {$config->getApostaMinima(true)}");
            } else if ($this->getValor() > $config->getApostaMaxima()) {
                throw new Exception("Aposta máxima é de R$ {$config->getApostaMaxima(true)}");
            }

            if ($this->getCotacaoValida() < $config->getCotacaoMinima()) {
                throw new Exception("Cotação mínima é de R$ {$config->getCotacaoMinima(true)}");
            }

        }
    }

}
    
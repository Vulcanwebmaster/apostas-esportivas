<?php

namespace app\vo;

use app\core\ValueObject;
use app\traits\vo\cidade;
use app\traits\vo\email;

class DadosVO extends ValueObject
{

    use cidade;
    use email;

    private $banca;
    private $corPrimaria;
    private $corSecundaria;
    private $limiteUsuarios;
    private $periodoInicial;
    private $periodoFinal;
    private $periodoValor;
    private $app;
    private $informacoes;
    private $regulamento;
    private $regrasAposta;
    private $bloqueado;
    private $imprimirRegras;
    private $imprimirLogo;
    private $valorPreCadastro;
    private $comissaoJogador1;
    private $comissaoJogador2;
    private $comissaoJogador3;
    private $comissaoJogador4;
    private $comissaoJogador5;
    private $comissaoJogadorIndicacao;
    private $comissaoConsultor1;
    private $comissaoConsultor2;
    private $comissaoConsultor3;
    private $comissaoConsultor4;
    private $comissaoConsultor5;
    private $comissaoConsultorIndicacao;
    private $comissaoFranqueado1;
    private $comissaoFranqueado2;
    private $comissaoFranqueado3;
    private $comissaoFranqueado4;
    private $comissaoFranqueado5;
    private $comissaoFranqueadoIndicacao;
    private $valorPlanoJogador;
    private $valorPlanoConsultor;
    private $valorPlanoFranqueado;
    private $valorAdesaoJogador;
    private $valorAdesaoConsultor;
    private $valorAdesaoFranqueado;
    private $valorRecargaJogador;
    private $valorRecargaConsultor;
    private $valorRecargaFranqueado;
    private $cotacaoMinima;
    private $cotacaoMaxima;
    private $retornoMaximo;
    private $maxApostasDia;
    private $apostaMinima;
    private $apostaMaxima;
    private $bonusApuracaoJogador1;
    private $bonusApuracaoJogador2;
    private $bonusApuracaoJogador3;
    private $bonusApuracaoJogador4;
    private $bonusApuracaoJogador5;
    private $bonusApuracaoConsultor1;
    private $bonusApuracaoConsultor2;
    private $bonusApuracaoConsultor3;
    private $bonusApuracaoConsultor4;
    private $bonusApuracaoConsultor5;
    private $bonusApuracaoFranqueado1;
    private $bonusApuracaoFranqueado2;
    private $bonusApuracaoFranqueado3;
    private $bonusApuracaoFranqueado4;
    private $bonusApuracaoFranqueado5;
    private $taxaSaque;
    private $taxaTransferencia;
    private $textoImpressoras;
    private $depositoMinimo;
    private $maxApostas;
    private $minJogos;
    private $limite1;
    private $limite2;
    private $limite3;
    private $saqueIndicados;

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return mixed
     */
    public function valorRecarga(UserVO $user, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->getRecargaMensal($formatar);
        } else {
            return 0;
        }
    }

    /**
     * @return mixed
     */
    public function getValorRecargaJogador($formatar = false)
    {
        return $this->formatValue($this->valorRecargaJogador, 'real', $formatar);
    }

    /**
     * @param mixed $valorRecargaJogador
     * @return $this
     */
    public function setValorRecargaJogador($valorRecargaJogador)
    {
        $this->valorRecargaJogador = $valorRecargaJogador;
        return $this;
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return mixed
     */
    public function valorPlanoAdesao(UserVO $user, bool $formatar = false)
    {
        $valor = $this->valorPlano($user) + $this->valorAdesao($user);
        return $this->formatValue($valor, 'real', $formatar);
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return mixed
     */
    public function valorPlano(UserVO $user, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->getValorPlano($formatar);
        } else {
            return 0;
        }
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return mixed
     */
    public function valorAdesao(UserVO $user, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->getValorAdesao($formatar);
        } else {
            return 0;
        }
    }

    /**
     * @return mixed
     */
    public function getValorAdesaoJogador($formatar = false)
    {
        return $this->formatValue($this->valorAdesaoJogador, 'real', $formatar);
    }

    /**
     * @param mixed $valorAdesaoJogador
     * @return $this
     */
    public function setValorAdesaoJogador($valorAdesaoJogador)
    {
        $this->valorAdesaoJogador = $valorAdesaoJogador;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorPlanoJogador($formatar = false)
    {
        return $this->formatValue($this->valorPlanoJogador, 'real', $formatar);
    }

    /**
     * @param mixed $valorPlanoJogador
     * @return $this
     */
    public function setValorPlanoJogador($valorPlanoJogador)
    {
        $this->valorPlanoJogador = $valorPlanoJogador;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinJogos()
    {
        return $this->minJogos;
    }

    /**
     * @param mixed $minJogos
     * @return $this
     */
    public function setMinJogos($minJogos)
    {
        $this->minJogos = $minJogos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxApostas()
    {
        return (int)$this->maxApostas;
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
    public function getLimite1($formatar = false)
    {
        return $this->formatValue($this->limite1, 'real', $formatar);
    }

    /**
     * @param mixed $limite1
     * @return $this
     */
    public function setLimite1($limite1)
    {
        $this->limite1 = $limite1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimite2($formatar = false)
    {
        return $this->formatValue($this->limite2, 'real', $formatar);
    }

    /**
     * @param mixed $limite2
     * @return $this
     */
    public function setLimite2($limite2)
    {
        $this->limite2 = $limite2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimite3($formatar = false)
    {
        return $this->formatValue($this->limite3, 'real', $formatar);
    }

    /**
     * @param mixed $limite3
     * @return $this
     */
    public function setLimite3($limite3)
    {
        $this->limite3 = $limite3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaqueIndicados()
    {
        return $this->saqueIndicados;
    }

    /**
     * @param mixed $saqueIndicados
     * @return $this
     */
    public function setSaqueIndicados($saqueIndicados)
    {
        $this->saqueIndicados = $saqueIndicados;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxApostasDia()
    {
        return (int)$this->maxApostasDia;
    }

    /**
     * @param mixed $maxApostasDia
     */
    public function setMaxApostasDia($maxApostasDia)
    {
        $this->maxApostasDia = $maxApostasDia;
    }

    /**
     * @return mixed
     */
    public function getRegrasAposta()
    {
        return $this->regrasAposta;
    }

    /**
     * @param mixed $regrasAposta
     * @return $this
     */
    public function setRegrasAposta($regrasAposta)
    {
        $this->regrasAposta = $regrasAposta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepositoMinimo($formatar = false)
    {
        return $this->formatValue($this->depositoMinimo, 'real', $formatar);
    }

    /**
     * @param mixed $depositoMinimo
     * @return $this
     */
    public function setDepositoMinimo($depositoMinimo)
    {
        $this->depositoMinimo = $depositoMinimo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextoImpressoras()
    {
        return $this->textoImpressoras;
    }

    /**
     * @param mixed $textoImpressoras
     * @return $this
     */
    public function setTextoImpressoras($textoImpressoras)
    {
        $this->textoImpressoras = $textoImpressoras;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxaTransferencia($formatar = false)
    {
        return $this->formatValue($this->taxaTransferencia, 'real', $formatar);
    }

    /**
     * @param mixed $taxaTransferencia
     * @return $this
     */
    public function setTaxaTransferencia($taxaTransferencia)
    {
        $this->taxaTransferencia = $taxaTransferencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxaSaque($formatar = false)
    {
        return $this->formatValue($this->taxaSaque, 'real', $formatar);
    }

    /**
     * @param mixed $taxaSaque
     * @return $this
     */
    public function setTaxaSaque($taxaSaque)
    {
        $this->taxaSaque = $taxaSaque;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoJogador1($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoJogador1, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoJogador1
     * @return $this
     */
    public function setBonusApuracaoJogador1($bonusApuracaoJogador1)
    {
        $this->bonusApuracaoJogador1 = $bonusApuracaoJogador1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoJogador2($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoJogador2, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoJogador2
     * @return $this
     */
    public function setBonusApuracaoJogador2($bonusApuracaoJogador2)
    {
        $this->bonusApuracaoJogador2 = $bonusApuracaoJogador2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoJogador3($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoJogador3, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoJogador3
     * @return $this
     */
    public function setBonusApuracaoJogador3($bonusApuracaoJogador3)
    {
        $this->bonusApuracaoJogador3 = $bonusApuracaoJogador3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoJogador4($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoJogador4, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoJogador4
     * @return $this
     */
    public function setBonusApuracaoJogador4($bonusApuracaoJogador4)
    {
        $this->bonusApuracaoJogador4 = $bonusApuracaoJogador4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoJogador5($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoJogador5, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoJogador5
     * @return $this
     */
    public function setBonusApuracaoJogador5($bonusApuracaoJogador5)
    {
        $this->bonusApuracaoJogador5 = $bonusApuracaoJogador5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoConsultor1($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoConsultor1, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoConsultor1
     * @return $this
     */
    public function setBonusApuracaoConsultor1($bonusApuracaoConsultor1)
    {
        $this->bonusApuracaoConsultor1 = $bonusApuracaoConsultor1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoConsultor2($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoConsultor2, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoConsultor2
     * @return $this
     */
    public function setBonusApuracaoConsultor2($bonusApuracaoConsultor2)
    {
        $this->bonusApuracaoConsultor2 = $bonusApuracaoConsultor2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoConsultor3($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoConsultor3, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoConsultor3
     * @return $this
     */
    public function setBonusApuracaoConsultor3($bonusApuracaoConsultor3)
    {
        $this->bonusApuracaoConsultor3 = $bonusApuracaoConsultor3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoConsultor4($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoConsultor4, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoConsultor4
     * @return $this
     */
    public function setBonusApuracaoConsultor4($bonusApuracaoConsultor4)
    {
        $this->bonusApuracaoConsultor4 = $bonusApuracaoConsultor4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoConsultor5($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoConsultor5, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoConsultor5
     * @return $this
     */
    public function setBonusApuracaoConsultor5($bonusApuracaoConsultor5)
    {
        $this->bonusApuracaoConsultor5 = $bonusApuracaoConsultor5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoFranqueado1($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoFranqueado1, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoFranqueado1
     * @return $this
     */
    public function setBonusApuracaoFranqueado1($bonusApuracaoFranqueado1)
    {
        $this->bonusApuracaoFranqueado1 = $bonusApuracaoFranqueado1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoFranqueado2($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoFranqueado2, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoFranqueado2
     * @return $this
     */
    public function setBonusApuracaoFranqueado2($bonusApuracaoFranqueado2)
    {
        $this->bonusApuracaoFranqueado2 = $bonusApuracaoFranqueado2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoFranqueado3($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoFranqueado3, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoFranqueado3
     * @return $this
     */
    public function setBonusApuracaoFranqueado3($bonusApuracaoFranqueado3)
    {
        $this->bonusApuracaoFranqueado3 = $bonusApuracaoFranqueado3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoFranqueado4($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoFranqueado4, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoFranqueado4
     * @return $this
     */
    public function setBonusApuracaoFranqueado4($bonusApuracaoFranqueado4)
    {
        $this->bonusApuracaoFranqueado4 = $bonusApuracaoFranqueado4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonusApuracaoFranqueado5($formatar = false)
    {
        return $this->formatValue($this->bonusApuracaoFranqueado5, 'real', $formatar);
    }

    /**
     * @param mixed $bonusApuracaoFranqueado5
     * @return $this
     */
    public function setBonusApuracaoFranqueado5($bonusApuracaoFranqueado5)
    {
        $this->bonusApuracaoFranqueado5 = $bonusApuracaoFranqueado5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorPreCadastro($formatar = false)
    {
        return $this->formatValue($this->valorPreCadastro, 'real', $formatar);
    }

    /**
     * @param mixed $valorPreCadastro
     */
    public function setValorPreCadastro($valorPreCadastro)
    {
        $this->valorPreCadastro = $valorPreCadastro;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogadorIndicacao($formatar = false)
    {
        return $this->formatValue($this->comissaoJogadorIndicacao, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoJogadorIndicacao
     * @return $this
     */
    public function setComissaoJogadorIndicacao($comissaoJogadorIndicacao)
    {
        $this->comissaoJogadorIndicacao = $comissaoJogadorIndicacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoConsultorIndicacao($formatar = false)
    {
        return $this->formatValue($this->comissaoConsultorIndicacao, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoConsultorIndicacao
     * @return $this
     */
    public function setComissaoConsultorIndicacao($comissaoConsultorIndicacao)
    {
        $this->comissaoConsultorIndicacao = $comissaoConsultorIndicacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoFranqueadoIndicacao($formatar = false)
    {
        return $this->formatValue($this->comissaoFranqueadoIndicacao, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoFranqueadoIndicacao
     * @return $this
     */
    public function setComissaoFranqueadoIndicacao($comissaoFranqueadoIndicacao)
    {
        $this->comissaoFranqueadoIndicacao = $comissaoFranqueadoIndicacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorPlanoConsultor($formatar = false)
    {
        return $this->formatValue($this->valorPlanoConsultor, 'real', $formatar);
    }

    /**
     * @param mixed $valorPlanoConsultor
     * @return $this
     */
    public function setValorPlanoConsultor($valorPlanoConsultor)
    {
        $this->valorPlanoConsultor = $valorPlanoConsultor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorPlanoFranqueado($formatar = false)
    {
        return $this->formatValue($this->valorPlanoFranqueado, 'real', $formatar);
    }

    /**
     * @param mixed $valorPlanoFranqueado
     * @return $this
     */
    public function setValorPlanoFranqueado($valorPlanoFranqueado)
    {
        $this->valorPlanoFranqueado = $valorPlanoFranqueado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorAdesaoConsultor($formatar = false)
    {
        return $this->formatValue($this->valorAdesaoConsultor, 'real', $formatar);
    }

    /**
     * @param mixed $valorAdesaoConsultor
     * @return $this
     */
    public function setValorAdesaoConsultor($valorAdesaoConsultor)
    {
        $this->valorAdesaoConsultor = $valorAdesaoConsultor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorAdesaoFranqueado($formatar = false)
    {
        return $this->formatValue($this->valorAdesaoFranqueado, 'real', $formatar);
    }

    /**
     * @param mixed $valorAdesaoFranqueado
     * @return $this
     */
    public function setValorAdesaoFranqueado($valorAdesaoFranqueado)
    {
        $this->valorAdesaoFranqueado = $valorAdesaoFranqueado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorRecargaConsultor($formatar = false)
    {
        return $this->formatValue($this->valorRecargaConsultor, 'real', $formatar);
    }

    /**
     * @param mixed $valorRecargaConsultor
     * @return $this
     */
    public function setValorRecargaConsultor($valorRecargaConsultor)
    {
        $this->valorRecargaConsultor = $valorRecargaConsultor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorRecargaFranqueado($formatar = false)
    {
        return $this->formatValue($this->valorRecargaFranqueado, 'real', $formatar);
    }

    /**
     * @param mixed $valorRecargaFranqueado
     * @return $this
     */
    public function setValorRecargaFranqueado($valorRecargaFranqueado)
    {
        $this->valorRecargaFranqueado = $valorRecargaFranqueado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCotacaoMinima($formatar = false)
    {
        return $this->formatValue($this->cotacaoMinima, 'real', $formatar);
    }

    /**
     * @param mixed $cotacaoMinima
     * @return $this
     */
    public function setCotacaoMinima($cotacaoMinima)
    {
        $this->cotacaoMinima = $cotacaoMinima;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCotacaoMaxima($formatar = false)
    {
        return $this->formatValue($this->cotacaoMaxima, 'real', $formatar);
    }

    /**
     * @param mixed $cotacaoMaxima
     * @return $this
     */
    public function setCotacaoMaxima($cotacaoMaxima)
    {
        $this->cotacaoMaxima = $cotacaoMaxima;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRetornoMaximo($formatar = false)
    {
        return $this->formatValue($this->retornoMaximo, 'real', $formatar);
    }

    /**
     * @param mixed $retornoMaximo
     * @return $this
     */
    public function setRetornoMaximo($retornoMaximo)
    {
        $this->retornoMaximo = $retornoMaximo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApostaMinima($formatar = false)
    {
        return $this->formatValue($this->apostaMinima, 'real', $formatar);
    }

    /**
     * @param mixed $apostaMinima
     * @return $this
     */
    public function setApostaMinima($apostaMinima)
    {
        $this->apostaMinima = $apostaMinima;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApostaMaxima($formatar = false)
    {
        return $this->formatValue($this->apostaMaxima, 'real', $formatar);
    }

    /**
     * @param mixed $apostaMaxima
     * @return $this
     */
    public function setApostaMaxima($apostaMaxima)
    {
        $this->apostaMaxima = $apostaMaxima;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogador1($formatar = false)
    {
        return $this->formatValue($this->comissaoJogador1, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoJogador1
     * @return $this
     */
    public function setComissaoJogador1($comissaoJogador1)
    {
        $this->comissaoJogador1 = $comissaoJogador1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogador2($formatar = false)
    {
        return $this->formatValue($this->comissaoJogador2, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoJogador2
     * @return $this
     */
    public function setComissaoJogador2($comissaoJogador2)
    {
        $this->comissaoJogador2 = $comissaoJogador2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogador3($formatar = false)
    {
        return $this->formatValue($this->comissaoJogador3, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoJogador3
     * @return $this
     */
    public function setComissaoJogador3($comissaoJogador3)
    {
        $this->comissaoJogador3 = $comissaoJogador3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogador4($formatar = false)
    {
        return $this->formatValue($this->comissaoJogador4, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoJogador4
     * @return $this
     */
    public function setComissaoJogador4($comissaoJogador4)
    {
        $this->comissaoJogador4 = $comissaoJogador4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoJogador5($formatar = false)
    {
        return $this->formatValue($this->comissaoJogador5, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoJogador5
     * @return $this
     */
    public function setComissaoJogador5($comissaoJogador5)
    {
        $this->comissaoJogador5 = $comissaoJogador5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoConsultor1($formatar = false)
    {
        return $this->formatValue($this->comissaoConsultor1, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoConsultor1
     * @return $this
     */
    public function setComissaoConsultor1($comissaoConsultor1)
    {
        $this->comissaoConsultor1 = $comissaoConsultor1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoConsultor2($formatar = false)
    {
        return $this->formatValue($this->comissaoConsultor2, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoConsultor2
     * @return $this
     */
    public function setComissaoConsultor2($comissaoConsultor2)
    {
        $this->comissaoConsultor2 = $comissaoConsultor2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoConsultor3($formatar = false)
    {
        return $this->formatValue($this->comissaoConsultor3, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoConsultor3
     * @return $this
     */
    public function setComissaoConsultor3($comissaoConsultor3)
    {
        $this->comissaoConsultor3 = $comissaoConsultor3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoConsultor4($formatar = false)
    {
        return $this->formatValue($this->comissaoConsultor4, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoConsultor4
     * @return $this
     */
    public function setComissaoConsultor4($comissaoConsultor4)
    {
        $this->comissaoConsultor4 = $comissaoConsultor4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoConsultor5($formatar = false)
    {
        return $this->formatValue($this->comissaoConsultor5, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoConsultor5
     * @return $this
     */
    public function setComissaoConsultor5($comissaoConsultor5)
    {
        $this->comissaoConsultor5 = $comissaoConsultor5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoFranqueado1($formatar = false)
    {
        return $this->formatValue($this->comissaoFranqueado1, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoFranqueado1
     * @return $this
     */
    public function setComissaoFranqueado1($comissaoFranqueado1)
    {
        $this->comissaoFranqueado1 = $comissaoFranqueado1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoFranqueado2($formatar = false)
    {
        return $this->formatValue($this->comissaoFranqueado2, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoFranqueado2
     * @return $this
     */
    public function setComissaoFranqueado2($comissaoFranqueado2)
    {
        $this->comissaoFranqueado2 = $comissaoFranqueado2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoFranqueado3($formatar = false)
    {
        return $this->formatValue($this->comissaoFranqueado3, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoFranqueado3
     * @return $this
     */
    public function setComissaoFranqueado3($comissaoFranqueado3)
    {
        $this->comissaoFranqueado3 = $comissaoFranqueado3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoFranqueado4($formatar = false)
    {
        return $this->formatValue($this->comissaoFranqueado4, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoFranqueado4
     * @return $this
     */
    public function setComissaoFranqueado4($comissaoFranqueado4)
    {
        $this->comissaoFranqueado4 = $comissaoFranqueado4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissaoFranqueado5($formatar = false)
    {
        return $this->formatValue($this->comissaoFranqueado5, 'real', $formatar);
    }

    /**
     * @param mixed $comissaoFranqueado5
     * @return $this
     */
    public function setComissaoFranqueado5($comissaoFranqueado5)
    {
        $this->comissaoFranqueado5 = $comissaoFranqueado5;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanca()
    {
        return trim((string)$this->banca);
    }

    /**
     * @param $banca
     * @return $this
     */
    public function setBanca($banca)
    {
        $this->banca = $banca;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCorPrimaria()
    {
        return $this->corPrimaria;
    }

    /**
     * @param $corPrimaria
     * @return $this
     */
    public function setCorPrimaria($corPrimaria)
    {
        $this->corPrimaria = $corPrimaria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCorSecundaria()
    {
        return $this->corSecundaria;
    }

    /**
     * @param $corSecundaria
     * @return $this
     */
    public function setCorSecundaria($corSecundaria)
    {
        $this->corSecundaria = $corSecundaria;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimiteUsuarios()
    {
        return (int)$this->limiteUsuarios;
    }

    /**
     * @param $limiteUsuarios
     * @return $this
     */
    public function setLimiteUsuarios($limiteUsuarios)
    {
        $this->limiteUsuarios = $limiteUsuarios;
        return $this;
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getPeriodoInicial($formatar = false)
    {
        return $this->formatValue($this->periodoInicial, 'data', $formatar);
    }

    /**
     * @param $periodoInicial
     * @return $this
     */
    public function setPeriodoInicial($periodoInicial)
    {
        $this->periodoInicial = $periodoInicial;
        return $this;
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getPeriodoFinal($formatar = false)
    {
        return $this->formatValue($this->periodoFinal, 'data', $formatar);
    }

    /**
     * @param $periodoFinal
     * @return $this
     */
    public function setPeriodoFinal($periodoFinal)
    {
        $this->periodoFinal = $periodoFinal;
        return $this;
    }

    /**
     * @param bool $toReal
     * @return mixed
     */
    public function getPeriodoValor($toReal = false)
    {
        return $this->formatValue($this->periodoValor, 'real', $toReal);
    }

    /**
     * @param $periodoValor
     * @return $this
     */
    public function setPeriodoValor($periodoValor)
    {
        $this->periodoValor = $periodoValor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @param $app
     * @return $this
     */
    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInformacoes()
    {
        return $this->informacoes;
    }

    /**
     * @param $informacoes
     * @return $this
     */
    public function setInformacoes($informacoes)
    {
        $this->informacoes = $informacoes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegulamento()
    {
        return $this->regulamento;
    }

    /**
     * @param $regulamento
     * @return $this
     */
    public function setRegulamento($regulamento)
    {
        $this->regulamento = $regulamento;
        return $this;
    }

    /**
     * @return int
     */
    public function getBloqueado()
    {
        return $this->bloqueado ? 1 : 0;
    }

    /**
     * @param $bloqueado
     * @return $this
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;
        return $this;
    }

    /**
     * @return int
     */
    public function getImprimirRegras()
    {
        return $this->imprimirRegras ? 1 : 0;
    }

    /**
     * @param $imprimirRegras
     * @return $this
     */
    public function setImprimirRegras($imprimirRegras)
    {
        $this->imprimirRegras = $imprimirRegras;
        return $this;
    }

    /**
     * @return int
     */
    public function getImprimirLogo()
    {
        return $this->imprimirLogo ? 1 : 0;
    }

    /**
     * @param $imprimirLogo
     * @return $this
     */
    public function setImprimirLogo($imprimirLogo)
    {
        $this->imprimirLogo = $imprimirLogo;
        return $this;
    }

}
    
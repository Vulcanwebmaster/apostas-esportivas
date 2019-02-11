<?php

namespace app\vo;

use app\core\ValueObject;
use app\helpers\Utils;
use app\models\DadosModel;
use app\models\UsersTypesModel;
use app\traits\graduacao;
use app\traits\licenca;
use app\traits\vo\cidade;
use app\traits\vo\cpf;
use app\traits\vo\email;
use app\traits\vo\endereco;
use app\traits\vo\geolocate;
use app\traits\vo\login;
use app\traits\vo\senha;
use app\traits\vo\telefones;
use app\traits\vo\token;
use app\traits\vo\user;
use Exception;

class UserVO extends ValueObject
{

    use token;
    use cidade;
    use endereco;
    use login;
    use senha;
    use user;
    use cpf;
    use email;
    use geolocate;
    use telefones;
    use licenca;
    use graduacao;

    private $type;
    private $nome;
    private $sexo;
    private $nascimento;
    private $comissao;
    private $credito;
    private $dataValidade;
    private $pagouPlano;
    private $pagouPreCadastro;
    private $dadosBancarios;
    private $comercializacao;
    private $participacao;
    private $qtdeIndicados;
    private $qtdeApostas;
    private $qtdeApostasDia;
    private $appId;

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     * @return $this
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtdeApostasDia()
    {
        return (int)$this->qtdeApostasDia;
    }

    /**
     * @param mixed $qtdeApostasDia
     */
    public function setQtdeApostasDia($qtdeApostasDia)
    {
        $this->qtdeApostasDia = $qtdeApostasDia;
    }

    public function getTypeTitle()
    {
        if ($this->voType())
            return $this->voType()->getTitle();
    }

    /**
     * @return UserTypeVO
     */
    public function voType()
    {
        return UsersTypesModel::getByLabel('id', $this->getType());
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return (int)$this->type;
    }

    /**
     * @param mixed $type
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
    public function getParticipacao($formatar = false)
    {
        return $this->formatValue($this->participacao, 'real', $formatar);
    }

    /**
     * @param mixed $participacao
     * @return $this
     */
    public function setParticipacao($participacao)
    {
        $this->participacao = $participacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtdeApostas()
    {
        return (int)$this->qtdeApostas;
    }

    /**
     * @param mixed $qtdeApostas
     * @return $this
     */
    public function setQtdeApostas($qtdeApostas)
    {
        $this->qtdeApostas = $qtdeApostas;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComercializacao($formatar = false)
    {
        return $this->formatValue($this->comercializacao, 'real', $formatar);
    }

    /**
     * @param mixed $comercializacao
     * @return $this
     */
    public function setComercializacao($comercializacao)
    {
        $this->comercializacao = $comercializacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDadosBancarios($toArray = false)
    {
        if ($toArray and !is_array($this->dadosBancarios)) {
            return json_decode($this->dadosBancarios, true) ?: [];
        } else if (!$toArray and is_array($this->dadosBancarios)) {
            return json_encode($this->dadosBancarios);
        }
        return $this->dadosBancarios;
    }

    /**
     * @param mixed $dadosBancarios
     * @return $this
     */
    public function setDadosBancarios($dadosBancarios)
    {
        $this->dadosBancarios = $dadosBancarios;
        return $this;
    }

    /**
     * @param bool $formatar
     * @return mixed
     */
    public function getDataCadastro($formatar = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $formatar);
    }

    /**
     * @return mixed
     */
    public function getPagouPreCadastro()
    {
        return $this->pagouPreCadastro;
    }

    /**
     * @param mixed $pagouPreCadastro
     */
    public function setPagouPreCadastro($pagouPreCadastro)
    {
        $this->pagouPreCadastro = $pagouPreCadastro;
    }

    /**
     * @param bool $formatar
     * @return float|string
     */
    public function getValorRecarga($formatar = false)
    {
        return DadosModel::getValorRecarga($this, $formatar) ?: ($formatar ? '50,00' : 50);
    }

    /**
     * @return bool
     */
    public function getEmDia()
    {
        return $this->estaEmDia() ? 1 : 0;
    }

    /**
     * Verifica se a renovação está em dia
     * @return bool
     */
    public function estaEmDia()
    {
        $validade = $this->getDataValidade();
        return ($this->getPagouPlano() and $validade and $this->getStatus() == 1 and date('Y-m-d') <= $validade);
    }

    /**
     * @return mixed
     */
    public function getDataValidade($formatar = false)
    {
        return $this->formatValue($this->dataValidade, 'data', $formatar);
    }

    /**
     * @param mixed $dataValidade
     * @return $this
     */
    public function setDataValidade($dataValidade)
    {
        $this->dataValidade = $dataValidade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPagouPlano()
    {
        return $this->pagouPlano ? 1 : 0;
    }

    /**
     * @param mixed $pagouPlano
     */
    public function setPagouPlano($pagouPlano)
    {
        $this->pagouPlano = $pagouPlano;
    }

    /**
     * Verifica se o usuário está apto a receber bonus de equipe/apuração
     * @return bool
     */
    public function recebeBonusEquipe()
    {
        if ($this->estaEmDia() and $this->getQtdeIndicados() >= 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getQtdeIndicados()
    {
        return (int)$this->qtdeIndicados;
    }

    /**
     * @param mixed $qtdeIndicados
     * @return $this
     */
    public function setQtdeIndicados($qtdeIndicados)
    {
        $this->qtdeIndicados = $qtdeIndicados;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComissao($formatar = false)
    {
        return $this->formatValue($this->comissao, 'real', $formatar);
    }

    /**
     * @param mixed $comissao
     * @return $this
     */
    public function setComissao($comissao)
    {
        $this->comissao = $comissao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCredito($formatar = false)
    {
        return $this->formatValue($this->credito, 'real', $formatar);
    }

    /**
     * @param mixed $credito
     * @return $this
     */
    public function setCredito($credito)
    {
        $this->credito = $credito;
        return $this;
    }

    public function check()
    {

        if (!$this->voType()) {
            throw new Exception('Tipo de conta inválido');
        }

        $this->checkCpf(true, true);
        $this->checkEmail(true, true);
        $this->checkLogin();
        $this->checkCidade();

        if (!$this->getId()) {
            if (!$this->getTelefone() and !$this->getCelular() and !$this->getWhatsapp()) {
                throw new Exception('Informe um telefone ou celular para contato');
            }
        }

        if ($this->getIdade() < 18) {
            throw new Exception('Idade mínima de 18 anos');
        }
    }

    /**
     * @return int
     */
    public function getIdade()
    {
        if ($data = $this->getNascimento())
            return Utils::calcIdade($data);
    }

    /**
     * @return mixed
     */
    public function getNascimento($formatar = false)
    {
        return $this->formatValue($this->nascimento, 'data', $formatar);
    }

    /**
     * @param mixed $nascimento
     * @return $this
     */
    public function setNascimento($nascimento)
    {
        $this->nascimento = $nascimento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return $this
     */
    public function setNome($nome)
    {
        if ($nome) {
            if (!preg_match('/^[ ]*(.+[ ]+)+.+[ ]*$/', $nome)) {
                throw new Exception('Informe seu nome completo');
            }
        }
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo == 'f' ? 'f' : 'm';
    }

    /**
     * @param mixed $sexo
     * @return $this
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
        return $this;
    }


}
    
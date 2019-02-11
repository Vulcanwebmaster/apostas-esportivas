<?php

namespace app\helpers;

use app\models\SmtpModel;
use app\vo\SmtpVO;
use Exception;
use PHPMailer;

class SMail
{

    /** @var PHPMailer */
    private $SMTP;

    /** @var SmtpVO */
    private $Config;

    public function __construct()
    {
        $this->SMTP = new PHPMailer;
        $this->getConfig();
    }

    /**
     * Retorna as configurações de envio
     * @return SmtpVO
     * @throws Exception
     */
    function getConfig()
    {
        if (!$this->Config) {
            $this->Config = SmtpModel::getConfig();
            if (empty($this->Config)) {
                throw new Exception('Não foi possível carregar as configurações SMTP.');
            }
            $this->SMTP->IsSMTP();
            $this->SMTP->IsHTML();
            $this->SMTP->CharSet = 'UTF-8';
            $this->SMTP->Host = $this->Config->getHost();
            $this->SMTP->Username = $this->Config->getLogin();
            $this->SMTP->Password = $this->Config->getSenha();
            $this->SMTP->Port = $this->Config->getPorta();
            $this->SMTP->SMTPAuth = $this->Config->getAutenticar() ? true : false;
            $this->SMTP->SMTPSecure = $this->Config->getProtocolo();

            $this->setFrom($this->Config->getNome(), $this->Config->getEmail());
        }
        return $this->Config;
    }

    /**
     * Remetente
     * @param string $nome
     * @param string $email
     */
    public function setFrom($nome, $email)
    {
        $this->SMTP->SetFrom($this->SMTP->Username, $nome);
        $this->SMTP->clearReplyTos();
        $this->SMTP->AddReplyTo($email, $nome);
    }

    /**
     * Destinatário
     * @param string $name
     * @param string $email
     */
    public function addAddress($name, $email)
    {
        $this->SMTP->AddAddress($email, $name);
    }

    /**
     * Anexando arquivo
     * @param string $file Diretório completo do arquivo
     * @param string $name Nome do arquivo para anexar
     */
    public function addAttachment($file, $name = null)
    {
        if (file_exists($file)) {
            $this->SMTP->addAttachment($file, !$name ? basename($file) : $name);
        }
    }

    /**
     * Informa o corpo da mensagem
     * @param string $mensagem
     */
    public function setBody($mensagem)
    {
        $this->setContent(null, $mensagem);
    }

    /**
     * Informa o conteúdo da mensagem
     * @param string $assunto
     * @param string $mensagem
     */
    public function setContent($assunto = null, $mensagem = null)
    {
        if (!empty($assunto)) {
            $this->SMTP->Subject = $assunto;
        }
        $this->SMTP->Body = "<!doctype html><html><head><title>{$assunto}</title><meta charset='UTF-8' /></head><body>{$mensagem}</body></html>";
        $this->SMTP->msgHTML($mensagem);
    }

    /**
     * Envia a mensagem
     * @return boolean
     * @throws Exception
     */
    public function Send()
    {
        if (!$this->SMTP->Send()) {
            throw new Exception($this->SMTP->ErrorInfo);
        }
        return true;
    }

}
    
<?php

namespace app\modules\cron\controllers;

use app\core\Controller;
use app\core\crud\Conn;
use app\helpers\SMail;
use app\models\SmtpModel;
use Exception;
use Ifsnop\Mysqldump\Mysqldump;
use ZipArchive;

class mysqlController extends Controller
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $tables;

    function __construct()
    {
        # Liberando memória
        ini_set('memory_limit', '500M');

        # Dados
        $this->config = Conn::getConfig();
        $this->tables = Conn::getTables();

        # Configurando pasta
        $this->path = abs_source('temp');

        # Criando pasta
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }

        # Alerando permissão da pasta
        chmod($this->path, 0777);
    }

    /**
     * Backup completo do banco
     */
    function backupAction()
    {

        if(IS_LOCAL)
            return null;

        $config = $this->config;
        $tables = $this->tables;

        $host = "mysql:host={$config['host']};dbname={$config['database']}";
        $user = $config['user'];
        $password = $config['password'];
        $arquivos = [];

        try {

            $source = "{$this->path}/__completo.sql";

            (new Mysqldump($host, $user, $password))
                ->start($source);

            $arquivos[] = $source;

            echo '<div>Backup completo da database: <b>' . $config['database'] . '</b> concluído</div>';

            $zipSource = $this->zipFiles($arquivos);
            $this->enviaEmail($zipSource);
            $this->deletaArquivos($arquivos);

            echo '<div style="color: #357eba;">Backup concluído</div>';

            error_log("Backup MySql concluído");

        } catch (Exception $e) {
            echo '<div style="color: red;">Backup:Error: ' . $e->getMessage() . '</div>';
            error_log('Backup:Error: ' . $e->getMessage());
        }

    }

    /**
     * Compactando arquivos em ZIP
     * @param array $arquivos
     * @return string
     * @throws \Exception
     */
    function zipFiles(array &$arquivos)
    {
        if (!class_exists('ZipArchive')) {
            echo '<div style="color: red;">Instale a biblioteca ZipArchive</div>';
        } else if ($arquivos) {

            $zip = new ZipArchive();

            $source = "{$this->path}/backup.zip";

            if (file_exists($source)) {
                unlink($source);
            }

            $filesOK = 0;

            if ($zip->open($source, ZipArchive::CREATE)) {

                foreach ($arquivos as $file) {
                    if ($zip->addFile($file, basename($file))) {
                        $filesOK++;
                    } else {
                        echo '<div style="color: red;">Não foi possível zipar o arquivo: ' . basename($file) . '</div>';
                    }
                }

                if (!$filesOK or !$zip->close()) {
                    echo '<div style="color: red;">Não foi possível zipar o banco</div>';
                } else {
                    echo '<div>Arquivo zipado com sucesso: ' . basename($source) . '</div>';
                    $arquivos[] = $source;
                    return $source;
                }
            } else {
                throw new \Exception('Não foi possível abrir o arquivo ZIP');
            }
        }

    }

    /**
     * Envia o BACKUP anexado
     */
    function enviaEmail($source = null)
    {
        if ($source and file_exists($source)) {

            $emails = [
                SmtpModel::getConfig()->getEmail(),
            ];

            $smail = new SMail;

            $config = $smail->getConfig();

            $smail->setFrom($config->getNome(), $config->getLogin());

            foreach ($emails as $email){
                $smail->addAddress($config->getNome(), $email);
            }

            $hora = date('H:i:s');
            $data = date('d/m/Y');

            $smail->setContent('Backup Sistema Integrado', "Segue em anexo backup da base de dados realizada às {$hora} do dia {$data}");

            $smail->addAttachment($source, 'backup-mysql.zip');

            if (IS_LOCAL) {
                echo '<div>Backup enviado para os destinatários com sucesso</div>';
            } else {
                try {
                    $smail->Send();
                    echo '<div>Backup enviado para os destinatários com sucesso</div>';
                } catch (\Exception $ex) {
                    echo '<div>Não foi possível enviar o backup para o email.</div>';
                    error_log('Backup:SMTP: ' . $ex->getMessage());
                }
            }

        } else {
            echo '<div style="color: red;">Arquivo ' . basename($source) . ' não existe para ser enviado por e-mail.</div>';
        }
    }

    /**
     * Apaga os arquivos do servidor
     * @param array $arquivos
     */
    function deletaArquivos(array $arquivos)
    {
        foreach ($arquivos as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

}
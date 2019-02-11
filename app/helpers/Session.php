<?php

namespace app\helpers;

use app\APP;
use Exception;

final class Session
{

    private static $_SESSION_;
    private static $Path;
    private $SessionName;

    /**
     * Inicia uma sessão
     * @param string $sessionName
     * @param boolean $ProtectedModule
     */
    public function __construct($sessionName, $ProtectedModule = false)
    {
        self::start();
        $this->SessionName = ($ProtectedModule ? (is_string($ProtectedModule) ? $ProtectedModule : APP::getCurrentModule()) . '-' : null) . $sessionName;
        if (!isset($_SESSION[self::$_SESSION_][$this->SessionName])) {
            $_SESSION[self::$_SESSION_][$this->SessionName] = null;
        }
    }

    /**
     * Inicia a sessão no php
     * @param string $Module
     * @throws Exception
     */
    public static function start($Module = null)
    {
        if (!session_id()) {

            $config = app_config('project');

            self::$_SESSION_ = $config['name'];

            $path = self::getDirectory();

            if ($Module) {
                $path .= '/' . $Module;
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                    chmod($path, 0777);
                }
            }

            session_cache_expire($config['sessiontime']);
            session_save_path($path);

            session_start();

            # Iniciando array
            if (!isset($_SESSION[self::$_SESSION_])) {
                $_SESSION[self::$_SESSION_] = [];
            }
        }
    }

    /**
     * Retorna o diretório
     * @return string
     */
    static function getDirectory()
    {
        if (!file_exists(self::$Path)) {
            throw new Exception('Diretório inexistente.');
        }
        return self::$Path;
    }

    /**
     * Define o diretório
     * @param string $directory
     */
    static function setDirectory($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
            chmod($directory, 0777);
        }
        self::$Path = $directory;
    }

    /**
     * Retorna a chave da sessão
     * @return string
     */
    public static function getId()
    {
        self::start();
        return session_id();
    }

    /**
     * Retorna o valor na sessão
     * @param string $name
     * @param object $defafultValue Valor padrão
     * @return string
     */
    public function get($name = null, $defafultValue = null)
    {
        if (null == $name) {
            return isset($_SESSION[self::$_SESSION_][$this->SessionName]) ? $_SESSION[self::$_SESSION_][$this->SessionName] : ($_SESSION[self::$_SESSION_][$this->SessionName] = $defafultValue);
        } else {
            return isset($_SESSION[self::$_SESSION_][$this->SessionName][$name]) ? $_SESSION[self::$_SESSION_][$this->SessionName][$name] : ($_SESSION[self::$_SESSION_][$this->SessionName][$name] = $defafultValue);
        }
    }

    /**
     * Seta um valor na sessão
     * @param string $name
     * @param object $value
     */
    public function set($name = null, $value = null)
    {
        if (null == $name) {
            return $_SESSION[self::$_SESSION_][$this->SessionName] = $value;
        } else {
            return $_SESSION[self::$_SESSION_][$this->SessionName][$name] = $value;
        }
    }

    /**
     * Destroi a sessão
     */
    public function destroy()
    {
        if (isset($_SESSION[self::$_SESSION_][$this->SessionName])) {
            unset($_SESSION[self::$_SESSION_][$this->SessionName]);
        }
    }

}
    
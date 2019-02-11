<?php

namespace app\helpers;

use Exception;

final class Cache
{

    /** @var array Armazendo na memória caches carregados */
    private static $CacheLoads = [];
    private static $DefaultTime = '+1minute';
    /** @var string Pasta onde os arquivos de cache serão gravados */
    private static $Path;
    private $KeyPath = '';
    private $Key = null;
    private $KeyName = null;
    private $ExpireDate;
    private $Content = null;
    /** @var string Tempo padrão de um Cache */
    private $Time = null;

    /**
     * Inicia a leitura do cache
     * @param string $Key
     * @param int $CacheTime Minutos
     */
    function __construct($Key = null, $CacheTime = null)
    {
        if ($Key !== null) {
            $this->setKey($Key, $CacheTime);
        }
    }

    /**
     * Inicia o gerenciamento de uma nova chave
     * @param string $Key
     * @param string|int $time
     * @return Cache
     */
    public function setKey($Key, $time = null)
    {
        # Tempo de cache
        $this->setTime($time);

        # Extraindo valores
        $this->extractInfos($Key);

        # Recuperando conteúdo atual
        $this->loadCache();

        return $this;
    }

    /**
     * Define o tempo de cache
     * @param string|int $time
     * @throws Exception
     */
    public function setTime($time = null)
    {
        if (is_int($time)) {
            $this->Time = '+' . $time . 'minutes';
        } else if (!is_null($time)) {
            $this->Time = $time;
        } else if ($this->Time === null) {
            $this->setTime(self::$DefaultTime);
        }
    }

    /**
     * Extrai informações da chave
     * @param string $Key
     * @return Object
     */
    private function extractInfos($Key)
    {

        $this->KeyName = $Key;
        $infos = explode('.', $Key);
        $this->Key = end($infos);
        array_pop($infos);
        $infos = array_values($infos);

        /**
         * Pastas
         */
        if (count($infos)) {
            $this->KeyPath = self::getDirectory() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $infos);
            if (!file_exists($this->KeyPath)) {
                mkdir($this->KeyPath, 0777, true);
                chmod($this->KeyPath, 0777);
            }
        } else {
            $this->KeyPath = self::getDirectory();
        }

        return $this;
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
    }/** @noinspection PhpUndefinedClassInspection */

    /**
     * Lê o conteúdo do Cache
     * @return $this
     */
    private function loadCache()
    {
        # Verificando se o valor já foi carregado
        if (isset(self::$CacheLoads[$this->KeyName])) {
            $this->Content = self::$CacheLoads[$this->KeyName]['content'];
            $this->ExpireDate = self::$CacheLoads[$this->KeyName]['expire'];
        } # Verificando existencia do cache
        else if (file_exists($this->getPathFile())) {

            # Extraindo valores do arquivo
            $content = @unserialize(file_get_contents($this->getPathFile()));
            if ($content and $content['key'] == $this->KeyName) {

                # Verificando se expirou
                if (time() <= $content['expire']) {
                    self::$CacheLoads[$this->KeyName] = [
                        'content' => $this->Content = $content['content'],
                        'expire' => $this->ExpireDate = date('Y-m-d H:i:s', $content['expire']),
                    ];
                }
            }
        }
        # Retorna o próprio objeto
        return $this;
    }

    /**
     * Retorna o diretório completo até o arquivo
     * @return string
     */
    private function getPathFile()
    {
        return $this->KeyPath . DIRECTORY_SEPARATOR . (preg_match('/^[a-z\-0-9]$/i', $this->Key) ? $this->Key : md5($this->Key)) . '.tmp';
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
     * Define o tempo padrão de cache
     * @param int|string $time
     */
    static function setDefaultTime($time)
    {
        self::$DefaultTime = $time;
    }

    public static function ClearAll($path = null)
    {
        $files = self::getAllFiles(preg_replace('/[\/\\\]$/', null, self::getDirectory() . DIRECTORY_SEPARATOR . $path));
        foreach ($files as $file) {
            if (is_dir($file)) {
                @rmdir($file);
            } else {
                @unlink($file);
            }
        }
        return true;
    }

    private static function getAllFiles($Path)
    {
        $files = [];
        foreach (glob("{$Path}/*", GLOB_BRACE) as $file) {
            $files[] = $file;
            if (is_dir($file)) {
                $files = array_merge(self::getAllFiles($file), $files);
            }
        }
        return $files;
    }

    function getExpireDate()
    {
        return $this->ExpireDate;
    }

    /**
     * Retorna o conteúdo do cache
     * @return mixed
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * Seta o conteúdo
     * @param mixed $Content
     * @return $this
     */
    function setContent($Content = null, $Time = null)
    {
        $this->Content = $Content;
        $this->setTime($Time);
        $this->save();
        return $this;
    }

    /**
     * Salva os dados no cache
     * @return $this
     */
    private function save()
    {
        if ($this->Content === null) {
            $this->clear();
        } else {

            file_put_contents($this->getPathFile(), serialize([
                'key' => $this->KeyName,
                'create' => time(),
                'expire' => $expire = strtotime($this->Time),
                'content' => $this->Content,
            ]));

            self::$CacheLoads[$this->KeyName] = [
                'content' => $this->Content,
                'expire' => $this->ExpireDate = date('Y-m-d H:i:s', $expire),
            ];
        }
        return $this;
    }

    /**
     * Limpa o cache
     * @return $this
     */
    public function clear()
    {
        if (file_exists($this->getPathFile())) {
            unlink($this->getPathFile());
        }
        # Limpando da Array
        if (isset(self::$CacheLoads[$this->KeyName])) {
            unset(self::$CacheLoads[$this->KeyName]);
        }
        return $this;
    }

    /**
     * Liberando a memória
     */
    public function __destruct()
    {
        self::$CacheLoads = null;
    }

}
    
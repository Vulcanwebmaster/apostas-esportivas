<?php

namespace app;

use app\core\Controller;
use app\core\Model;
use Exception;
use ReflectionClass;

class APP
{

    /** @var array Lista de modulos */
    private static $modules;

    /** @var string Modulo atual */
    private static $currentModule;

    /** @var array Configurações da Aplicação */
    private static $APP_CONFIG;

    /** @var string Modulo padrão */
    private static $defaultModule;

    /** @var Controller Controller atual */
    private static $controller;

    /** @var string Ação atual */
    private static $action;

    /** @var string Parâmetros da URL */
    private static $parans;

    /** @var array Irá guardar uma instância única dos objetos */
    private static $instances = [];

    /** @var string EX: http://localhost:8090 */
    private static $baseUrl;

    /** @var array Guarda valores globais */
    private static $globals = [];

    /**
     * Retorna as configurações da aplicação
     * @return array
     */
    public static function getConfig()
    {
        return self::$APP_CONFIG;
    }

    /**
     * Retorna uma instancia Model
     * @param string $NameClass
     * @param string $Path
     * @return Model
     */
    public static function getInstanceModel($NameClass, $Path = null)
    {
        return self::getInstance(preg_replace('/Model$/', null, $NameClass) . 'Model', $Path);
    }

    /**
     * Retorna a instância única do objecto solicitado (Singleton)
     * @param string $NameClass
     * @return object
     */
    public static function getInstance($NameClass, array $Parametros = null)
    {

        if (isset(self::$instances[$NameClass])) {
            return self::$instances[$NameClass];
        } else {

            # Criando
            if (class_exists($NameClass)) {
                return self::$instances[$NameClass] = (new ReflectionClass($NameClass))->newInstanceArgs((array)$Parametros);
            } # Não existe
            else {
                throw new Exception("A classe `{$NameClass}` não existe.");
            }
        }
        return null;
    }

    /**
     * Retorna uma instancia Controller
     * @param string $NameClass
     * @return Controller
     */
    public static function getInstanceController($NameClass)
    {
        return self::getInstance(strtolower(preg_replace('/Controller$/', null, $NameClass)) . 'Controller');
    }

    /**
     * Retorna o nome ou a pasta do modulo
     * @return string
     */
    static function getDefaultModule()
    {
        return self::$defaultModule;
    }

    /**
     * Retorna os parâmetros da URL
     * @return array
     */
    static function getParans()
    {
        return self::$parans;
    }

    /**
     * Inicia a aplicação
     * @param array $config
     * @param string $PublicPath
     */
    static function Initialize(array $config = null, $PublicPath = '..')
    {

        if ($config)
            self::setConfig($config);

        # Setando lista de módulos
        if (isset(self::$APP_CONFIG['modules'])) {
            self::setModules(self::$APP_CONFIG['modules']);
        }

        # URL Variables
        $parse = self::parseURI();

        self::$currentModule = $parse['module'];

        $Controller = $parse['controller'];
        $Action = $parse['action'];
        self::$parans = $parse['parans'];

        # Parâmetros nomeados
        if (self::$parans) {
            for ($i = 0; $i < count($parse['parans']); $i += 2) {
                if (isset($parse['parans'][$i + 1]) and !preg_match('/^[0-9]{1,}$/', $parse['parans'][$i])) {
                    self::$parans[$parse['parans'][$i]] = $parse['parans'][$i + 1];
                }
            }
        }

        # Modulo
        self::$parans['module'] = $parse['module'];

        # Controller
        self::$parans['controller'] = $parse['controller'];

        # Action
        self::$parans['action'] = $parse['action'];

        # Valores GET
        if (preg_match('/\?/', inputServer('REQUEST_URI'))) {
            parse_str(preg_replace('/.*\?/', NULL, inputServer('REQUEST_URI')), $getValues);
            foreach ($getValues as $key => $value) {
                $_GET[$key] = $value;
                if (!isset(self::$parans[$key])) {
                    self::$parans[$key] = $value;
                }
            }
        }

        # Action
        self::$action = $Action;
        self::$controller = $Controller;
        $moduleConfig = self::getModuleConfig();

        # Instância do módulo
        if (!empty($moduleConfig['class'])) {
            $class = $moduleConfig['class'];
            new $class;
        }

        self::setController($Controller);

        # Executando a action
        if (method_exists(self::getController(), "{$Action}Action")) {
            $resultAction = self::getController()->{"{$Action}Action"}();
        } else {
            $resultAction = self::getController()->notfoundAction();
        }

        if ($resultAction instanceof Exception) {
            $resultAction = [
                'message' => $resultAction->getMessage(),
                'result' => $resultAction->getCode(),
            ];
        }

        $moduleDir = APP::getCurrentModule() . '-' . APP::getControllerName() . '-' . APP::getAction();

        # Saída do retorno da Action
        switch (gettype($resultAction)) {
            case 'object':
            case 'array':

                if (is_object($resultAction)) {
                    if ($resultAction instanceof Exception) {
                        $resultAction = ['message' => $resultAction->getMessage(), 'result' => $resultAction->getCode()];
                    } else {
                        $resultAction = get_object_vars($resultAction);
                    }
                }

                ob_end_clean();

                header('Content-Type: application/json; charset=UTF-8', true);
                header('Content-Disposition: inline; filename=' . $moduleDir . '.json', true);

                echo json_encode($resultAction);

                break;

            case 'string':

                ob_end_clean();

                header('Content-type: text/html; charset=UTF-8', true);

                echo $resultAction;

                break;
        }
    }

    /**
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        self::$APP_CONFIG = $config;
    }

    /**
     *
     * @param string $URI
     * @return array
     * @throws Exception
     */
    static function parseURI($URI = null)
    {

        $result = [];

        # Pegando valor padrão
        if ($URI === null) {
            $URI = str_replace(dirname(getenv('SCRIPT_NAME')) . '/', null, getenv('REQUEST_URI')) ?: 'index/index';
        }

        $url = preg_replace('/\?.*$/', null, $URI);

        if (preg_match('/\.[0-9a-z]{1,5}$/i', $url)) {
            $result['extension'] = str_replace('.', null, preg_replace('/.*\.([a-z0-9]{1,5})$/i', '$1', $url) ?: 'html');
            $url = preg_replace("/(.*)\.{$result['extension']}$/i", '$1', $url);
        } else {
            $result['extension'] = 'html';
        }

        // Limpando URL
        $urlValues = preg_replace('/^\//', null, str_replace(self::getBaseUrl(), null, $url));
        // Não é do SITE
        if (preg_match('/^https?\:\/\//', $urlValues)) {
            throw new Exception('URL não pertence a essa aplicação.');
        }

        // Explodindo valores
        $values = explode('/', $urlValues);

        # Modulo
        if (isset(self::$modules[$values[0]])) {
            $result['module'] = $values[0];
            array_shift($values);
        } else {
            $result['module'] = self::$defaultModule;
        }

        # Módulo atual
        if (!self::getCurrentModule()) {
            self::$currentModule = $result['module'];
        }

        # Controller
        if (!$values or !url_parse_controllerAction($values[0])) {
            $result['controller'] = 'index';
        } else {
            if (count($values) > 1 and self::controllerExists("{$values[0]}\\{$values[1]}", $result['module'])) {
                $result['controller'] = "{$values[0]}\\{$values[1]}";
                array_shift($values);
                array_shift($values);
            } else if ($values and self::controllerExists($values[0] . '\\index', $result['module'])) {
                $result['controller'] = "{$values[0]}\\index";
                array_shift($values);
            } else if (self::controllerExists($values[0], $result['module'])) {
                $result['controller'] = $values[0];
                array_shift($values);
            } else {
                $result['controller'] = 'index';
            }
        }

        $result['controllerClass'] = self::getModuleConfig($result['module'])['path'] . '\controllers\\' . $result['controller'] . 'Controller';

        # Action
        if (!empty($values[0]) and method_exists($result['controllerClass'], "{$values[0]}Action")) {
            $result['action'] = $values[0];
            array_shift($values);
        } else {
            $result['action'] = 'index';
        }

        # Parâmetros númericos
        $result['parans'] = $values;

        # Parâmetros nomeados
        if ($result['parans']) {
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i + 1]) and !preg_match('/^[0-9]{1,}$/', $values[$i])) {
                    $result['parans'][$values[$i]] = $values[$i + 1];
                }
            }
        }

        $result['parans']['extension'] = $result['extension'];

        return $result;
    }

    /**
     * URL de base dos arquivos publicos
     * @return string
     */
    public static function getBaseUrl()
    {
        return app_config('uri');
    }

    /**
     * Retorn o Módulo atual
     * @return string
     */
    static function getCurrentModule($Path = false)
    {
        return !$Path ? self::$currentModule : self::getModules(self::$currentModule, $Path);
    }

    /**
     * Retorna os Modulos
     * @param string $Modulo
     * @return boolean
     */
    static function getModules($Modulo = null)
    {
        if ($Modulo === null) {
            return self::$modules;
        } else {
            if (isset(self::$modules[$Modulo])) {
                self::$modules[$Modulo];
            } else {
                return null;
            }
        }
    }

    /**
     * Define a lista de módulos da aplicação
     * @param array $modules
     */
    static function setModules(array $modules)
    {
        self::$modules = $modules;
        reset($modules);
        self::$defaultModule = key($modules);
    }

    static function controllerExists($controller, $module = null)
    {
        if ($module == null) {
            $module = self::getCurrentModule();
        }

        $controller = '\\' . self::getModuleConfig($module)['path'] . '\controllers\\' . strtolower($controller) . 'Controller';

        if (class_exists($controller)) {
            return $controller;
        } else {
            return false;
        }
    }

    /**
     * Retorna as configurações do Módulo
     * @param string $Module Se não for informado retorna do modulo atual
     * @return mixed
     */
    static function getModuleConfig($Module = null)
    {
        if ($Module === null) {
            $Module = self::getCurrentModule();
        }
        return self::getModules()[$Module];
    }

    /**
     * Retorna a controller atual
     * @return Controller
     */
    static function getController()
    {
        return self::$controller;
    }

    /**
     *
     * @param string $controller
     * @return Controller
     */
    static function setController($controller)
    {
        self::$parans['controller'] = $controller;
        $controller = self::getModuleConfig()['path'] . "\\controllers\\{$controller}Controller";
        self::$parans[$controller] = $controller;
        self::$controller = $controller::instance();
        return self::$controller;
    }

    /**
     * Nome do controlador atual
     * @return string
     */
    static function getControllerName()
    {
        return self::$parans['controller'];
    }

    /**
     * Retorna a Action em execução
     * @return string
     */
    static function getAction()
    {
        return self::$action;
    }

    /**
     * Set um valor global
     * @param string|int $key
     * @param mixed $value
     * @return mixed Retorna o valor informado
     */
    public static function setGlobal($key, $value)
    {
        self::$globals[$key] = $value;
        return $value;
    }

    /**
     * Retorna o protocolo da página acessada
     * @return string
     */
    public static function getProtocol()
    {
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == "on") {
                return 'https';
            }
        }
        return 'http';
    }

    /**
     * Retorna um valor global
     * @param string|int $key
     * @param mixed $default Valor padrão a ser retornado caso o valor ainda não tenha sido definido
     * @return mixed
     */
    public static function getGlobal($key = null, $default = null)
    {
        return $key !== null ? (isset(self::$globals[$key]) ? self::$globals[$key] : $default) : self::$globals;
    }

}

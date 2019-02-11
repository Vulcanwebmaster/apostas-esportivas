<?php

use app\APP;

/**
 * header.location
 * @param string $url Default: URL principal
 */
function location($url = null)
{
    ob_get_clean();
    header('Location: ' . ($url ? $url : url()));
    exit;
}

/**
 * Retorna a URL atual
 * @return string
 */
function url_current()
{
    return url(@$_GET['GET_VARS']);
}

/**
 * HTTP_REFERER
 * @return string
 */
function url_referer()
{
    if (!empty($_SERVER['HTTP_REFERER'])) {

        $currentUri = APP::getProtocol() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $referer = $_SERVER['HTTP_REFERER'];

        if (strpos($referer, $_SERVER['HTTP_HOST']) !== false and $referer != $currentUri) {
            return $_SERVER['HTTP_REFERER'];
        }
    }
    return url();
}

/**
 * Retorna url formatada
 * @param string $controllerAction
 * @param array $vars
 * @param string $module
 * @param array $varsGet
 * @param boolean $secure
 * @return string
 */
function url($controllerAction = null, array $vars = null, $module = null, array $varsGet = null, $secure = false)
{

    # Base
    $url = base_url();

    if (is_int($module)) {
        $module = array_keys(APP::getModules())[$module];
    }

    # Módulo
    if ($module === null) {
        $module = APP::getCurrentModule();
    }

    # [controller, action]
    $ex = $controllerAction ? explode('/', $controllerAction) + ['index'] : [];

    # Bloqueando controller para o módulo
    if ($module != APP::getDefaultModule()) {
        $url .= '/' . $module;
    }

    # Controller/Action
    if ($controllerAction) {
        $url .= '/' . $controllerAction;
    }

    # Variaveis
    if ($vars) {
        foreach ($vars as $value) {
            $url .= '/' . url_paranformat($value);
        }
    }

    # Valores GET
    if ($varsGet) {
        $url .= '?' . http_build_query($varsGet);
    }

    # HTTPS
    if ($secure) {
        $url = str_replace(['http:', 'https:'], 'https:', $url);
    }

    return $url;
}

/**
 * Verifica se o parametro pode ser um controlador ou uma action
 * @param string $value
 * @return boolean
 */
function url_parse_controllerAction(&$value)
{
    if (!$value) {
        return false;
    } else {
        return preg_match('/^[a-z][a-z\_0-9]{1,30}$/i', (string)$value);
    }
}

/**
 * Formata o valor
 * @param string $Value
 * @return string
 */
function url_paranformat($Value)
{
    $format = array();
    $format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()-+={[}]/?;:.,\\\'<>°ºª';
    $format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
    $data = strtr(utf8_decode((string)$Value), utf8_decode($format['a']), $format['b']);
    $data = strip_tags(trim($data));
    $data = str_replace(' ', '-', $data);
    $data = preg_replace('/[\-]{2,}/ui', '-', $data);
    return strtolower(utf8_encode($data));
}

/**
 * Codifica uma array para url
 * @param array $values
 * @return string
 */
function url_encode(array $values)
{
    return http_build_query($values);
}

/**
 * Decodifca um string de valor e retorna um array
 * @param string $str
 * @return array
 */
function url_decode($str)
{
    parse_str($str, $output);
    return $output;
}

/**
 * Retorna os parâmetros da URL
 * @param string $key
 * @param mixed $default Retorno padrão caso o chave não exista
 * @return string
 */
function url_parans($key = null, $default = null)
{
    $parans = APP::getParans();
    if ($key !== null) {
        return isset($parans[$key]) ? $parans[$key] : $default;
    } else {
        return $parans;
    }
}

/**
 * Retorna a url base
 * @return string
 */
function base_url()
{
    return APP::getBaseUrl();
}

/**
 * Retorna o diretório da imagem
 * @param string $imageName
 * @return string
 */
function base_url_images($imageName = null)
{
    return base_url() . '/' . app_config()['upload']['imagens'] . '/' . $imageName;
}

/**
 * Retorna o diretório url do arquivo
 * @param string $filename
 * @return string
 */
function source($filename = '')
{
    return preg_replace('/\/$/', null, str_replace('\\', '/', base_url() . str_replace('//', '/', '/' . $filename)));
}

/**
 * Retorna o diretório url do arquivo na pasta de arquivo enviados
 * @param string $filename
 * @return string
 */
function source_files($filename = '')
{
    return source(app_config()['upload']['arquivos'] . '/' . $filename);
}

/**
 * Retorna o diretório url do arquivo na pasta de arquivo enviados
 * @param string $filename
 * @return string
 */
function source_images($filename = '')
{
    return source(app_config()['upload']['imagens'] . '/' . $filename);
}

/**
 * Retorna o diretório absoluto dos arquivos públicos
 * @param string $filename
 * @return string
 */
function abs_source($filename = null)
{
    return PATH . DIRECTORY_SEPARATOR . $filename;
}

/**
 * Retorna o diretório absoluto da pasta de arquivos
 * @param string $filename
 * @return string
 */
function abs_source_files($filename = null)
{
    $path = app_config('upload')['arquivos'];
    return abs_source("{$path}/{$filename}");
}

/**
 * Retorna o diretório absoluto de uma imagem
 * @param string $filename
 * @return string
 */
function abs_source_images($filename = null)
{
    $path = app_config('upload')['imagens'];
    return abs_source("{$path}/{$filename}");
}
    
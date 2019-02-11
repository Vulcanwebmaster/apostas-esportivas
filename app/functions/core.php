<?php

use app\APP;
use app\core\Controller;
use app\core\crud\Create;
use app\core\crud\Delete;
use app\core\crud\Read;
use app\core\crud\Update;
use app\core\Model;
use app\helpers\Date;
use app\helpers\Number;
use app\helpers\Seo;

function dd($data)
{
    if (count(func_get_args()) > 1) {
        foreach (func_get_args() as $data) {
            dd($data);
        }
    } else {
        echo '<pre>' . print_r($data, true) . '</pre>';
    }
}

/**
 * Retornar as configurações
 * @param mixed $key
 * @return mixed
 */
function app_config($key = null)
{
    $config = APP::getConfig();

    // Buscando chave
    if ($key) {
        return isset($config[$key]) ? $config[$key] : null;
    }

    return $config;
}


/**
 * Cria a pasta caso não exista
 * @param string $source
 * @param int $chmode
 */
function app_mkdir($source, $chmode = 0777)
{
    $source = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $source);

    if (preg_match('/\.[a-z0-9]{1,10}$/i', $source)) {
        $dir = dirname($source);
    } else {
        $dir = $source;
    }

    if (!file_exists($dir)) {
        mkdir($dir, $chmode, true);
        chmod($dir, $chmode);
    }

    return $source;
}

/**
 * Verifica o cache da página
 * @param string $key
 * @param int $minutes
 */
function cache_get($key, $minutes = 10)
{
    $path = ABSPATH . DIRECTORY_SEPARATOR . '_temp' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR;
    $file = hash('md5', $key) . '.tmp';
    $source = $path . $file;

    if (file_exists($source) and filemtime($source) > strtotime("-{$minutes}minutes")) {
        $content = file_get_contents($source);

        ob_end_clean();

        if (strpos($key, 'popstate/') === 0) {
            header('Content-type: application/json');
            exit($content);
        } else {
            exit($content);
        }

    } else {
        return null;
    }
}

/**
 * @param string $key
 * @param $content
 */
function cache_set($key, $content)
{
    $path = ABSPATH . DIRECTORY_SEPARATOR . '_temp' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR;
    $file = hash('md5', $key) . '.tmp';
    $source = $path . $file;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
        chmod($path, 0777);
    }
    file_put_contents($source, $content);
}

/**
 * Comprime saída html
 * @param $html
 * @return mixed
 */
function html_minify($html)
{
    $replaces = [
        "/\/\/ .*/" => null,
//	    "/<!--(.*)-->/Uis" => "\n",
//	    "/[[:blank:]]+/" => "\r",
        "/(\n|\t|\r)/" => null,
        "/[ ]{2,}/" => ' ',
        "/^[^<]+/" => '',
    ];
    $html = preg_replace(array_keys($replaces), array_values($replaces), $html);
    $html = str_replace('  ', ' ', $html);
    return $html;
}

/**
 * array_merge inteligente
 * @param array $initial
 * @param array $merge
 * @return array
 */
function extend(array $initial = null, array $merge = null)
{
    foreach ((array)$merge as $key => $value) {
        if (is_int($key)) {
            $initial[] = $value;
        } else if (is_array($value) and isset($initial[$key])) {
            $initial[$key] = extend($initial[$key], $value);
        } else {
            $initial[$key] = $value;
        }
    }
    $args = func_get_args();
    if (count($args)) {
        for ($i = 2; $i < count($args); $i++) {
            $initial = extend($initial, $args[$i]);
        }
    }
    return $initial;
}

/**
 * @param string|null $key
 * @param null $value
 * @return array
 */
function view_vars(string $key = null, $value = null)
{
    static $vars = [];
    if ($key) {
        $vars[$key] = $value;
    }
    return $vars;
}

/**
 *
 * @param string $file
 * @param array $vars
 * @param boolean $return
 * @param string $module
 * @param boolean $autoExtractHeaders
 * @return string
 */
function view_load(string $file, array $vars = null, bool $return = false, bool $autoExtractHeaders = true)
{

    $source = ABSPATH . "/app/views/{$file}.phtml";

    # Arquivo inexistente
    if (!file_exists($source)) {
        throw new Exception("View `{$file}` não existe.");
    }

    # Retornando HTML
    if ($return) {

        ob_start();
        file_include($source, $vars);
        $Body = ob_get_clean();

        if ($autoExtractHeaders) {
            # Script
            preg_match_all('/<script.*?<\/script>/is', $Body, $result);
            foreach ($result[0] as $html) {
                Seo::addJs($html);
            }

            # Style
            preg_match_all('/<style.*?<\/style>/is', $Body, $result);
            foreach ($result[0] as $html) {
                Seo::addCss($html);
            }

            return preg_replace(['/<style.*?<\/style>/is', '/<script.*?<\/script>/is'], null, $Body);
        } else {
            return $Body;
        }
    } else {
        file_include($source, $vars);
    }
}

/**
 * Inclui arquivo passando variavéis
 * @param string $file
 * @param array $Variables
 */
function file_include($_include_file, array $_include_vars = null)
{
    # Extraindo valores
    if ($_include_vars) {
        extract($_include_vars);
    }

    # Incluindo arquivo
    if (file_exists($_include_file = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $_include_file))) {
        if (strpos($_include_file, '.class.php') !== false) {
            include_once $_include_file;
        } else {
            include $_include_file;
        }
    } # Arquivo não encontrado.
    else {
        throw new Exception('Arquivo inexistente.');
    }
}

/**
 *
 * @param string $Module
 * @return string
 */
function get_modules($Module = null)
{
    return APP::getModules($Module);
}

/**
 * Verifica se o Modulo atual é o Modulo padrão
 * @param string $Module
 * @return boolean
 */
function is_default_module($Module = null)
{
    return ($Module === null ? get_current_module() : $Module) == get_default_module();
}

/**
 * Retorna o modulo atual
 * @return string
 */
function get_current_module()
{
    return APP::getCurrentModule();
}

/**
 * Retorna o modulo padrão
 * @return string
 */
function get_default_module()
{
    return APP::getDefaultModule();
}

/**
 * Retorna todas as pasta para o include
 * @return array
 */
function get_all_paths()
{
    # Pastas do sistema
    return [
        # System
        '_app',
        '_general',
        '_modules',
    ];
}

/**
 * Criptografa
 * @param string $senha
 * @return string
 */
function password($senha)
{
    return hash('sha512', $senha);
}

define('PASSWORD_LENG', 128);

/**
 * Transforma uma string em um array
 * @param string $String
 * @return array
 */
function stringToArray($String)
{
    if (is_array($String)) {
        return $String;
    } else if (empty($String)) {
        return [];
    } else if (preg_match('/^[0-9a-zA-Z_\-]+\=/', $String)) {
        parse_str($String, $values);
        return $values;
    } else if (preg_match('/^\[".*?"/', $String) and preg_match_all('/"(.*?)"/', $String, $matches)) {
        return $matches[1];
    } else if (preg_match_all('/\[([^\[\]]+?)\]/', $String, $busca)) {
        return $busca[1];
    } else if ($result = json_decode($String)) {
        return $result;
    } else if (strpos($String, ',') !== false) {
        return explode(',', $String);
    } else {
        return [$String];
    }
}

/**
 * Converte um array para um string
 * EX: [value1][value2]
 * @param array $Array
 * @return string
 */
function arrayToString($Array)
{

    if (is_string($Array)) {
        if (preg_match('/^\[".*?"/', $Array) and preg_match_all('/"(.*?)"/', $Array, $matches)) {
            return arrayToString(array_values($matches[1]));
        }
        return $Array;
    } else if (empty($Array)) {
        return '';
    } else if (is_array($Array)) {
        // Não possuí só números
        foreach ($Array as $value) {
            if (preg_match('/[\[\]]/', $value)) {
                return json_encode($Array);
                break;
            }
        }
        // Somente números
        return '[' . implode('][', $Array) . ']';
    }
}

/**
 *
 * @param int|array $Total
 * @param int $Page
 * @param int $Forpage
 * @param string $Link
 * @return array [array, total, paginas, pagination]
 */
function pagination($Total, $Page = 1, $Forpage = 30, $Link = null, $VisiblePages = 11)
{

    if ($VisiblePages % 2 == 0) {
        $VisiblePages--;
    }

    $Paginas = max(1, Number::ceil((is_array($Total) ? count($Total) : $Total) / $Forpage));
    $Page = max(1, min($Page, $Paginas));

    $html = '<nav>';
    if ($Paginas > 1) {
        $html .= '<ul class="pagination" >';

        $min = max(1, $Page - ($VisiblePages - 1) * 0.5);
        $max = min($Paginas, $Page >= (($VisiblePages - 1) * 0.5 + 1) ? $Page + (($VisiblePages - 1) * 0.5) : $Page + 11 - $Page);
        if ($max == $Paginas) {
            $min = max(1, $Page - $VisiblePages - 1 + ($Paginas - $Page));
        }

        # Ir para a primeira página
        if ($min > 1) {
            $html .= '<li><a data-page="1" href="' . str_replace('#page#', 1, $Link ? $Link : '#') . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        # Páginas
        for ($i = $min; $i <= $max; $i++) {
            $html .= '<li class="' . ($Page == $i ? 'active' : null) . '" ><a data-page="' . $i . '" href="' . str_replace('#page#', $i, $Link ? $Link : '#') . '" >' . $i . '</a></li>';
        }

        # Ir para a última página
        if ($max < $Paginas) {
            $html .= '<li><a href="' . str_replace('#page#', $Paginas, $Link ? $Link : '#') . '" data-page="' . $Paginas . '" aria-label="Next" ><span aria-hidden="true">&raquo;</span></a></li>';
        }

        $html .= '</ul>';
    }
    $html .= '</nav>';


    return [
        'array' => is_array($Total) ? array_slice($Total, ($Page - 1) * $Forpage, $Forpage) : [],
        'total' => is_array($Total) ? count($Total) : $Total,
        'pagina' => $Page,
        'paginas' => $Paginas,
        'pagination' => $html,
        'limit' => 'LIMIT ' . $Forpage . ' OFFSET ' . (($Page - 1) * $Forpage),
    ];
}

/**
 *
 * @param object $method
 * @param string $obj
 * @param mixed $parameter
 * @return string
 */
function call_method($method, $obj, $parameter = null)
{
    return call_user_func([$obj, $method], $parameter);
}

/**
 *
 * @param string $ModelName
 * @return Model
 */
function newModel($ModelName)
{
    return APP::getInstanceModel(ucfirst($ModelName));
}

/**
 *
 * @param string $ControllerName
 * @return Controller
 */
function newController($ControllerName)
{
    return APP::getInstanceController($ControllerName);
}

/**
 * Preenche com zeros a esquerda
 * @param int $int
 * @param int $length
 * @return string
 */
function zerofill($int, $length = 11)
{
    return str_pad((string)$int, $length, '0', 0);
}

/**
 * Corta uma string levando em connta a separação de palavras.
 * @param string $string
 * @param int $length
 * @return string
 */
function substr_words($string, $length = 250)
{
    if (strlen($string) > $length) {
        return substr($string, 0, strrpos(substr($string, 0, 100), ' '));
    } else {
        return $string;
    }
}

/**
 *
 * @param int $nascimento
 * @param int $dataReferencia
 * @return int
 */
function calc_idade($nascimento, $dataReferencia = __NOW__)
{

    $nascimento = !($nascimento = Date::data($nascimento)) ? date('Y-m-d') : $nascimento;
    $dataReferencia = !($dataReferencia = Date::data($dataReferencia)) ? date('Y-m-d') : $dataReferencia;

    $idade = (int)Date::year($dataReferencia) - (int)Date::year($nascimento);
    if (date('md', strtotime($dataReferencia)) < date('md', strtotime($nascimento))) {
        $idade--;
    }

    return $idade;
}

/**
 *
 * @param string $url
 * @param array $values
 * @return string
 */
function curl_get($url, array $values = null)
{

    $ch = curl_init($url);

    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => (array)$values,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_AUTOREFERER => true,
    ));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * Executa um pesquisa na base de dados e retorna os registros encontrados
 * @param string $query
 * @param array $values
 * @return array[]
 */
function sql_select($query, array $values = null)
{
    return (new Read)->FullRead($query, $values)->getResult();
}

/**
 * Insere registros a base de dados
 * @param string $table
 * @param array $dados
 * @return int|false
 */
function sql_insert($table, array $dados)
{
    return (new Create)->ExeCreate($table, $dados)->getResult();
}

/**
 * Deleta registros da base de dados
 * @param string $table
 * @param string $termos
 * @param array $dados
 * @return boolean
 */
function sql_delete($table, $termos = null, array $dados = null)
{
    return (new Delete)->ExeDelete($table, $termos, $dados)->getResult();
}

/**
 * Atualiza registros da base de dados
 * @param string $table
 * @param array $dados
 * @param string $termos
 * @param array $places
 * @return boolean
 */
function sql_update($table, array $dados, $termos = null, array $places = null)
{
    return (new Update)->ExeUpdate($table, $dados, $termos, $places)->getResult();
}

/**
 * @param string|array $values
 * @param int $result
 */
function json($values, $result = 0)
{
    ob_end_clean();

    if (is_array($values)) {
        $values += ['result' => $result];
    } else if (is_string($values)) {
        $values = [
            'message' => $values,
            'result' => $result,
        ];
    } else {
        throw new Exception('O parâmetro deve ser um array ou string');
    }

    header('Content-type: text/json; charset=UTF-8');

    exit(json_encode($values));
}
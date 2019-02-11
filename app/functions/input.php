<?php

if (filter_input(INPUT_POST, 'ajax_serialize')) {
    $_POST = json_decode(filter_input(INPUT_POST, 'ajax_serialize'), true) ?: [];
} else if (empty($_POST) and $input = file_get_contents('php://input')) {
    $post = json_decode($input, true) ?: [];
    if ($post) {
        $_POST = $post;
    }
}

/**
 * Verifica se a variavél está vazia
 * @param mixed $value
 * @return bool
 */
function is_empty($value)
{
    if (is_string($value)) {
        $value = trim($value);
    }
    return (empty($value) or $value == '0000-00-00' or $value == '00/00/0000' or $value == '00:00:00') ? true : false;
}

/**
 * Retorna o valor de um $_POST ou a array $_POST caso o primeiro parametro seja nulo
 * @param string $var_name
 * @param string $filtro
 * @param array $options
 * @return mixed
 */
function inputPost($var_name = null, $filtro = null, $options = null)
{
    return _filter_input(INPUT_POST, $var_name, $filtro, $options);
}

/**
 * Retorna o valor de um $_GET ou a array $_GET caso o primeiro parametro seja nulo
 * @param string $var_name
 * @param string $filtro
 * @param array $options
 * @return mixed
 */
function inputGet($var_name = null, $filtro = null, $options = null)
{
    return _filter_input(INPUT_GET, $var_name, $filtro, $options);
}

/**
 * Retorna o valor de um $_SERVER ou a array $_SERVER caso o primeiro parametro seja nulo
 * @param string $var_name
 * @param string $filtro
 * @param array $options
 * @return mixed
 */
function inputServer($var_name = null, $filtro = null, $options = null)
{
    return _filter_input(INPUT_SERVER, $var_name, $filtro, $options);
}

/**
 *
 * @param int $type
 * @param string $variable_name
 * @param string|int $filter
 * @param array $options
 */
function _filter_input($type, $variable_name = null, $filter = null, $options = null)
{

    $var = [];

    switch ($type) {
        case INPUT_POST:
            $var = $_POST ?: [];
            break;
        case INPUT_GET:
            $var = $_GET ?: [];
            break;
        case INPUT_SERVER:
            $var = $_SERVER ?: [];
            break;
        default:
            $var = [];
    }

    if ($variable_name !== null) {
        $value = $var[$variable_name] ?? null;
    } else {
        $value = $var;
    }

    if ($filter) {
        return filter_var($value, $filter, $options);
    } else {
        return $value;
    }

}

/**
 * Verifica se a variavel está vazia
 *
 * Contorna as especificações de empty() para 0 e '0'
 * Adicionado verificações para o formato data '0000-00-00' e '00/00/0000'
 *
 * @param mixed $var
 * @return boolean
 */
function isEmpty($var)
{
    # Exceções para empty
    if (empty($var)) {
        if ($var !== 0 and $var !== '0') {
            return true;
        }
    } # Data
    else if (\app\helpers\Date::isDate($var)) {
        $value = \app\helpers\Date::data($var);
        if ($value == '0000-00-00' or $value === null) {
            return true;
        }
    }
    return false;
}
    
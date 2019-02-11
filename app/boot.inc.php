<?php

ob_start();

date_default_timezone_set('America/Sao_Paulo');

/** Microtime ao iniciar aplicação */
define('EXECUTION_START', microtime(true));

define("PATH", dirname(getenv('SCRIPT_FILENAME')));

/** Form[enctype=multipart/form-data] */
define('FORM_ENCTYPE', 'multipart/form-data');

/** Timestamp */
define('__NOW__', date('Y-m-d H:i:s'));

/** CHARSET da página */
define('CHARSET', 'UTF-8');

define('LANG', 'pt_BR');

/** Raiz dos arquivos da aplicação */
define('ABSPATH', dirname(__DIR__));

/** @var boolean Verifica se a conexão é AJAX */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
view_vars('isAjax', IS_AJAX);

/** @var boolean Verifica se a valores $_POST */
define('IS_POST', getenv('REQUEST_METHOD') == 'POST');
define('IS_GET', getenv('REQUEST_METHOD') == 'GET');
define('IS_PUT', getenv('REQUEST_METHOD') == 'PUT');
define('IS_DELETE', getenv('REQUEST_METHOD') == 'DELETE');
define('IS_PATCH', getenv('REQUEST_METHOD') == 'PATCH');
define('IS_OPTIONS', getenv('REQUEST_METHOD') == 'OPTIONS');

view_vars('isPost', IS_POST);

/** Verifica se está trabalhando em localhost */
define('IS_LOCAL', $_SERVER['SERVER_NAME'] == 'localhost' ? true : false);
view_vars('isLocal', IS_LOCAL);

/** Verifica se está trabalhando em servidor externo */
define('IS_EXTERNAL', !IS_LOCAL);

header("Content-Type: text/html; charset=" . CHARSET, true);

error_reporting(E_ALL);

ini_set("display_errors", IS_LOCAL);
ini_set('log_errors', 1);
ini_set('post_max_size', '300M');
ini_set('upload_max_filesize', '300M');
ini_set('error_log', ABSPATH . '/error.log');

/** ZLib */
ini_set('zlib.output_compression', 'On');
ini_set('zlib.output_compression_level', '1');
ini_set("zlib.output_compression", 4096);

/** Unidades de medidas  */
define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

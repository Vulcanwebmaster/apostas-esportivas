<?php

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/app/boot.inc.php';

\app\helpers\Cache::setDirectory(__DIR__ . DIRECTORY_SEPARATOR . '_temp' . DIRECTORY_SEPARATOR . 'cache');
\app\helpers\Session::setDirectory(__DIR__ . DIRECTORY_SEPARATOR . '_temp' . DIRECTORY_SEPARATOR . 'session');

$config = [
    'config' => [
        'title' => 'Apostas Online LW',
        'dominio' => 'www.33bets.net',
        'email' => 'suporte@apostasonlinelw.com.br',
        'uri' => 'http://www.33bets.net/',
        'redes' => [
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
        ],
        'upload' => [
            'imagens' => 'imagens',
            'arquivos' => 'arquivos',
        ]
    ],
];

$config['modules'] = [
    'site2' => ['path' => 'app\\modules\\website', 'class' => \app\modules\website\Site::class],
    'site' => ['path' => 'app\\modules\\website', 'class' => \app\modules\website\Site::class],
    'entrar' => ['path' => 'app\\modules\\auth', 'class' => \app\modules\auth\Auth::class],
    'cron' => ['path' => 'app\\modules\\cron', 'class' => \app\modules\cron\Cron::class],
    'localizacao' => ['path' => 'app\\modules\\localizacao'],
    'admin' => ['path' => 'app\\modules\\admin', 'class' => \app\modules\admin\Admin::class],
    'cdn' => ['path' => 'app\\modules\\cdn'],
    'notificacoes' => ['path' => 'app\\modules\\notificacoes'],
    'api' => ['path' => 'app\\modules\\api', 'class' => \app\modules\api\API::class],
];

$config['db'] = [
    'production' => [
        'host' => 'localhost',
        'username' => 'bets01_site',
        'password' => 'SLKu1p128.h2198',
        'database' => 'bets01_site',
    ],
    'localhost' => [
        'host' => 'localhost',
        'username' => 'bets01_site',
        'password' => 'SLKu1p128.h2198',
        'database' => 'bets01_site',
    ]
];

// Domínio da aplicação
$domain = str_replace('www.', null, getenv('SERVER_NAME'));

// Configurações por domínio
if (!IS_LOCAL) {
    switch ($domain) {
        default:
            $config['config']['uri'] = 'http://www.33bets.net';
            $config['db']['production']['database'] = 'bets01_site';
            $config['config']['upload'] = [
                'imagens' => 'imagens',
                'arquivos' => 'arquivos',
            ];
    }
}

\app\helpers\Seo::setFavicon('favicon.ico');

// Criando pasta de imagens
if (!file_exists($config['config']['upload']['imagens'])) {
    mkdir($config['config']['upload']['imagens'], 0777, true);
    mkdir($config['config']['upload']['arquivos'], 0777, true);
    copy('imagens/default.jpg', $config['config']['upload']['imagens'] . '/default.jpg');
}

\app\core\crud\Conn::setConfig($config['db'][IS_LOCAL ? 'localhost' : 'production']);
\app\APP::setModules($config['modules']);
\app\APP::setConfig($config['config']);

return $config;
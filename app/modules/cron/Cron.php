<?php

namespace app\modules\cron;

use app\core\crud\Conn;
use app\modules\admin\Admin;

class Cron
{

    public function __construct()
    {
        $ip = getUserIP();
//        if (!IS_LOCAL and strpos($ip, '167.114.189.195') === false and !Admin::isDeveloper()) {
//            $msg = 'CRON: O cron só deve ser executado pelo servidor (' . $ip . ')';
//            error_log($msg);
//            exit($msg);
//        }
    }

}
    
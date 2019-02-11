<?php

namespace app\models;

use app\core\Model;
use app\vo\SmtpVO;

class SmtpModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_smtp_config';
        $this->valueObject = SmtpVO::class;
    }

    /** @return SmtpVO */
    public static function getConfig()
    {
        return self::lista('LIMIT 1')[0];
    }

}
    
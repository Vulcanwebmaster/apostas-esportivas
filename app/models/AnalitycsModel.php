<?php

namespace app\models;

use app\core\Model;
use app\core\ValueObject;
use app\vo\AnalitycVO;
use Browser;

class AnalitycsModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_analitycs';
        $this->valueObject = AnalitycVO::class;
    }

    public static function add(ValueObject $vo, $ref)
    {
        $browser = new Browser;

        $r = self::newValueObject([
            'data' => date('Y-m-d'),
            'hora' => date('H:i:s'),
            'tabela' => $vo->getTable(),
            'ref' => $ref,
            'refid' => $vo->getId(),
            'ip' => getUserIP(),
            'useragent' => $browser->getUserAgent(),
            'navegador' => $browser->getBrowser(),
            'plataforma' => $browser->getPlatform(),
        ]);

        return $r;
    }

}
    
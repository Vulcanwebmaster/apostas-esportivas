<?php

namespace app\models;

use app\core\Model;
use app\vo\ImpressoraVO;

class ImpressorasModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_impressoras';
        $this->valueObject = ImpressoraVO::class;
    }

    /**
     * Reorganiza a ordem
     * @return boolean
     */
    public static function organizar()
    {
        foreach (self::lista('WHERE a.status != 99 ORDER BY a.ordem ASC') as $i => $v) {
            $v->Save(['ordem' => ($i + 1) * 5]);
        }
    }

    /**
     *
     * @return string
     */
    public static function options()
    {
        $html = '';
        foreach (self::lista('WHERE a.status = 1 ORDER BY a.ordem ASC') as $v) {
            $html .= formOption($v->getTitle(), $v->getId());
        }
        return $html;
    }

}
    
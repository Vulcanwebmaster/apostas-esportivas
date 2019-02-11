<?php
/**
 * Created by PhpStorm.
 * User: Xolenno
 */

namespace app\traits\vo;


use app\helpers\Mask;
use app\helpers\VALIDAR;

trait cnpj
{

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     * @return $this
     */
    public function setCnpj($cnpj)
    {
        if ($cnpj) {
            VALIDAR::cnpj($cnpj);
            $cnpj = Mask::cnpj($cnpj);
        }

        $this->cnpj = $cnpj;
        return $this;
    }


}
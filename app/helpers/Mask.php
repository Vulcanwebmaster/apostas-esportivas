<?php

namespace app\helpers;

use Exception;

final class Mask
{

    /**
     * Lenght: 14
     * Formato: 99.999.999/9999-99
     * @param string $cnpj
     * @return string
     */
    public static function cnpj($cnpj)
    {
        try {
            VALIDAR::cnpj($cnpj);
            $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
            return preg_replace('/^([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})$/', '$1.$2.$3/$4-$5', $cnpj);
        } catch (Exception $ex) {
            return null;
        }
    }

    /**
     * Lenght: 11
     * Formato: 999.999.999-99
     * @param string $cpf
     * @return string|null
     */
    public static function cpf($cpf)
    {
        try {
            VALIDAR::cpf($cpf);
            $cpf = preg_replace('/[^0-9]/', '', $cpf);
            return preg_replace('/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/', '$1.$2.$3-$4', $cpf);
        } catch (Exception $ex) {
            return null;
        }
    }

    /**
     * Telefone: (99) 9999-9999
     * Celular: (99) 99999-9999
     * 0800: 0800 9999999
     * @param string $telefone
     * @param int|string $telefone ex: 27
     * @param boolean $returnNull
     * @return string
     */
    public static function telefone($telefone, $ddd = 27, $returnNull = true)
    {
        $telefone = preg_replace('/[^0-9]/', null, $telefone);
        $telefone = preg_replace('/^\+?(55)/', null, $telefone);
        $len = strlen($telefone);

        if (($len == 8 or $len == 9) and $ddd) {
            return self::telefone(str_pad((string)$ddd, 2, '0', 0) . $telefone, null);
        } # Telefone/Celular
        else if ($len == 10 or $len == 11) {
            return preg_replace('/([0-9]{2})([0-9]{4,5})([0-9]{4})/', '($1) $2-$3', $telefone);
        } # 0800
        else if (preg_match('/^0800[0-9]{6,7}/', $telefone)) {
            return preg_replace('/^([0-9]{4})([0-9]*)$/', '$1-$2', $telefone);
        } # Formato inválido
        else {
            return $returnNull ? null : $telefone;
        }
    }

    /**
     * Lenght: 8
     * Formato: 99999-999
     * @param string $cep
     * @param boolean $remove
     * @return string
     */
    public static function cep($cep, $remove = false)
    {
        try {
            VALIDAR::cep($cep);
            $cep = preg_replace('/[^0-9]/', '', $cep);
            return preg_replace('/([0-9]{5})([0-9]{3})/', '$1-$2', $cep);
        } catch (Exception $ex) {
            return null;
        }
    }

}
    
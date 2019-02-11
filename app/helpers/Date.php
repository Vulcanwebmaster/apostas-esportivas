<?php

namespace app\helpers;

class Date
{

    private static $MONTHS = array(0, 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    private static $_DAYS = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

    /**
     * Retorna o nome do dia da semana
     * @param int $dia 1 - 7
     * @return string
     */
    public static function getDayName($dia)
    {
        return !empty(self::$_DAYS[$dia]) ? self::$_DAYS[$dia] : null;
    }

    /**
     * Verifica se é uma data válida
     * @param string $Date
     * @return boolean
     */
    public static function isDate($Date = null)
    {
        $Date = Date::data($Date);
        return ($Date and $Date != '0000-00-00') ? true : false;
    }

    /**
     * Extrai a data de uma string
     * @param string $value
     * @return string Formato data yyyy-mm-dd
     */
    public static function data($value)
    {
        if (!is_string($value)) {
            return null;
        }
        $dia = '([0][1-9]|[1-2][0-9]|[3][0-1])';
        $month = '([0][0-9]|[1][0-2])';
        $ano = '([0-9]{4})';
        $separator = '[\/\\\-]';
        preg_match("/([^0-9]|^){$dia}{$separator}{$month}{$separator}{$ano}([^0-9]|$)/", $value, $r);
        if (!empty($r)) {
            $vData = "{$r[4]}-{$r[3]}-{$r[2]}";
            return date('Y-m-d', strtotime($vData)) == $vData ? $vData : null;
        }
        preg_match("/{$ano}{$separator}{$month}{$separator}{$dia}/", $value, $r);
        if (!empty($r)) {
            $vData = "{$r[1]}-{$r[2]}-{$r[3]}";
            return date('Y-m-d', strtotime($vData)) == $vData ? $vData : null;
        }
        preg_match("/([^0-9]|^){$dia}{$month}{$ano}([^0-9]|$)/", $value, $r);
        if (!empty($r)) {
            $vData = "{$r[4]}-{$r[3]}-{$r[2]}";
            return date('Y-m-d', strtotime($vData)) == $vData ? $vData : null;
        }
        return null;
    }

    /**
     * Retorna o nome do mês
     * @param string $month
     * @return string
     */
    public static function getMonthName($month = 0)
    {
        $month = self::getMonth($month);
        if ($month == 0 or !isset(self::$MONTHS[(int)$month])) {
            return self::$MONTHS[(int)date('m')];
        } else if (isset(self::$MONTHS[(int)$month])) {
            return self::$MONTHS[(int)$month];
        } else {
            return null;
        }
    }

    /**
     * Retorna o mês extraindo de uma data ou verificando se está entre 1 e 12
     * @param string|int $month
     * @return int
     */
    public static function getMonth($month = 0)
    {
        if (is_int($month) and $month > 0 and $month <= 12) {
            return $month;
        }
        if (is_string($month)) {
            $month = trim($month);
            if (preg_match('/^([0][0-9]|[1][0-2])$/', $month)) {
                return (int)$month;
            } else if (strlen($month) == 10 and preg_match('/^[0-9]{4}\-([0][0-9]|[1][0-2])\-[0-9]{2}$/', $month, $mes)) {
                return (int)$mes[1];
            } else if ($data = self::data($month)) {
                return self::getMonth($data);
            }
        }
        return (int)date('m');
    }

    /**
     * Formata a data e hora para padrão brasileiro
     * @param string $value
     * @return string Formato dd/mm/yyyy hh:ii:ss
     */
    public static function datahora($value)
    {
        return self::formatDataTime($value);
    }

    /**
     * Formata a data e hora para padrão brasileiro
     * @param string $value
     * @return string Formato dd/mm/yyyy hh:ii:ss
     */
    public static function formatDataTime($value)
    {
        $timestamp = self::datatime($value);
        return $timestamp == '0000-00-00 00:00:00' ? null : preg_replace('/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/', '$3/$2/$1', $timestamp);
    }

    /**
     * Extrai a datatime de uma string
     * @param string $timestamp
     * @return string Formatada em time stamp yyyy-mm-dd hh:ii:ss
     */
    public static function datatime($value)
    {
        return self::timestamp($value);
    }

    /**
     * Extrai a timestamp de uma string
     * @param string $timestamp
     * @return string Formatada em time stamp yyyy-mm-dd hh:ii:ss
     */
    public static function timestamp($value)
    {
        $data = self::data($value);
        $hora = self::time($value);
        return $data ? $data . ' ' . $hora : null;
    }

    /**
     * Extrai a hora de uma string.
     * @param string $value
     * @return string Fomato time hh:ii:ss
     */
    public static function time($value)
    {
        $hora = '([0-1][0-9]|[2][0-4])';
        $minuto = '([0-5][0-9])';
        $segundos = '([0-5][0-9])';
        $separator = '[\:]';
        preg_match("/([^0-9]|^){$hora}{$separator}{$minuto}{$separator}{$segundos}([^0-9]|$)/", $value, $r);
        if (!empty($r)) {
            return preg_replace('/^24/', '00', "{$r[2]}:{$r[3]}:{$r[4]}");
        }
        preg_match("/{$hora}{$separator}{$minuto}/", $value, $r);
        if (!empty($r)) {
            return preg_replace('/^24/', '00', "{$r[1]}:{$r[2]}:00");
        }
        preg_match("/([^0-9]|^){$hora}{$minuto}{$segundos}([^0-9]|$)/", $value, $r);
        if (!empty($r)) {
            return preg_replace('/^24/', '00', "{$r[2]}:{$r[3]}:{$r[4]}");
        }
        return "00:00:00";
    }

    /**
     * Formata uma data para padrão brasileiro
     * @param string $value
     * @return string Formato dd/mm/yyyy
     */
    public static function formatData($value)
    {
        return preg_replace('/^.*([0-9]{4})\-([0-9]{2})\-([0-9]{2}).*$/', '$3/$2/$1', self::data($value));
    }

    /**
     * Retorna o ano.
     * @param string $value
     * @return int
     */
    public static function year($value)
    {
        return (int)preg_replace('/^([0-9]{4}).*/', '$1', self::data($value));
    }

    /**
     * Retorna o mês
     * @param int $value
     * @return int
     */
    public static function month($value)
    {
        return preg_replace('/^[0-9]{4}\-([0-9]{2}).*/', '$1', self::data($value));
    }

    /**
     * Retorna o dia
     * @param string $value
     * @return int
     */
    public static function day($value)
    {
        return preg_replace('/^[0-9]{4}\-[0-9]{2}\-([0-9]{2}).*/', '$1', self::data($value));
    }

}
    
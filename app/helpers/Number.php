<?php

namespace app\helpers;

class Number
{

    /**
     * Retorna um numero inteiro positivo
     * @param float|int $value
     * @return int
     */
    public static function abs($value)
    {
        return abs(self::int($value));
    }

    /**
     * Retorna o numero inteiro.
     * @return string|int|float
     */
    public static function int($value)
    {
        return intval(self::_floatFormat($value));
    }

    /**
     * Extrai o número de uma string.
     * @param string|int|float $value
     * @return float
     */
    private static function _floatFormat($value)
    {
        $value = preg_replace('/[^0-9\.\,\-\+]/', '', (string)$value);
        if (preg_match('/([,\.])[0-9]+([\.\,])[0-9]+$/', $value, $separators) and $separators[1] != $separators[2]) {
            $value = str_replace(array($separators[1], $separators[2]), array('', '.'), $value);
        } else if (!empty($separators)) {
            $value = str_replace($separators[1], '', $value);
        } else {
            $value = str_replace(',', '.', $value);
        }
        return (float)$value;
    }

    /**
     * Divide o valor por 100.
     * @param string|int|float $value
     * @return float
     */
    public static function percentage($value)
    {
        return self::_floatFormat($value) / 100;
    }

    /**
     * Retorna o número formatado em moeda.
     * @param string|int|float $value
     * @return string
     */
    public static function real($value)
    {
        return number_format(self::_floatFormat($value), 2, ',', '.');
    }

    public static function realExtenso($valor = 0, $maiusculas = false)
    {
        $valor = Number::float($valor, 2);

        # verifica se tem virgula decimal
        if (strpos($valor, ",") > 0) {
            # retira o ponto de milhar, se tiver
            $valor = str_replace(".", "", $valor);
            # troca a virgula decimal por ponto decimal
            $valor = str_replace(",", ".", $valor);
        }
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        $cont = count($inteiro);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < $cont; $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                    $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000") {
                $z++;
            } elseif ($z > 0) {
                $z--;
            }
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) {
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            }
            if ($r) {
                $rt = @$rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
            }
        }

        if (!$maiusculas) {
            return trim($rt ? $rt : "zero");
        } elseif ($maiusculas == "2") {
            return trim(strtoupper($rt) ? strtoupper($rt) : "Zero");
        } else {
            return trim(ucwords($rt) ? ucwords($rt) : "Zero");
        }
    }

    /**
     * Retorna o valor em float.
     * @param string|int|float $value
     * @param int $fixed
     * @return float
     */
    public static function float($value, $fixed = 0)
    {
        $value = self::_floatFormat($value);
        if ($fixed > 0) {
            $value = (float)number_format($value, $fixed, '.', '');
        }
        return $value;
    }

    /**
     * Retorna o numero arredondado ex: ( round(5.5) = 6, round(5.4) = 5, round(5.6) = 6 ).
     * @return string|int|float
     */
    public static function round($value)
    {
        return round(self::_floatFormat($value));
    }

    /**
     * Retorna o número arredondado para menos
     * @param int|string|float $value
     * @return int
     */
    public static function floor($value)
    {
        return floor(self::_floatFormat($value));
    }

    /**
     * Retorna o numero arredondado para mais.
     * @param string|int|float $value
     * @return int
     */
    public static function ceil($value)
    {
        return ceil(self::_floatFormat($value));
    }

}
    
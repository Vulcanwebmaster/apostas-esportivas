<?PHP

namespace app\helpers;

class STR
{

    public static $path = "";

    //Remove caracteres especiais
    public static function rm_specials($palavra)
    {
        $palavranova = self::acentos($palavra);
        $palavranova = str_replace(" ", "_", $palavranova);
        $palavranova = str_replace(array("'", '"', ','), "", $palavranova);
        return strval($palavra);
    }

    public static function acentos($string)
    {
        return self::rmAcentosIso(self::rmAcentos($string));
    }

    public static function rmAcentosIso($string)
    {
        $acentos = self::decodeArray(explode("/", "Š/Œ/Ž/š/œ/ž/Ÿ/¥/µ/À/Á/Â/Ã/Ä/Å/Æ/Ç/È/É/Ê/Ë/Ì/Í/Î/Ï/Ð/Ñ/Ò/Ó/Ô/Õ/Ö/Ø/Ù/Ú/Û/Ü/Ý/ß/à/á/â/ã/ä/å/æ/ç/è/é/ê/ë/ì/í/î/ï/ð/ñ/ò/ó/ô/õ/ö/ø/ù/ú/û/ü/ý/ÿ"));
        $semAcentos = explode("/", "S/O/Z/s/o/z/Y/Y/u/A/A/A/A/A/A/A/C/E/E/E/E/I/I/I/I/D/N/O/O/O/O/O/O/U/U/U/U/Y/s/a/a/a/a/a/a/a/c/e/e/e/e/i/i/i/i/o/n/o/o/o/o/o/o/u/u/u/u/y/y");
        return str_replace($acentos, $semAcentos, $string);
    }

    public static function decodeArray($array)
    {
        $value = array();
        $keys = array_keys($array);
        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            $value[$key] = self::decode(strval($array[$key]));
        }
        return $value;
    }

    public static function decode($string)
    {
        $value = $string;
        //$value = htmlspecialchars($string,ENT_QUOTES,'iso-8859-1');
        $to_encoding = "ISO-8859-1";
        $from_encoding = self::codificacao($string);
        return str_replace('&nbsp;', ' ', mb_convert_encoding($value, $to_encoding, $from_encoding));
    }

    public static function codificacao($string)
    {
        return mb_detect_encoding($string . 'x', 'UTF-8, ISO-8859-1');
    }

    public static function rmAcentos($string)
    {
        $acentos = "Š/Œ/Ž/š/œ/ž/Ÿ/¥/µ/À/Á/Â/Ã/Ä/Å/Æ/Ç/È/É/Ê/Ë/Ì/Í/Î/Ï/Ð/Ñ/Ò/Ó/Ô/Õ/Ö/Ø/Ù/Ú/Û/Ü/Ý/ß/à/á/â/ã/ä/å/æ/ç/è/é/ê/ë/ì/í/î/ï/ð/ñ/ò/ó/ô/õ/ö/ø/ù/ú/û/ü/ý/ÿ";
        $semAcento = "S/O/Z/s/o/z/Y/Y/u/A/A/A/A/A/A/A/C/E/E/E/E/I/I/I/I/D/N/O/O/O/O/O/O/U/U/U/U/Y/s/a/a/a/a/a/a/a/c/e/e/e/e/i/i/i/i/o/n/o/o/o/o/o/o/u/u/u/u/y/y";
        $replace = array_combine(explode('/', $acentos), explode('/', $semAcento));
        return strtr($string, $replace);
    }

    public static function arquivo($arquivo_name)
    {
        $arquivo_name = self::rmAcentosIso(self::decode($arquivo_name));
        $arquivo_name = preg_replace("/[\!\@\#\$\%\¨\&\*\(\)\_\-\+\=\§\¬\¢\£\³\²\¹\'\"\°\º\ª\/\?\°^~`´]/", "", $arquivo_name);
        $arquivo_name = str_replace(" ", "_", $arquivo_name);
        return $arquivo_name;
    }

    //html para flash

    public static function rmAcentosUtf8($str)
    {
        $acentos = array("&agrave;", "&aacute;", "&acirc;", "&atilde;", "&auml;", "&egrave;", "&eacute;", "&ecirc;", "&ecirc;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&ugrave;", "&uacute;", "&ucirc;", "&uuml;");
        $acentos2 = array("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Auml;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", "&Igrave;", "&Iacute;", "&Icirc;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Ugrave;", "&uacute;", "&Ucirc;", "&Uuml;", "&ccedil;", "&Ccedil;", "&ntilde;", "&Ntilde;");
        $normal = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "c", "C", "n", "N");
        return str_replace(array_merge($acentos, $acentos2), $normal, utf8_decode($str));
    }

    //Codifica uma string

    public static function br($value)
    {
        return preg_replace("/(\\r)?\\n/i", "<br>", $value);
    }

    //Decodifica uma string

    public static function acentosUtf8($string)
    {
        $comacento = array('Á', 'á', 'Â', 'â', 'À', 'à', 'Ã', 'ã', 'É', 'é', 'Ê', 'ê', 'È', 'è', 'Ó', 'ó', 'Ô', 'ô', 'Ò', 'ò', 'Õ', 'õ', 'Í', 'í', 'Î', 'î', 'Ì', 'ì', 'Ú', 'ú', 'Û', 'û', 'Ù', 'ù', 'Ç', 'ç', ' ');
        $acentohtml = array('&Aacute;', '&aacute;', '&Acirc;', '&acirc;', '&Agrave;', '&agrave;', '&Atilde;', '&atilde;', '&Eacute;', '&eacute;', '&Ecirc;', '&ecirc;', '&Egrave;', '&egrave;', '&Oacute;', '&oacute;', '&Ocirc;', '&ocirc;', '&Ograve;', '&ograve;', '&Otilde;', '&otilde;', '&Iacute;', '&iacute;', '&Icirc;', '&icirc;', '&Igrave;', '&igrave;', '&Uacute;', '&uacute;', '&Ucirc;', '&ucirc;', '&Ugrave;', '&ugrave;', '&Ccedil;', '&ccedil;', '&nbsp;');
        return str_replace($acentohtml, $comacento, $string);
    }

    public static function htmlFlash($string)
    {
        $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
        $string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        $result = strtr($string, $trans_tbl);
        //$result = strip_tags($result,"<a><b><br><font><img><i><li><p><span><textformat>");
        return $result;
    }

    public static function rmTags($string)
    {
        $value = strip_tags($string, "<a><b><i><tt><p><br><div><img><hr><table><tr><td><font>");
        return $value;
    }

    //Codifica os dados de uma array e retorna uma nova array com os dados codificados
    public static function encodeArray($array)
    {
        $value = array();
        $keys = array_keys($array);
        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            if (is_array($array[$key])) {
                $value[$key] = self::encodeArray($array[$key]);
            } else {
                $value[$key] = self::encode(strval($array[$key]));
            }
        }
        return $value;
    }

    //Decodifica os dados de uma array e retorna uma nova array com os dados decodificados

    public static function encode($string)
    {
        $value = $string;
        //$value = htmlspecialchars($string,ENT_QUOTES,'iso-8859-1');
        $to_encoding = "UTF-8";
        $from_encoding = self::codificacao($value);
        return str_replace('&nbsp;', ' ', mb_convert_encoding($value, $to_encoding, $from_encoding));
    }

    public static function encodeArrayToString($array)
    {
        $string = "";
        $keys = array_keys($array);
        for ($i = 0; $i < count($keys); $i++) {
            $string .= ($i == 0 ? "" : "&") . $keys[$i] . "=" . urlencode($array[$keys[$i]]);
        }
        return $string;
    }

    public static function decodeStringToArray($string)
    {
        $array = array();
        $decode = explode("&", $string);
        if (!empty($string)) {
            for ($i = 0; $i < count($decode); $i++) {
                $key_value = explode("=", $decode[$i]);
                $array[$key_value[0]] = urldecode($key_value[1]);
            }
        }
        return $array;
    }

    public static function parse_dir_separator($diretorio)
    {
        $barra = DIRECTORY_SEPARATOR;
        $return = str_replace("\\", "/", $diretorio);

        if ($barra != "/") {
            $return = str_replace("/", $barra, $return);
        }

        return $return;
    }

}
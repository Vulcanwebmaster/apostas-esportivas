<?php

namespace app\helpers;

class Utils
{

    /**
     * Criptografia de senha
     * @param string $value
     * @return string 128 caracteres
     */
    public static function encryptPassword($value)
    {
        return hash('sha512', $value);
    }

    /**
     * Calcula a idade em anos
     * @param string $Nascimento
     * @param string $DataReferencia
     * @return int
     */
    public static function idade($Nascimento, $DataReferencia = 'NOW')
    {
        $inicio = Date::data($Nascimento);
        $fim = $DataReferencia == 'NOW' ? date('Y-m-d') : Date::data($DataReferencia);
        $anos = Date::year($fim) - Date::year($inicio);
        return $anos;
    }

    /**
     * Corta a string no número de palavras especificados
     * @param string $String
     * @param int $Words
     * @return string
     */
    public static function getWords($String, $Words = 10)
    {
        return preg_replace('/(([^ ,\.]+[ ,\.]){1,' . (int)$Words . '}).*/', '$1', trim(strip_tags($String)));
    }

    /**
     * Retorna o valor se a condição for verdadeira
     * @param boolean $condicao
     * @param object $return
     * @return mixed $return
     */
    public static function returnIf($condicao, $return = null)
    {
        return $condicao ? $return : null;
    }

    /**
     * Formata os atributos para TAG html
     * @param array $Atributos
     */
    public static function Attributes(array $Atributos = null)
    {
        if ($Atributos and !empty($Atributos)) {
            $html = '';
            foreach ($Atributos as $key => $value) {
                if ($value != null and !is_object($value)) {
                    $aspas = '"';
                    if (is_array($value)) {
                        $value = htmlspecialchars(json_encode($value));
                    } else {
                        $value = htmlspecialchars($value);
                    }
                    $html .= "{$key}={$aspas}{$value}{$aspas} ";
                }
            }
            return substr($html, 0, -1);
        }
        return null;
    }

    /**
     * Redimentsiona uma imagem
     * @param int $w
     * @param int $h
     * @param string $arquivo
     * @param string $type
     * @param int $qualidade
     * @param string $color
     * @param string $defaultSource Arquivo padrão (default.jpg)
     * @param string $pastaResize Pasta dos arquivos redimensionados
     * @return boolean
     */
    static function redimensionaImg($w, $h, $arquivo, $type = 'crop', $qualidade = 100)
    {
        return url('img', [$w, $h, $type, $qualidade], 'cdn') . '/' . $arquivo;
    }

    /**
     * Retorna a extenção de um arquivo
     * @param string $name
     * @return string|null
     */
    static function getFileExtension($name)
    {
        $extension = preg_replace('/^.*\./', null, (string)$name);
        return (empty($extension) or strlen($extension) > 4) ? null : strtolower($extension);
    }

    /**
     * Gera token com 50 caracteres
     * @return string
     */
    static function gerarToken()
    {
        $token = '21';
        $token .= uniqid();
        $token .= self::gerarCodigo(50 - mb_strlen($token, '8bit'), true, false, true, false);
        return $token;
    }

    /**
     * Calcula a idade
     * @param string $nascimento
     * @return int
     */
    static function calcIdade(string $nascimento)
    {
        $dtAgora = new \DateTime();
        $dtNascimento = new \DateTime($nascimento);

        if ($dtNascimento > $dtAgora) {
            return 0;
        }

        $dif = $dtAgora->diff($dtNascimento);

        return $dif->y;
    }

    /**
     * Gerá um Código
     * @param int $tamanho
     * @param boolean $minusculas
     * @param boolean $maiusculas
     * @param boolean $numeros
     * @param boolean $simbolos
     * @return string
     */
    static function gerarCodigo($tamanho = 8, $minusculas = true, $maiusculas = false, $numeros = true, $simbolos = false)
    {

        $simb = '!@#$%*';
        $retorno = '';
        $caracteres = '';

        if ($minusculas) {
            $caracteres .= implode('', range('a', 'z'));
        }
        if ($maiusculas) {
            $caracteres .= implode('', range('A', 'Z'));
        }
        if ($numeros) {
            $caracteres .= implode('', range(0, 9));
        }
        if ($simbolos) {
            $caracteres .= $simb;
        }

        $len = strlen($caracteres);

        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }

        return $retorno;
    }

}
    
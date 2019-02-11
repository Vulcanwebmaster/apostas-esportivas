<?php

namespace app\helpers\jogos;

class PosPrint
{

    const SIZE_SMALL = 'small';
    const SIZE_BIG = 'big';
    private $codigo;

    /**
     * Add vazio
     * @param int $num
     * @param string $size small|big
     * @return $this
     */
    function addEmpty($num = 1, $size = 'small')
    {
        for ($i = 0; $i < $num; $i++) {
            $this->add(' ', $size);
        }
        return $this;
    }

    /**
     *
     * @param string $text
     * @param string $size
     * @param boolean $underline
     * @param boolean $doubleWidth
     * @param boolean $doubleHeight
     * @return $this
     */
    function add($text, $size = 'small', $underline = false, $doubleWidth = false, $doubleHeight = false)
    {
        $this->codigo .= '$' . $size;

        if ($underline) {
            $this->codigo .= 'u';
        }

        if ($doubleHeight) {
            $this->codigo .= 'h';
        }

        if ($doubleWidth) {
            $this->codigo .= 'w';
        }

        $this->codigo .= '$' . htmlspecialchars($text, 0, 'iso-8859-1');

        return $this;
    }

    /**
     * Espaço em branco
     * @return $this
     */
    function grupoLinha()
    {
        $this->linha(3);
        return $this;
    }

    /**
     * Adiciona uma linha
     * @param int $addLines
     * @return $this
     */
    function linha($addLines = 1)
    {
        for ($i = 0; $i < $addLines; $i++) {
            $this->codigo .= '$intro$';
        }
        return $this;
    }

    /**
     * Corta o papel
     * @return $this
     */
    function cortar()
    {
        $this->linha();
        $this->codigo .= '$cut$';
        return $this;
    }

    /**
     * Abre a Gaveta
     * @return $this
     */
    function abrirGaveta()
    {
        $this->linha();
        $this->codigo .= '$drawer$';
        return $this;
    }

    /**
     * Limpa o código
     * @return $this
     */
    function clean()
    {
        $this->codigo = '';
        return $this;
    }

    /**
     * Retorna URL de impressão
     * @return string
     */
    function getLink()
    {
        return 'com.fidelier.printfromweb://' . $this->codigo;
    }

}
    
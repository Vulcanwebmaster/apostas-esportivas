<?php

namespace app\helpers\bootstrap;

class Panel
{

    private $Class = 'default';
    private $Attrs = [];
    private $Header = [];
    private $Body = [];
    private $Footer = [];

    /**
     *
     * @param array $Attrs
     */
    function __construct(array $Attrs = null)
    {
        $this->setAttibutes($Attrs);
    }

    /**
     * Seta os atributos do painel
     * @param array $Attrs
     * @return $this
     */
    function setAttibutes(array $Attrs = null)
    {
        $this->Attrs = $Attrs;
        return $this;
    }

    /**
     * Seta a style class do painel
     * @param string $Class default | success | primary | info | warning | danger
     * @return $this
     */
    function setClass($Class = 'default')
    {
        $this->Class = preg_replace('/^panel-/', null, $Class);
        return $this;
    }

    /**
     * Seta o conteúdo do topo
     * @param string $Content
     * @param array $Attrs
     * @return $this
     */
    function setHeader($Content, array $Attrs = null)
    {
        return $this->_setContent($this->Header, (string)$Content, $Attrs);
    }

    /**
     *
     * @param mixed $Var
     * @param string $Content
     * @param array $Attrs
     * @return $this
     */
    private function _setContent(&$Var, $Content, array $Attrs = null)
    {
        $Var = [
            'content' => $Content,
            'attrs' => $Attrs,
        ];
        return $this;
    }

    /**
     * Seta o conteúdo do corpo
     * @param string $Content
     * @param array $Attrs
     * @return $this
     */
    function setBody($Content, array $Attrs = null)
    {
        return $this->_setContent($this->Body, (string)$Content, $Attrs);
    }

    /**
     * Seta o conteúdo do rodapé
     * @param string $Content
     * @param array $Attrs
     * @return $this
     */
    function setFooter($Content, array $Attrs = null)
    {
        return $this->_setContent($this->Footer, (string)$Content, $Attrs);
    }

    /**
     * HTML
     * @return string
     */
    function __toString()
    {
        return $this->display();
    }

    /**
     * HTML
     * @return string
     */
    function display()
    {
        $html = '';
        foreach ([
                     $this->Header,
                     $this->Body,
                     $this->Footer,
                 ] as $i => $arr) {
            switch ($i) {
                case 0:
                    $Class = 'panel-heading';
                    break;
                case 1:
                    $Class = 'panel-body';
                    break;
                case 2:
                    $Class = 'panel-footer';
                    break;
            }
            if (!empty($arr['attrs']) or !empty($arr['content'])) {
                $Attributes = (array)@$arr['attrs'];
                $Attributes['class'] = trim(@$Attributes['class'] . ' ' . $Class);
                if (strpos($arr['content'], '<table') !== false) {
                    $Attributes['class'] = $Attributes['class'] . ' panel-table';
                }
                $html .= '<div ' . htmlAttributes($Attributes) . ' >';
                $html .= @$arr['content'];
                $html .= '</div>';
            }
        }

        $Attributes = $this->Attrs;
        $Attributes['class'] = trim(@$this->Attrs['class'] . ' panel panel-' . $this->Class);

        return '<div ' . htmlAttributes($Attributes) . ' >' . $html . '</div>';
    }

}
    
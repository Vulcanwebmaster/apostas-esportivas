<?php

namespace app\helpers\bootstrap;

class Modal
{

    private $Attrs = [];
    private $Header = ['title' => 'Modal', 'content' => '', 'attrs' => []];
    private $Body = ['content' => '', 'attrs' => []];
    private $Footer = ['content' => '', 'attrs' => []];

    /**
     *
     * @param string $Size xs | sm | md | lg
     * @param array $Attrs
     */
    public function __construct($Size = 'md', array $Attrs = null)
    {
        $this->Attrs = $Attrs;
        $this->Attrs['size'] = 'modal-' . $Size;
    }

    /**
     * Seta o título da modal
     * @param string $Title
     * @return Object
     */
    public function setTitle($Title)
    {
        $this->Header['title'] = $Title;
        return $this;
    }

    /**
     * Adiciona conteúdo ao topo
     * @return Object
     */
    public function addHeaderContent($Content)
    {
        $this->Header['content'] .= (string)$Content;
        return $this;
    }

    /**
     * Adiciona conteúdo ao corpo
     * @param string $Content
     * @return Object
     */
    public function addBodyContent($Content)
    {
        $this->Body['content'] .= (string)$Content;
        return $this;
    }

    /**
     * Adiciona conteúdo ao rodapé
     * @param string $Content
     * @return Object
     */
    public function addFooterContent($Content)
    {
        $this->Footer['content'] .= (string)$Content;
        return $this;
    }

    /**
     * Seta os atributos
     * @param array $Attrs
     * @return Object
     */
    public function setHeaderAttributes(array $Attrs)
    {
        $this->Footer['attrs'] = $Attrs;
        return $this;
    }

    /**
     * Seta os atributos
     * @param array $Attrs
     * @return Object
     */
    public function setBodyAttributes(array $Attrs)
    {
        $this->Footer['attrs'] = $Attrs;
        return $this;
    }

    /**
     * Seta os atributos
     * @param array $Attrs
     * @return Object
     */
    public function setFooterAttributes(array $Attrs)
    {
        $this->Footer['attrs'] = $Attrs;
        return $this;
    }

    public function __toString()
    {
        return $this->display();
    }

    public function display()
    {

        # ini-structure
        $html = '<div class="modal fade ' . @$this->Attrs['class'] . '" ' . self::_attrs($this->Attrs, ['class', 'size']) . ' >'
            . '<div class="modal-dialog ' . $this->Attrs['size'] . '" >'
            . '<div class="modal-content" >';

        # Header
        $html .= '<div class="modal-header' . @$this->Header['attrs']['class'] . '" ' . self::_attrs($this->Header['attrs'], ['class']) . ' >'
            . '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" >&times;</span></button>'
            . '<h4 class="modal-title" >' . $this->Header['title'] . '</h4>'
            . $this->Header['content']
            . '</div>';

        # Body
        if ($this->Body['attrs'] or $this->Body['content']) {
            $html .= '<div class="modal-body ' . @$this->Body['attrs']['class'] . '" ' . self::_attrs($this->Body['attrs'], ['class']) . ' >'
                . $this->Body['content']
                . '</div>';
        }

        # Footer
        if ($this->Footer['attrs'] or $this->Footer['content']) {
            $html .= '<div class="modal-footer ' . @$this->Footer['attrs']['class'] . '" ' . self::_attrs($this->Footer['attrs'], ['class']) . ' >'
                . $this->Footer['content']
                . '</div>';
        }

        # end-structure
        $html .= '</div>'//modal-content
            . '</div>'//modal-dialog
            . '</div>'; //modal

        return $html;
    }

    /**
     *
     * @param array $Attrs
     * @param array $hideAttrs
     * @return string
     */
    private static function _attrs(array $Attrs, array $hideAttrs = null)
    {
        foreach ($hideAttrs as $key) {
            if (isset($Attrs[$key])) {
                unset($Attrs[$key]);
            }
        }
        return htmlAttributes($Attrs);
    }

}
    
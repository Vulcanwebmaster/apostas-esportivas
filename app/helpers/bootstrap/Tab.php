<?php

namespace app\helpers\bootstrap;

class Tab
{

    private $Contents = [];

    function addTab($linkTitle, $Content, $id = null, array $Attrs = null)
    {
        $this->Contents[] = [
            'linkTitle' => $linkTitle,
            'content' => $Content,
            'attrs' => $Attrs,
        ];
        return $this;
    }

    /**
     * HTML
     * @return string
     */
    public function __toString()
    {
        return $this->display();
    }

    function display($Active = 0)
    {
        $nav = '';
        $html = '';
        foreach ($this->Contents as $i => $v) {
            $id = @$v['id'] ? $v['id'] : uniqid('tab_');
            $classActive = $i == $Active ? 'active' : null;

            # Navegador
            $nav .= '<li role="presentation" class="' . $classActive . '" >'
                . '<a href="#' . $id . '" aria-controls="' . $id . '" role="tab" data-toggle="tab" >' . $v['linkTitle'] . '</a>'
                . '</li>';

            # Conteúdo
            $html .= '<div role="tabpanel" class="tab-pane ' . $classActive . '" id="' . $id . '" >'
                . '<div ' . htmlAttributes($v['attrs']) . ' >'
                . $v['content']
                . '</div>'
                . '</div>';
        }
        return '<div class="tab-dashboard" ><ul class="nav nav-tabs" role="tablist" >' . $nav . '</ul><div class="tab-content" >' . $html . '</div></div>';
    }

}
    
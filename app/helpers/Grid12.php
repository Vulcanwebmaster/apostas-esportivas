<?php

namespace app\helpers;

class Grid12
{

    /** @var array */
    private $Row = [];

    /** @var string */
    private $RowKey = null;

    /** @var array */
    private $Attrs = [];

    /** @var string */
    private $ResponsiveClass;

    /**
     *
     * @param string $ResponsiveClass xs => auto | sm => 750px | md => 970px | lg => 1170px
     * @param string $Id
     * @param string $Class
     * @param array $Attrs
     */
    public function __construct($ResponsiveClass = 'xs', $Id = null, $Class = null, array $Attrs = null)
    {
        $this->Attrs = $Attrs;
        $this->ResponsiveClass = strtolower($ResponsiveClass);
        if ($Id !== null) {
            $this->Attrs['id'] = $Id;
        }
        if ($Class !== null) {
            $this->Attrs['class'] = $Class;
        }
    }

    /**
     * Seta os atributos
     * @param array $Attributes
     * @return $this
     */
    function setAttributes(array $Attributes = null)
    {
        $this->Attrs = $Attributes;
        return $this;
    }

    /**
     * Adiciona uma coluna na linha atual
     * @param string $conteudo
     * @param int|string $colunas 1 à 12 ou grid class ex: col-md-4 col-xs-12
     * @param string $responsiveClass
     * @param array $attrs
     * @param boolean $add Só adiciona se for true
     * @return $this
     */
    function addColumn($conteudo = '', $colunas = 12, $responsiveClass = null, array $attrs = null, $add = true)
    {

        if ($add and $colunas !== 0) {

            if (is_int($colunas)) {
                $responsiveClass = $responsiveClass == null ? $this->ResponsiveClass : $responsiveClass;

                $class = 'col-' . $responsiveClass . '-' . $colunas;

                if ($responsiveClass != 'xs') {
                    $class .= ' col-xs-12';
                }

            } else {
                $class = $colunas;
                $colunas = (int)preg_replace('/.*?([0-9]+).*/', '$1', $colunas);
            }

            # Caso ainda não exista uma linha
            if ($this->RowKey === null or ($this->Row[$this->RowKey]['columns'] + $colunas) > 12) {
                $this->addRow();
            }
            if (isset($attrs['class'])) {
                $attrs['class'] = trim("{$attrs['class']} {$class}");
            } else {
                $attrs['class'] = $class;
            }
            $this->Row[$this->RowKey]['columns'] += $colunas;
            $this->Row[$this->RowKey]['content'][] = [
                'content' => $conteudo,
                'attrs' => $attrs,
            ];
        }

        return $this;
    }

    /**
     * Adicionar uma linha
     * @param string $Class
     * @param array $Attrs
     * @return $this
     */
    function addRow($Class = '', array $Attrs = null)
    {
        $Attrs['class'] = trim("row {$Class}");
        $this->Row[] = [
            'columns' => 0,
            'content' => [],
            'attrs' => $Attrs,
        ];
        end($this->Row);
        $this->RowKey = key($this->Row);
        return $this;
    }

    public function __toString()
    {
        return (string)$this->getContent();
    }

    /**
     * Retorna todo o conteúdo criado
     * @return string
     */
    function getContent()
    {
        $html = '';
        foreach ($this->Row as $row) {
            $html .= '<div ' . $this->fAttrs($row['attrs']) . ' >';
            foreach ($row['content'] as $column) {
                $html .= '<div ' . $this->fAttrs($column['attrs']) . ' >'
                    . $column['content']
                    . '</div>';
            }
            $html .= '</div>';
        }
        return '<div ' . $this->fAttrs($this->Attrs) . ' >' . $html . '</div>';
    }

    /**
     * Formata os atributos para a string
     * @param array $Attrs
     * @return string
     */
    static function fAttrs(array $Attrs = null)
    {
        $html = '';
        if ($Attrs) {
            foreach ($Attrs as $key => $value) {
                if (is_object($value)) {
                    $arr = [];
                    foreach ($value as $key => $v) {
                        $arr[$key] = $v;
                    }
                    $value = $arr;
                }
                if (is_bool($value)) {
                    $value = $value ? 1 : 0;
                }
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                $html .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
            }
        }
        return trim($html);
    }

}
    
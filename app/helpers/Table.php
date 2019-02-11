<?php

namespace app\helpers;

use Exception;

class Table
{

    public $xhtml = true; // for col tags
    private $thead = [];
    private $tfoot = [];
    private $tbody = [];
    private $cur_section;
    private $colgroups_ar = [];
    private $cols_ar = []; // if cols not in colgroup
    private $tableStr = '';

    /**
     * Criando novo objeto Table
     * @param int $id ID da tabela
     * @param string $class Classe da tabela
     * @param array $attr Atributos da tabela
     */
    public function __construct($id = '', $class = '', $attr = [])
    {
        // add rows to tbody unless addTSection called
        $this->cur_section = &$this->tbody[0];

        $this->tableStr = "\n<table" . (!empty($id) ? " id=\"$id\"" : '') .
            (!empty($class) ? " class=\"$class\"" : '') . $this->addAttribs($attr) . ">\n";
    }

    /**
     *
     * @param array $attr
     * @return string
     */
    private function addAttribs(array $attr = null)
    {
        $str = '';
        if ($attr) {
            foreach ($attr as $key => $val) {
                $str .= ' ' . $key . '="' . htmlspecialchars($val) . '"';
            }
        }
        return $str;
    }

    /**
     *
     * @param string $sec
     * @param string $klass
     * @param array $attr_ar
     * @return $this
     */
    public function addTSection($sec, $klass = '', array $attr_ar = [])
    {
        switch ($sec) {
            case 'thead':
                $ref = &$this->thead;
                break;
            case 'tfoot':
                $ref = &$this->tfoot;
                break;
            case 'tbody':
                $ref = &$this->tbody[count($this->tbody)];
                break;

            default: // tbody
                $ref = &$this->tbody[count($this->tbody)];
        }

        $ref['name'] = $sec;
        $ref['klass'] = $klass;
        $ref['atts'] = $attr_ar;
        $ref['rows'] = [];

        $this->cur_section = &$ref;
        return $this;
    }

    /**
     *
     * @param string $span
     * @param string $klass
     * @param array $attr_ar
     * @return $this
     */
    public function addColgroup($span = '', $klass = '', array $attr_ar = [])
    {
        $group = array(
            'span' => $span,
            'klass' => $klass,
            'atts' => $attr_ar,
            'cols' => []
        );

        $this->colgroups_ar[] = &$group;
        return $this;
    }

    /**
     *
     * @param string $span
     * @param string $klass
     * @param array $attr_ar
     * @return $this
     */
    public function addCol($span = '', $klass = '', array $attr_ar = [])
    {
        $col = array(
            'span' => $span,
            'klass' => $klass,
            'atts' => $attr_ar
        );

        // in colgroup?
        if (!empty($this->colgroups_ar)) {
            $group = &$this->colgroups_ar[count($this->colgroups_ar) - 1];
            $group['cols'][] = &$col;
        } else {
            $this->cols_ar[] = &$col;
        }
        return $this;
    }

    /**
     *
     * @param string $cap
     * @param string $klass
     * @param array $attr_ar
     * @return $this
     */
    public function addCaption($cap, $klass = '', array $attr_ar = null)
    {
        $this->tableStr .= "<caption" . (!empty($klass) ? " class=\"$klass\"" : '') .
            $this->addAttribs($attr_ar) . '>' . $cap . "</caption>\n";
        return $this;
    }

    /**
     *
     * @param string $klass
     * @param array $attr_ar
     * @return $this
     */
    public function addRow($klass = '', array $attr_ar = [])
    {
        // add row to current section
        $this->cur_section['rows'][] = array(
            'klass' => $klass,
            'atts' => $attr_ar,
            'cells' => []
        );
        return $this;
    }

    /**
     *
     * @param string $content
     * @param string $class
     * @param string $type
     * @param string $attr
     * @param boolean $display Se false não é incluido na tabela
     * @return Table
     * @throws Exception
     */
    public function addCell($content = null, $class = null, $type = null, array $attr = null, $display = true)
    {
        if ($display and $class !== false) {

            $cell = array(
                'data' => $content,
                'klass' => !is_array($class) ? $class : null,
                'type' => $type == null ? ($this->cur_section['name'] == 'tbody' ? 'td' : 'th') : ($type == 'data' ? 'td' : $type),
                'atts' => (is_array($class) and is_null($attr)) ? $class : (array)$attr,
            );

            if (empty($this->cur_section['rows'])) {
                try {
                    throw new Exception('You need to addRow before you can addCell');
                } catch (Exception $ex) {
                    $msg = $ex->getMessage();
                    echo "<p>Error: $msg</p>";
                }
            }

            // add to current section's current row's list of cells
            $count = count($this->cur_section['rows']);
            $curRow = &$this->cur_section['rows'][$count - 1];
            $curRow['cells'][] = &$cell;
        }
        return $this;
    }

    public function __toString()
    {
        return $this->display();
    }

    public function display()
    {
        // get colgroups/cols
        $this->tableStr .= $this->getColgroups();

        // get sections and their rows/cells
        $this->tableStr .= !empty($this->thead) ? $this->getSection($this->thead, 'thead') : '';
        $this->tableStr .= !empty($this->tfoot) ? $this->getSection($this->tfoot, 'tfoot') : '';

        foreach ($this->tbody as $sec) {
            $this->tableStr .= !empty($sec) ? $this->getSection($sec, 'tbody') : '';
        }

        $this->tableStr .= "</table>\n";
        return $this->tableStr;
    }

    // get colgroups/cols
    private function getColgroups()
    {
        $str = '';

        if (!empty($this->colgroups_ar)) {
            foreach ($this->colgroups_ar as $group) {

                $str .= "<colgroup" . (!empty($group['span']) ? " span=\"{$group['span']}\"" : '') .
                    (!empty($group['klass']) ? " class=\"{$group['klass']}\"" : '') .
                    $this->addAttribs($group['atts']) . ">" .
                    $this->getCols($group['cols']) . "</colgroup>\n";
            }
        } else {
            $str .= $this->getCols($this->cols_ar);
        }

        return $str;
    }

    private function getCols($ar)
    {
        $str = '';
        foreach ($ar as $col) {
            $str .= "<col" . (!empty($col['span']) ? " span=\"{$col['span']}\"" : '') .
                (!empty($col['klass']) ? " class=\"{$col['klass']}\"" : '') .
                $this->addAttribs($col['atts']) . ($this->xhtml ? " />" : ">");
        }
        return $str;
    }

    private function getSection($sec, $tag)
    {
        $klass = !empty($sec['klass']) ? " class=\"{$sec['klass']}\"" : '';
        $atts = !empty($sec['atts']) ? $this->addAttribs($sec['atts']) : '';

        $str = "<$tag" . $klass . $atts . ">\n";

        foreach ($sec['rows'] as $row) {
            $str .= (!empty($row['klass']) ? "  <tr class=\"{$row['klass']}\"" : "  <tr") .
                $this->addAttribs($row['atts']) . ">\n" .
                $this->getRowCells($row['cells']) . "  </tr>\n";
        }

        $str .= "</$tag>\n";

        return $str;
    }

    private function getRowCells($cells)
    {
        $str = '';
        foreach ($cells as $cell) {
            $tag = $cell['type'];
            $str .= (!empty($cell['klass']) ? "    <$tag class=\"{$cell['klass']}\"" : "    <$tag") .
                $this->addAttribs($cell['atts']) . ">" . $cell['data'] . "</$tag>\n";
        }
        return $str;
    }

}
    
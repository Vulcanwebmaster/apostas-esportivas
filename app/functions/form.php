<?php

function form_open(array $attrs = null, $method = 'post')
{
    return "<!-- form_open -->\n"
        . '<form ' . htmlAttributes($attrs) . ' method="' . $method . '" accept-charset="utf-8" enctype="multipart/form-data" >';
}

function form_close()
{
    return '</form>'
        . "\n<!-- form_close -->";
}

function form_hidden(array $Values)
{
    $html = '';
    foreach ($Values as $key => $value) {
        if (is_int($key)) {
            $key = $value;
            $value = null;
        }
        $html .= formInput($key, $value, 'hidden');
    }
    return $html;
}

function dropDown($Caption, $Options = null, $Class = null)
{

    if (is_array($Options)) {
        ob_start();
        foreach ($Options as $value) {
            echo "<li>{$value}</li>";
        }
        $Options = ob_get_clean();
    }

    return '<div class="btn-group ' . $Class . '" role="group">
                <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >
                  ' . $Caption . '
                </div>
                <ul class="dropdown-menu" role="menu">
                  ' . $Options . '
                </ul>
              </div>';
}

/**
 * Formata um atributo.
 * @param string $value
 * @return string
 */
function htmlFormatAttribute($value)
{

    if (is_array($value)) {
        $value = json_encode($value);
    } else if (is_object($value) and is_a($value, 'ValueObject')) {
        return (string)$value;
    } else if (is_object($value)) {

        $values = [];
        foreach ($value as $key => $value) {
            $values[$key] = $value->$key;
        }
        $value = json_encode($values);
    } else if (is_int($value) or is_float($value)) {
        return $value;
    } else if (is_bool($value)) {
        return $value ? 1 : 0;
    }

    return htmlspecialchars($value);
}

/**
 * Converte um array em atributos para uma tag html
 * @param array $attributes
 * @param array $concat
 * @return string
 */
function htmlAttributes(array $attributes = null, array $concat = null)
{
    $html = "";

    if ($concat) {
        foreach ($concat as $key => $value) {
            if (isset($attributes[$key])) {
                $attributes[$key] = trim($attributes[$key] . ' ' . $value);
            } else {
                $attributes[$key] = $value;
            }
        }
    }

    if ($attributes) {
        foreach ($attributes as $key => $value) {
            $value = htmlFormatAttribute($value);
            if (is_int($key)) {
                $html .= "{$value}=\"\" ";
            } else {
                $html .= "{$key}=\"{$value}\" ";
            }
        }
    }

    return trim($html);
}

/**
 * Monta um formulário
 * @param array $attributes
 * @param string $fields
 * @return string
 */
function form(array $attributes, $fields)
{
    if (!is_array($fields)) {
        $fields = func_get_args();
        array_shift($fields);
    }
    $html = form_open($attributes, 'post');
    foreach ($fields as $field) {
        $html .= $field;
    }
    $html .= "<span class=\"clearfix\"></span>"
        . form_close();
    return $html;
}

/**
 * Cria uma label
 * @param string $caption
 * @param string $content
 * @param array $attributes
 * @param string $help
 * @return string
 */
function formLabel($caption, $content, array $attributes = null, $help = null)
{
    if (!$attributes) {
        $attributes = array();
    }
    $classP = '';
    if (preg_match('/\<textarea/', $content)) {
        if (!isset($attributes['class'])) {
            $attributes['class'] = 'textarea';
        } else {
            $attributes['class'] .= ' textarea';
        }
        $classP = 'textarea';
    }
    if (preg_match('/id=\"(.*?)\"/', (string)$content, $id)) {
        $id = $id[1];
    } else {
        $id = '';
    }
    if (preg_match('/type="(radio|checkbox)"/i', (string)$content)) {
        $attributes['class'] = trim((isset($attributes['class']) ? $attributes['class'] : '') . ' label-check');
    }
    return "<div " . htmlAttributes($attributes, ['class' => 'form-group']) . " >"
        . "<label for=\"{$id}\" class='caption {$classP}' >{$caption}</label>"
        . $content
        . ($help ? '<small class="help-block" >' . $help . '</small>' : null)
        . "</div>";
}

/**
 *
 * @param string $name
 * @param string $value
 * @param array $Attributes
 * @return string
 */
function formInputDate($name, $value = null, array $Attributes = null)
{
    return formInput($name, $value, 'text', array_merge((array)$Attributes, ['class' => 'mask-data']));
}

/**
 * Form.button
 * @param string $Caption
 * @param string $Type
 * @param string $Class
 * @param string $Name
 * @param string $Value
 * @param array $Attibutes
 * @return string
 */
function formButton($Caption, $Type = 'submit', $Class = null, $Name = null, $Value = null, array $Attibutes = null)
{
    if (!$Attibutes and is_array($Name)) {
        $Attibutes = $Name;
        $Name = null;
    }
    return '<button ' . htmlAttributes($Attibutes, [
            'type' => $Type,
            'class' => 'btn ' . ($Class ? $Class : ($Type == 'reset' ? 'btn-danger' : 'btn-primary')),
            'name' => $Name,
            'value' => $Value
        ]) . '>' . $Caption . '</button>';
}

/**
 * Form.button.input.file
 * @param string $Caption
 * @param string $Name
 * @param string $Accept
 * @param string $Class
 * @param array $Attibutes
 * @return string
 */
function formButtonFile($Caption, $Name, $Accept = null, $Class = 'btn-success', array $Attibutes = null)
{
    $id = uniqid('inputfile_');

    $extraAttrs = [
        'type' => 'file',
        'name' => $Name,
        'id' => $id,
        'accept' => $Accept,
    ];

    if (preg_match('/\[\]$/', $extraAttrs['name'])) {
        $extraAttrs['multiple'] = 'multiple';
    }

    return '<label for="' . $id . '" class="' . $Class . ' btn btn-inputfile" style="width: auto; overflow: hidden;" >'
        . "<span>$Caption <span></span></span>"
        . '<input ' . htmlAttributes($Attibutes, $extraAttrs) . ' style="position: absolute; top: 0; left: 0; opacity: 0; filter: alpha(opacity=0);" >'
        . '</label>';
}

/**
 * Form.textarea
 * @param string $name
 * @param string $value
 * @param array $attributes
 * @return string
 */
function formTextarea($name, $value = null, array $attributes = null)
{
    if (!isset($attributes['id'])) {
        $attributes['id'] = uniqid('textarea_');
    }
    return "<textarea name=\"{$name}\" " . htmlAttributes($attributes, ['class' => 'form-control']) . " >{$value}</textarea>";
}

/**
 * Form.input
 * @param string $name
 * @param string $value
 * @param string $type
 * @param array $attributes
 * @return string
 */
function formInput($name, $value = null, $type = 'text', array $attributes = null)
{
    if (in_array($type, ['text', 'number', 'email', 'date', 'password', 'color', 'search', 'time'])) {
        $concat = ['class' => 'form-control'];
    } else {
        $concat = null;
    }
    if (!isset($attributes['id'])) {
        $attributes['id'] = uniqid('input_');
    }
    return "<input name=\"{$name}\" type=\"{$type}\" value=\"{$value}\" " . htmlAttributes($attributes, $concat) . " />";
}

function formInputGroup($input, $prepend = null, $append = null)
{
    $prependBtn = strpos($prepend, '<button') !== false;
    $appendBtn = strpos($append, '<button') !== false;
    return "<div class='input-group' >"
        . ($prepend ? "<div class='input-group-" . ($prependBtn ? 'btn' : 'addon') . "' >{$prepend}</div>" : null)
        . $input
        . ($append ? "<div class='input-group-" . ($appendBtn ? 'btn' : 'addon') . "' >{$append}</div>" : null)
        . "</div>";
}

/**
 * Form.input.file
 * @param string $name
 * @param string $caption
 * @param string $accept
 * @param array $attributes
 * @return string
 */
function formInputFile($name, $caption, $accept = '*', array $attributes = null)
{
    if (!$attributes) {
        $attributes = array();
    }
    if (strpos($name, "[]") !== false) {
        $attributes['multiple'] = 'multiple';
    }
    $attributes['accept'] = $accept;
    if (!isset($attributes['id'])) {
        $attributes['id'] = uniqid('inputfile_');
    }
    return formLabel("{$caption}", formInput($name, null, 'file', $attributes), array('class' => 'file'));
}

/**
 * Cria um select
 * @param string $name
 * @param string $options
 * @param array $attributes
 * @return string
 */
function formSelect($name, $options = null, array $attributes = null)
{
    if (is_array($options)) {
        ob_start();
        foreach ($options as $value => $caption) {
            echo formOption($caption, $value);
        }
        $options = ob_get_clean();
    } else if (is_object($options) and is_a($options, 'Closure')) {
        $options = $options();
    }
    if (!isset($attributes['id'])) {
        $attributes['id'] = uniqid('select_');
    }
    return "<select name=\"{$name}\" " . htmlAttributes($attributes, ['class' => 'form-control']) . " >{$options}</select>";
}

/**
 * Cria um select option
 * @param string $caption
 * @param int|string $value
 * @param boolean $selected
 * @param array $attibutes
 * @return string
 */
function formOption($caption, $value = null, $selected = false, array $attibutes = null)
{
    return formSelectOption($caption, $value, $selected, $attibutes);
}

/**
 * Cria uma lista de options a partir de uma array de obj
 * @param array $list lista de registros
 * @param string $method_caption
 * @param string $method_id
 * @param string $default_value
 * @param array $attibutes
 */
function formOptionObject(array $list, $method_caption = 'getTitle', $method_value = 'getId', $default_value = null, array $attibutes = null)
{
    if (count($list)) {
        if (!method_exists($list[0], $method_caption)) {
            trigger_error("O Método `{$method_caption}` não existe para o objeto `" . get_class($list[0]) . "`.");
        } else if (!method_exists($list[0], $method_value)) {
            trigger_error("O Método `{$method_value}` não existe para o objeto `" . get_class($list[0]) . "`.");
        } else {
            $html = '';
            foreach ($list as $item) {
                $html .= formOption($item->$method_caption(), $item->$method_value(), $item->$method_value() == $default_value ? true : false, $attibutes);
            }
            return $html;
        }
    }
    return null;
}

/**
 * Cria um select option
 * @param string $caption
 * @param int|string $value
 * @param boolean $selected
 * @param array $attibutes
 * @return string
 */
function formSelectOption($caption, $value = null, $selected = false, array $attibutes = null)
{
    if ($value !== null) {
        $attibutes['value'] = $value;
    }
    if ($selected) {
        $attibutes['selected'] = 'selected';
    }
    return "<option " . htmlAttributes($attibutes) . " >{$caption}</option>";
}

/**
 * Cria um label->input[type=radio]
 * @param string $name
 * @param string $caption
 * @param string|int $value
 * @param array $attributes
 * @return string
 */
function formInputRadio($name, $caption, $value, array $attributes = null)
{
    return formLabel($caption, formInput($name, $value, 'radio', $attributes), array('class' => 'box'));
}

/**
 * Cria um label->input[type=checkbox]
 * @param string $name
 * @param string $caption
 * @param string|int $value
 * @param array $attributes
 * @return string
 */
function formInputCheckBox($name, $caption, $value, array $attributes = null)
{
    return '<label class="btn input-box" >'
        . '<input ' . htmlAttributes($attributes, ['type' => 'checkbox', 'name' => $name, 'value' => $value]) . ' >'
        . $caption
        . '</label>';
}

/**
 * Cria um box
 * @param string $title
 * @param string $content
 * @param array $attibutes
 * @return string
 */
function formBox($title, $content, array $attibutes = null)
{
    $class = 'boxRadio';
    if ($attibutes) {
        if (isset($attibutes['class'])) {
            $class .= ' ' . $attibutes['class'];
            unset($attibutes['class']);
        }
    }
    $html = '<div class="' . $class . '" ' . htmlAttributes($attibutes) . ' >';
    $html .= '<label class="' . $class . '-title" >' . $title . '</label>';
    $html .= '<div class="' . $class . '-content">';
    if (is_array($content)) {
        foreach ($content as $item) {
            $html .= $item;
        }
    } else {
        $html .= $content;
    }
    $html .= '<span class="clearfix"></span></div></div>';
    return $html;
}


function optAfirmacao($value = -1)
{
    $html = "<option value=\"1\"" . ($value == 1 ? "selected" : "") . ">Sim</option>";
    $html .= "<option value=\"0\"" . ($value == 0 ? "selected" : "") . ">Não</option>";
    return $html;
}

function optStatus($value = 0)
{
    $html = "<option value=\"1\"" . ($value == 1 ? "selected" : "") . ">Ativo</option>";
    $html .= "<option value=\"0\"" . ($value == 0 ? "selected" : "") . ">Inativo</option>";
    return $html;
}

function optMeses($mes = -1, $abreviar = false)
{
    $mes = $mes < 1 ? date('d') : $mes;
    $meses1 = array('COMPLETO', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    $meses2 = array('ABREVIADO', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');
    $meses = $abreviar === false ? $meses1 : $meses2;
    $html = "";
    for ($i = 1; $i < count($meses); $i++) {
        $html .= "<option value=\"$i\" " . ($i == $mes ? 'selected' : '') . ">$meses[$i]</option>";
    }
    return $html;
}

/**
 * Retorna uma lista númerada
 * @param int $min
 * @param int $max
 * @param string $prefixo
 * @param string $sufixo
 * @return string
 */
function optNuns($min = 0, $max = 15, $prefixo = '', $sufixo = '')
{
    $html = "";
    $padLength = strlen((string)$max);
    for ($i = $min; $i <= $max; $i++) {
        $html .= formSelectOption(trim($prefixo . str_pad((string)$i, $padLength, "0", STR_PAD_LEFT) . $sufixo), (int)$i, false);
    }
    return $html;
}

function btnFile($name, $label, $accept = '')
{
    $multiple = strpos($name, "[]") === false ? "" : "multiple";
    $html = "<label style='margin:0;'>";
    $html .= "<input type='file' accept='{$accept}' name='{$name}' {$multiple}>";
    $html .= "<p class='file'>{$label}</p>";
    $html .= "</label>";
    return $html;
}

/**
 *
 * @param int $start
 * @param int $end
 * @param string $prefixo
 * @param string $sufixo
 * @return string
 */
function formOptionRange($start, $end, $prefixo = null, $sufixo = null)
{
    $html = '';
    foreach (range($start, $end) as $value) {
        $html .= formOption("{$prefixo}{$value}{$sufixo}", $value);
    }
    return $html;
}
    
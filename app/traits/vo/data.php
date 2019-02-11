<?php

namespace app\traits\vo;

trait data
{

    private $data;

    function getData($format = false)
    {
        return $this->formatValue($this->getInsert(), 'data', $format);
    }

}
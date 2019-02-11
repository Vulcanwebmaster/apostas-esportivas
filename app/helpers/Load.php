<?php

namespace app\helpers;

class Load
{

    /**
     * @param string $filename
     * @return string
     */
    static function file(string $filename)
    {
        $source = ABSPATH . $filename;
        if (file_exists($source))
            return include $source;
    }

}
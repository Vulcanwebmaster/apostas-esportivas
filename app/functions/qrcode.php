<?php

function qrcode($url, $size = 250)
{
    return "http://chart.apis.google.com/chart?cht=qr&chl={$url}&chs={$size}x{$size}";
}
<?php

include '../../../vendor/autoload.php';

ob_end_clean();
header('Content-type: text/javascript; charset=UTF-8');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

echo <<<JS

/**
* @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
* For licensing, see LICENSE.md or http://ckeditor.com/license
*/

UPLOADCARE_PUBLIC_KEY = 'e123af9d20cb17f43f0f';

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    config.language = 'pt-br';
    // config.uiColor = '#AADC6E';
    config.extraPlugins = 'uploadcare,image2,slideshow,widget,widgetselection,lineutils,templates,stylesheetparser';
};

JS;


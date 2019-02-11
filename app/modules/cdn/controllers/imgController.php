<?php


namespace app\modules\cdn\controllers;

use app\core\Controller;
use app\helpers\IMGCanvas;

class imgController extends Controller
{

    function indexAction()
    {
        ob_end_clean();

        $w = (int)url_parans(0);
        $h = (int)url_parans(1);
        $type = (string)url_parans(2) ?: 'crop';
        $qualidade = (int)url_parans(3) ?: 100;
        $filename = (string)url_parans(4);
        $extension = (string)url_parans('extension');

        if (!$filename) {
            $filename = url_parans(0);
        }

        $etagFile = md5("{$w}/{$h}/{$type}/{$qualidade}/{$filename}/{$extension}");

        $source = abs_source_images("{$filename}.{$extension}");

        if (!file_exists($source)) {
            $etagFile = md5("{$w}/{$h}/{$type}/{$qualidade}/default/euviemlinhares.jpg");
            $source = abs_source_images("default.jpg");
        }

        $etagHeader = trim(getenv('HTTP_IF_NONE_MATCH'));

        header("Etag: {$etagFile}");
        header('Cache-Control: public');

        if ($etagHeader == $etagFile) {
            exit(http_response_code(304));
        } else {
            http_response_code(200);
        }

        $img = new IMGCanvas($source);

        # Redimensionando imagem
        if ($w > 0 or $h > 0) {
            $img->redimensiona($w, $h, $type);
        }

        $img->grava('', (int)$qualidade);
    }

}
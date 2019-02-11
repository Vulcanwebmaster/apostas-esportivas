<?php



/**
 *
 * @param string $content
 * @param string $filename
 * @param int $width
 * @param int|string $height
 * @param int $cache em minutos
 * @param string $orientacao portrait | landscape
 */
function displayPdf($content, $filename, $width, $height = 'auto', $cache = 30, $orientacao = 'portrait')
{

    ob_end_clean();

    $path = abs_source_files('pdf');

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
        chmod($path, 0777);
    }

    $options = new \Dompdf\Options;

    $options->isHtml5ParserEnabled();
    $options->setIsRemoteEnabled(true);

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($content, 'UTF-8');
    $dompdf->setPaper($width > 0 ? [0, 0, $width, $height] : $width, $orientacao);
    $dompdf->render();

    $page_count = $dompdf->getCanvas()->get_page_count();

    if ($page_count > 1) {

        unset($dompdf);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($content);
        $dompdf->setPaper(array(0, 0, $width, $height * $page_count));
        $dompdf->render();
    }


    $dompdf->stream($filename, ['Attachment' => false]);
}
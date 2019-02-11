<?php

namespace app\traits\core;

use app\helpers\Load;

trait view
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    private $twigCachePath;

    /**
     * @param string $view
     * @param array|null $data
     * @param string $block
     * @param bool $return
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function view(string $view, array $data = null, string $block = null, bool $return = false)
    {

        $this->load();
        $template = $this->twig->load("{$view}.twig");

        $data = (array)$data + view_vars();

        if ($block) {
            if ($return) {
                return $template->renderBlock($block, $data);
            } else {
                $template->displayBlock($block, $data);
            }
        } else {
            if ($return) {
                return $template->render($data);
            } else {
                $template->display($data);
            }
        }
    }

    /**
     * Configuranco o twig
     */
    private function load()
    {
        $this->twig();
        $this->functions();
    }

    /**
     * Inicia o twig
     */
    private function twig()
    {

        if (IS_LOCAL) {
            $config = [
                'debug' => true,
            ];
        } else {
            $config = [
                'cache' => $this->twigCachePath = ABSPATH . '/_temp/twig',
            ];
        }

        $path = ABSPATH . '/app/views';

        $loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($loader, $config);
    }

    /**
     * Carrega as fuções do twig
     */
    private function functions()
    {
        $functions = Load::file('/app/functions/twig.php');
        foreach ($functions as $function) {
            $this->twig->addFunction($function);
        }
    }

    /**
     * Limpa a pasta de cache do twig
     * @return int
     */
    protected function viewCacheClean()
    {

        $total = 0;

        $this->load();

        if ($this->twigCachePath) {

            $fnc = function ($path) use (&$fnc, &$total) {
                if (file_exists($path)) {
                    $arquivos = glob("{$path}/*", GLOB_BRACE);
                    foreach ($arquivos as $arquivo) {
                        if (is_dir($arquivo)) {
                            $fnc($arquivo);
                        } else {
                            $total++;
                            unlink($arquivo);
                        }
                    }
                    rmdir($path);
                }
            };

            $fnc($this->twigCachePath);

        }

        return $total;
    }

}
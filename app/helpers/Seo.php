<?php


namespace app\helpers;

use app\APP;


final class Seo
{

    private static $Charset = CHARSET;
    private static $SEO = [];
    private static $Imagens = [];
    private static $Videos = [];
    private static $Sounds = [];
    private static $CSS = [];
    private static $JS = [];

    /**
     * Limpa todos os valores
     */
    public static function reset()
    {
        self::$SEO = [];
        self::$Imagens = [];
        self::$Videos = [];
        self::$Sounds = [];
        self::$CSS = [];
        self::$JS = [];
    }

    /**
     * Altera o charset da página
     * @param string $Charset
     */
    public static function setCharset($Charset)
    {
        self::$Charset = $Charset;
    }

    /**
     * Seta o Favicon a página
     * @param string $Source
     */
    public static function setFavicon($Source)
    {
        self::addValue('icon', $Source);
    }

    /**
     * Adiciona um novo valor
     * @param string $ref1 Título da tag ou do atributo
     * @param string $ref2 Valor da tag ou valor do atributo
     * @param string $value Valor do conteúdo
     */
    public static function addValue()
    {
        $args = func_get_args();
        if (count($args) == 2) {
            self::$SEO[$args[0]] = $args[1];
        } else if (count($args) == 3) {
            self::$SEO[$args[0]][$args[1]] = $args[2];
        } else {
            trigger_error("SEOError:addValue: Número de argumentos inválidos.", E_USER_NOTICE);
        }
    }

    /**
     * Informa o título da página
     * @param string $value
     */
    public static function setTitle($value)
    {
        if ($value = trim($value)) {
            self::addValue('title', $value);
            self::addValue('name', 'title', $value);
            self::addValue('property', 'og:title', $value);
        }
    }

    /**
     * @return string
     */
    public static function getTitle()
    {
        return self::getValue('title');
    }

    /**
     * Recupera um valor do SEO
     * @param string $ref1 Nome da Tag ou do atributo
     * @param string $ref2 Nome do atribuo
     */
    public static function getValue()
    {
        $args = func_get_args();
        if (count($args) == 1) {
            return isset(self::$SEO[$args[0]]) ? self::$SEO[$args[0]] : null;
        } else if (count($args) == 2) {
            return isset(self::$SEO[$args[0]][$args[1]]) ? self::$SEO[$args[0]][$args[1]] : null;
        } else {
            trigger_error("SEOError:getValue:  Número de argumentos inválidos.", E_USER_NOTICE);
        }
    }

    /**
     * @return string
     */
    public static function getKeywords()
    {
        return self::getValue('name', 'keywords');
    }

    /**
     * @return string
     */
    public static function getDescricao()
    {
        return self::getValue('name', 'description');
    }

    /**
     * Informa a descrição da página
     * @param string $value
     */
    public static function setDescription($value)
    {
        if ($value = trim($value)) {
            self::addValue('name', 'description', $value);
            self::addValue('property', 'og:description', $value);
        }
    }

    /**
     * Informa as palavras chave da página
     * @param string $value
     */
    public static function setKeywords($value)
    {
        if ($value = trim($value)) {
            self::addValue('name', 'keywords', $value);
        }
    }

    /**
     * Adiciona as Tags OpenGraph de imgem (og:image)
     * @param string $url
     * @param int $width Ex: 200
     * @param int $height Ex: 200
     * @param string $type Ex: image/jpeg
     * @param string $secureUrl
     */
    public static function addImage($url, $width = null, $height = null, $type = null, $secureUrl = null)
    {
        self::$Imagens[] = array(
            'og:image' => $url,
            'og:image:secure_url' => $secureUrl,
            'og:image:type' => $type,
            'og:image:width' => $width,
            'og:image:height' => $height
        );
    }

    /**
     * Adiciona as Tags OpenGraph de vídeo (og:video)
     * @param string $url Ex: http://www.seusite.com.br/videos/video.mp4
     * @param int $width Ex: 600
     * @param int $height Ex: 350
     * @param string $type Ex: video/mp4
     * @param string $secureUrl Ex: https://secureuri.seusite.com.br/videos/video.mp4
     */
    public static function addVideo($url, $width = null, $height = null, $type = null, $secureUrl = null)
    {
        self::$Videos[] = array(
            'og:video' => $url,
            'og:video:secure_url' => $secureUrl,
            'og:video:type' => $type,
            'og:video:width' => $width,
            'og:video:height' => $height
        );
    }

    /**
     * Adiciona as tags OpenGraph de audio (og:audio)
     * @param string $url Ex: http://www.seusite.com.br/sounds/sound.mp3
     * @param string $type Ex: audio/mpeg
     * @param string $secureUrl Ex: https://secureuri.seusite.com.br/sounds/sound.mp3
     */
    public static function addAudio($url, $type = null, $secureUrl = null)
    {
        self::$Sounds[] = array(
            'og:audio' => $url,
            'og:audio:secure_url' => $secureUrl,
            'og:audio:type' => $type
        );
    }

    /**
     * Adicionar um arquivo CSS a ser incluído no html
     * @param string $src diretório do arquivo css
     * @param string $media Ex: screen and (max-device-width: 800px)
     * @param string $type text/css
     * @param array $attrs Atributos da tag
     */
    public static function addCss($src, $media = 'all', $type = 'text/css', array $attrs = null)
    {
        self::$CSS[] = array(
            'href' => (string)$src,
            'media' => $media ? $media : 'all',
            'type' => !$type ? 'text/css' : $type,
            'attrs' => (array)$attrs,
        );
    }

    /**
     * Adicionar um arquivo JavaScript a ser incluído no html
     * @param string $src
     */
    public static function addJs($src)
    {
        self::$JS[] = (string)$src;
    }

    public static function addScript($script)
    {
        self::$JS[] = "<script type='text/javascript' >{$script}</script>";
    }

    /**
     * Escreve as meta tags
     */
    public static function displayHeader()
    {

        # Charset
        print "<meta charset=\"" . self::$Charset . "\" />";

        $base = base_url();
        print "<base href='{$base}/' />";

        # Viewport
        print "\n\n\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" />\n";

        # Meta Tags
        foreach (self::$SEO as $attr => $prop) {
            # Metatags
            if (is_array($prop)) {
                print "\n\t";
                foreach ($prop as $content => $value) {
                    print "<meta {$attr}=\"{$content}\" content=\"" . htmlspecialchars($value) . "\" />\n\t";
                }
            } # Favicon - Icone da página
            else if ($attr == 'icon' || $attr == 'shortcut' || $attr == 'shortcut icon') {
                print "\n\t";
                $type = strtolower(preg_replace('/^.*\.(.*?)(\?.*)?$/', '$1', $prop));
                print "<link rel=\"icon\" href=\"{$prop}\" />\n\t";
            } # Tags
            else {
                print "\n\t";
                print "<{$attr}>" . htmlspecialchars($prop) . "</{$attr}>\n\t";
            }
        }

        # Imagens
        if (count(self::$Imagens) > 0) {
            print "\n\t";
            print "<!-- OG Imagens -->\n\t";
            foreach (self::$Imagens as $values) {
                foreach ($values as $key => $value) {
                    if ($value != null) {
                        print "<meta property=\"{$key}\" content=\"" . htmlspecialchars($value) . "\" />\n\t";
                    }
                }
            }
        }

        # Vídeos
        if (count(self::$Videos) > 0) {
            print "\n\t";
            print "<!-- OG Vídeos -->\n\t";
            foreach (self::$Videos as $values) {
                foreach ($values as $key => $value) {
                    if ($value != null) {
                        print "<meta property=\"{$key}\" content=\"" . htmlspecialchars($value) . "\" />\n\t";
                    }
                }
                if (end(self::$Videos) !== $values) {
                    print "\n\t";
                }
            }
        }

        # Sounds
        if (count(self::$Sounds) > 0) {
            print "\n\t";
            print "<!-- OG Sound -->\n\t";
            foreach (self::$Sounds as $values) {
                foreach ($values as $key => $value) {
                    if ($value != null) {
                        print "<meta property=\"{$key}\" content=\"" . htmlspecialchars($value) . "\" />\n\t";
                    }
                }
            }
            print "\n\t";
        }

        self::displayCss();

        print "\n\n\t<script src='cdn/js/jquery.min.js' type='text/javascript' ></script>";

        # Html5
        print "\n\n\t<!--[if lt IE 9]>";
        print "\n\t\t<script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\" charset=\"" . self::$Charset . "\" ></script>";
        print "\n\t\t<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\" charset=\"" . self::$Charset . "\" ></script>";
        print "\n\t<![endif]-->\n";
    }

    public static function displayCss()
    {
        # CSS
        if (count(self::$CSS) > 0) {
            print "\n\t";
            print "<!-- Folhas de estilo -->\n\t";
            foreach (self::$CSS as $css) {
                if (preg_match('/<style/i', $css['href'])) {
                    print preg_replace('/[\n\t]/', ' ', trim($css['href'])) . "\n\t";
                } else {
                    print "<link rel=\"stylesheet\" href=\"{$css['href']}\" media=\"{$css['media']}\" type=\"{$css['type']}\" " . htmlAttributes($css['attrs']) . " />\n\t";
                }
            }
        }
    }

    /**
     * Display all scripts
     * @param array $pageVars
     */
    public static function displayFooter(array $pageVars = null)
    {

        print "\n\t";
        print "<!-- JavaScript -->\n\t";
        print "<script type='text/javascript' >"
            . "\n\t\tvar URL_APP = '" . base_url() . "';"
            . "\n\t\tvar URL_MODULE = '" . url() . "';"
            . "\n\t\tvar CONTROLLER = '" . addslashes(APP::getControllerName()) . "';"
            . "\n\t\tvar ACTION = '" . APP::getAction() . "';"
            . "\n\t\tvar MODULE = '" . APP::getCurrentModule() . "';"
            . "\n\t\tvar MODULE_DEFAULT = '" . APP::getDefaultModule() . "';"
            . "\n\t\tvar PAGE_VARS = '" . json_encode((array)$pageVars) . "';"
            . "\n\t\tconst IS_LOCAL = " . (IS_LOCAL ? 1 : 0) . ";"
            . "\n\t</script>\n\t";

        if (count(self::$JS) > 0) {
            foreach (self::$JS as $src) {
                if (strpos($src, '<script') !== false) {
                    print "{$src}\n\t";
                } else {
                    print "<script type=\"text/javascript\" language=\"javascript\" src=\"{$src}\" charset=\"" . self::$Charset . "\" ></script>\n\t";
                }
            }
        }
    }

    /**
     * Retorna todo o conteúdo registrado no SEO
     * @return array
     */
    public static function getSeo()
    {
        return self::$SEO;
    }

}
    
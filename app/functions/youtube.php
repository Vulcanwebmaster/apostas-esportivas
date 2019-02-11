<?php

use app\helpers\Cache;

function video_img($url = null, $dimencao = -1)
{
    return call_user_func(video_type($url) . '_img', $url, $dimencao);
}

function video_embed($url, $autoplay = false, $showinfo = false, $controles = true, $videosSugeridos = false)
{
    if ($url)
        return call_user_func(video_type($url) . '_embed', $url, $autoplay, $showinfo, $controles, $videosSugeridos);
}

function video_codigo($url)
{
    return call_user_func(video_type($url) . '_codigo', $url);
}

function video_iframe($url, $autoPlay = 0, $showTitle = 0)
{
    return call_user_func(video_type($url) . '_iframe', $url, $autoPlay, $showTitle);
}

function video_type($url)
{
    if (video_is_youtube($url)) {
        return 'youtube';
    } else if (video_is_vimeo($url)) {
        return 'vimeo';
    }
}

function video_is_youtube($url)
{
    return strpos($url, 'youtu') !== false;
}

function video_is_vimeo($url)
{
    return strpos($url, 'vimeo') !== false;
}

/**
 * Retorna a url da imagem do vídeo
 * @param string $url
 * @param int $dimencao
 * @return string
 */
function youtube_img($url, $dimencao = -1)
{
    //Dimenções 1,2,3: 120x90px ; 0: 480x360px

    $code = youtube_codigo($url);

    if ($dimencao == -1) {
        $dimencao = rand(1, 3);
    } else if ($dimencao > 3 or $dimencao < -1) {
        $dimencao = rand(1, 3);
    }

    return "http://img.youtube.com/vi/$code/$dimencao.jpg";
}

/**
 * Retorna a url da imagem do vídeo
 * @param string $url
 * @param int $dimencao
 * @return string
 */
function vimeo_img($url)
{
    $cache = new Cache('vimeo', 60);
    $content = (array)$cache->getContent();
    $codigo = vimeo_codigo($url);

    if (isset($content[$codigo])) {
        return $content[$codigo];
    } else {
        $url = 'http://vimeo.com/api/v2/video/' . $codigo . '.xml';
        $content[$codigo] = (string)simplexml_load_string(curl_get($url))->video->thumbnail_large;
        $cache->setContent($content);
        return $content[$codigo];
    }
}

/**
 * Retorna o código do vídeo
 * @param string $url
 * @return string
 */
function youtube_codigo($url)
{
    if (preg_match("/[\&\?]v=/", $url)) {
        $result = preg_replace("/.*?[\?\&]v\=(.*)/", "$1", $url);
        $result = preg_replace("/\&.*/", "", $result);
    } else if (preg_match("/youtu\.be/", $url)) {
        $result = end(explode('/', $url));
    } else if (strpos($url, 'embed/') !== false) {
        $result = preg_replace('/.*embed\/(.*?)($|\?.*)/', '$1', $url);
    } else {
        $result = $url;
    }
    return trim($result);
}

/**
 * Retorna o código do vídeo no Vimeo
 * @param string $url
 * @return string
 */
function vimeo_codigo($url)
{
    return preg_replace('/.*\//', null, $url);
}

/**
 * Retorna a url EMBED do youtube
 * @param string $url
 * @param boolean $autoplay
 * @param boolean $showinfo
 * @param boolean $controles
 * @param boolean $videosSugeridos
 * @return string
 */
function youtube_embed($url, $autoplay = false, $showinfo = false, $controles = true, $videosSugeridos = false)
{
    $parans = [
        'autoplay' => $autoplay ? 1 : 0,
        'showinfo' => $showinfo ? 1 : 0,
        'rel' => $videosSugeridos ? 1 : 0,
        'controls' => $controles ? 1 : 0,
        'autohide' => 1,
    ];
    return 'https://www.youtube.com/embed/' . youtube_codigo($url) . '?' . http_build_query($parans);
}

/**
 * Retorna o player de vídeo
 * @param string $url
 * @param boolean $autoPlay
 * @param boolean $showTitle
 * @return string
 */
function youtube_iframe($url, $autoPlay = false, $showTitle = false)
{
    return "<iframe src='" . youtube_embed($url, $autoPlay, $showTitle) . "' frameborder='0' allowfullscreen></iframe>";
}

function vimeo_embed($url, $autoPlay = false)
{
    return "https://player.vimeo.com/video/" . vimeo_codigo($url) . "?autoplay=" . ($autoPlay ? 1 : 0) . "&title=0&byline=0&portrait=0";
}

function vimeo_iframe($url, $autoPlay = false)
{
    return "<iframe src='" . vimeo_embed($url, $autoPlay) . "' frameborder='0' allowfullscreen></iframe>";
}

/*

  Configurações do embed do flash player

  rel
  //Valores: 0 ou 1. O padrão é 1. Define se o player deve carregar vídeos relacionados depois que a reprodução do vídeo inicial é iniciada.

  autoplay
  //Valores: 0 ou 1. O padrão é 0. Define se o vídeo inicial será reproduzido automaticamente ou não quando o player for carregado.

  loop
  //Valores: 0 ou 1. O padrão é 0. No caso de um único player de vídeo, uma configuração igual a 1 fará com que o player reproduza o vídeo inicial repetidamente.

  enablejsapi
  //Valores: 0 ou 1. O padrão é 0. Se esse parâmetro for definido como 1, a API JavaScript será ativada.

  playerapiid
  //O valor pode ser qualquer string alfanumérica. Essa configuração é usada em conjunto com a API JavaScript. Consulte a documentação da API JavaScript para obter informações detalhadas.

  disablekb
  //Valores: 0 ou 1. O padrão é 0. Se esse parâmetro for definido como 1, os controles de teclado do player serão desativados. Estes são os controles de teclado:
  Barra de espaço: Reproduzir/Pausar
  Seta para a esquerda: Voltar 10% no vídeo atual
  Seta para a direita: Avançar 10% no vídeo atual
  Seta para cima: Aumentar o volume
  Seta para baixo: Diminuir o volume

  egm
  //Valores: 0 ou 1. O padrão é 0. Se esse parâmetro for definido como 1, o "Menu gênio avançado" será ativado. Este comportamento faz com que o menu gênio (se existir) seja exibido quando o mouse do usuário entrar na área de exibição do vídeo, em vez de ser exibido apenas quando o botão do menu for pressionado.

  border
  //Valores: 0 ou 1. O padrão é 0. Se esse parâmetro for definido como 1, uma borda ao redor de todo o player de vídeo será ativada. A cor primária da borda pode ser definida pelo parâmetro color1 e uma cor secundária pode ser definida pelo parâmetro color2.

  color1, color2
  //Valores: qualquer valor de RGB em formato hexadecimal. color1 é a cor primária da borda e color2 é a cor de fundo da barra de controles do vídeo e a cor secundária da borda.

  start
  //Valores: um número inteiro positivo. Este parâmetro faz com que o player comece a reproduzir o vídeo no segundo determinado, contando a partir do início do vídeo. Observe que, assim como a função seekTo, o player procurará o frame principal mais próximo ao tempo que você especificar. Isso significa que, às vezes, o cabeçote de reprodução pode avançar para um pouco antes do tempo solicitado (normalmente, não excede 2 segundos).

  fs
  //Valores: 0 ou 1. O padrão é 0. Se esse parâmetro for definido como 1, o botão de tela cheia será ativado. Isso não tem nenhum efeito no Player sem cromo. Observe que você deve incluir alguns argumentos extras no seu código de incorporação para que ele funcione. As partes em negrito no exemplo a seguir ativam a funcionalidade de tela cheia:

  hd
  //Valores: 0 ou 1. O padrão é 0. Se esse parâmetro for definido como 1, a reprodução em alta definição será ativada por padrão. Isso não tem nenhum efeito no Player sem cromo. Isso também não terá efeito se não houver uma versão em alta definição do vídeo disponível. Se você ativar essa opção, lembre-se de que os usuários com conexão mais lenta poderão não ter uma experiência muito boa, a menos que desativem a opção de Alta Definição. Verifique se o seu player é grande o suficiente para exibir o vídeo na sua resolução original.

  showsearch
  //Valores: 0 ou 1. O padrão é 1. Se esse parâmetro for definido como 0, a caixa de pesquisa não será exibida quando o vídeo for minimizado. Observe que, se o parâmetro rel for definido como 0, a caixa de pesquisa também não será exibida, independentemente do valor de showsearch.

  showinfo
  //Valores: 0 ou 1. O padrão é 1. Definir esse parâmetro como 0 faz com que o player não exiba informações, como o título e a classificação do vídeo, antes de a reprodução ser iniciada.

  iv_load_policy
  //Valores: 1 ou 3. O padrão é 1. Definir esse parâmetro como 1 fará com que as anotações do vídeo sejam mostradas por padrão, enquanto defini-lo como 3 fará com que as anotações não sejam exibidas por padrão.

  cc_load_policy
  //Valores: 1. O padrão é baseado na preferência do usuário. Definir esse parâmetro como 1 fará com que as legendas ocultas sejam mostradas por padrão, mesmo que o usuário tenha desativado as legendas.

 */
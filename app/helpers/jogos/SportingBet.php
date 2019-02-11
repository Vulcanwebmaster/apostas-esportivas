<?php

namespace app\helpers\jogos;

use app\models\TabelasOnlineModel;

class SportingBet
{

    const TYPE = 'sportingbet';
    const COOKIE = 'ASP.NET_SessionId=a43miazqpb0wj4us0tdlbjml; rStatus=1; sb28_seo_actionList=1; sb28_seo_sessionId=; sb28_seo_ip=; sb28_seo_siteLevel=0; sb28_seo_siteUrl=; sb28_seo_userIp=; sb28_seo_referral=; sb28_seo_domain=; tutorialwelcome=1; SHTS=56; SHTSP=; _ceg.s=; _ceg.u=; __utma=; __utmb=; __utmc=; __utmz=; _ga=; _pk_id.109.65d4=; _pk_ses.109.65d4=; _dc_gtm_UA-32287494-1=; PRUM_EPISODES=; language-com-br=; ili=no';

    private $urls = [];

    public function __construct()
    {
        $this->urls = $this->carregaUrls(self::TYPE);
    }

    /**
     * Carrega as URL's dos jogos
     */
    public static function carregaUrls($type)
    {
        $urls = [];
        foreach (TabelasOnlineModel::lista("WHERE a.type = :type AND a.status = 1 AND :mes BETWEEN a.mesinicio AND a.mesfim ORDER BY a.mesinicio ASC", [
            'type' => $type,
            'mes' => (int)date('m'),
        ]) as $url) {
            $urls[$url->getTitle()] = $url->getUrl();
        }
        return $urls;
    }

    public function addUrl($url)
    {
        $this->urls[] = $url;
        return $this;
    }

    public function getHtml($carregarJogos = false)
    {
        return $this->carregarJogos($this->urls, self::COOKIE);
    }

    public static function carregarJogos($urls, $cookie)
    {
        $html = '';
        foreach ($urls as $campeonato => $url) {
            $lista = self::curl($url, $cookie);
            $lista = str_replace(["\n", "\r", "\t"], null, $lista);
            $lista = preg_replace(['/<script.*?<\/script>/', '/<style.*?<\/style>/', '/<img.*?>/', '/<link.*?>/'], null, $lista);
            $lista = '<div data-campeonato="' . $campeonato . '" >' . $lista . '</div>';
            $html .= $lista;
        }
        return $html;
    }

    private static function curl($url, $cookie)
    {

        $parse = parse_url($url);

        if (!empty($parse['host'])) {

            $options = [
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => false, // don't return headers
                CURLOPT_FOLLOWLOCATION => false, // follow redirects
                CURLOPT_ENCODING => "", // handle all encodings
                CURLOPT_COOKIE => $cookie,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', // who am i
                CURLOPT_AUTOREFERER => false,
                CURLOPT_CONNECTTIMEOUT => 60 * 0.5,
                CURLOPT_TIMEOUT => 60 * 2,
                CURLOPT_MAXREDIRS => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_BINARYTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Host: ' . $parse['host']],
                CURLOPT_URL => $url,
                CURLOPT_REFERER => 'application/x-www-form-urlencoded; charset=UTF-8',
            ];

            $ch = curl_init();

            curl_setopt_array($ch, $options);

            $content = curl_exec($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $header = curl_getinfo($ch);

            curl_close($ch);

            $header['errno'] = $err;
            $header['errmsg'] = $errmsg;
            $header['content'] = $content;

            if ($err == 0) {
                return $content;
            }
        }
        return null;
    }

}
    
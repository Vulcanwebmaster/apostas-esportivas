<?php

namespace app\helpers\jogos;

class GloboEsporte
{

    const TYPE = 'globoesporte';
    private $urls;
    private $cookie = '';

    public function __construct()
    {
        $this->urls = SportingBet::carregaUrls(self::TYPE);
    }

    public function getHtml()
    {
        return SportingBet::carregarJogos($this->urls, $this->cookie);
    }

}
    
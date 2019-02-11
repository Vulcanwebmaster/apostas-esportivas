<?php

namespace app\helpers\jogos;

class BetExplorer
{

    const TYPE = 'betexplorer';
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
    
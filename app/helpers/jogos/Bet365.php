<?php

namespace app\helpers\jogos;

class Bet365
{

    const TYPE = 'bet365';
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
    
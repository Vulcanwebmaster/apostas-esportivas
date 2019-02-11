<?php

namespace app\traits\vo;

trait urlAmigavel
{

    protected $UrlAmigavel;

    function checkUrlAmigavel()
    {
        if (!$this->getUrlAmigavel()) {
            throw new \Exception("Informe a URL amigável.");
        } else if (!$this->voModel()->lista("WHERE a.urlamigavel = :url AND a.id != :id AND a.status != 99 LIMIT 1", ['url' => $this->getUrlAmigavel(), 'id' => $this->getId()])) {
            return true;
        } else {
            return false;
        }
    }

    function getUrlAmigavel()
    {
        return $this->UrlAmigavel ? substr(url_paranformat(trim($this->UrlAmigavel)), 0, 250) : null;
    }

    function setUrlAmigavel($UrlAmigavel)
    {
        $this->UrlAmigavel = $UrlAmigavel;
    }

}
    
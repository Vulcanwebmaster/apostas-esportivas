<?php
/**
 * Created by PhpStorm.
 * User: Xolenno
 */

namespace app\traits\vo;


trait redes
{

    private $facebook;
    private $twitter;
    private $instagram;
    private $linkedin;
    private $googlePlus;
    private $site;

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     * @return $this
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }


    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     * @return $this
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     * @return $this
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     * @return $this
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * @param string $linkedin
     * @return $this
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    /**
     * @return string
     */
    public function getGooglePlus()
    {
        return $this->googlePlus;
    }

    /**
     * @param string $googlePlus
     * @return $this
     */
    public function setGooglePlus($googlePlus)
    {
        $this->googlePlus = $googlePlus;
        return $this;
    }


}
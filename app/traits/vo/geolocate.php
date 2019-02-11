<?php

namespace app\traits\vo;

trait geolocate
{

    private $latitude;
    private $longitude;
    private $zoom;

    public function getLatitude()
    {
        return (float)$this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude()
    {
        return (float)$this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getZoom()
    {
        return (int)$this->zoom;
    }

    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        return $this;
    }

}
    
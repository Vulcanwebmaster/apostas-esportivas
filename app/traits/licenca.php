<?php

namespace app\traits;

use app\models\LicencasModel;
use app\vo\LicencaVO;

trait licenca
{

    private $licenca;

    /**
     * @return mixed
     */
    public function getLicencaTitle()
    {
        if ($l = $this->voLicenca())
            return $l->getTitle();
    }

    /**
     * @return LicencaVO|null
     */
    public function voLicenca()
    {
        return LicencasModel::getByLabel('id', $this->getLicenca());
    }

    /**
     * @return mixed
     */
    public function getLicenca()
    {
        return (int)$this->licenca;
    }

    /**
     * @param mixed $licenca
     * @return $this
     */
    public function setLicenca($licenca)
    {
        $this->licenca = $licenca;
        return $this;
    }

}
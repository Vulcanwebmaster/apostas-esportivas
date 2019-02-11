<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 11/09/2017
 * Time: 19:25
 */

namespace app\traits\vo;


use app\models\admin\MenuModel;
use app\models\ApostasModel;
use app\models\CampeonatosModel;
use app\models\CotacoesModel;
use app\models\financeiro\DepositosModel;
use app\models\financeiro\SaquesModel;
use app\models\IndicacoesModel;
use app\models\JogosModel;
use app\models\TimesModel;
use app\models\UsersModel;

trait voRef
{

    private $ref;
    private $refType;
    private $refId;

    /**
     * @return \app\core\ValueObject|null
     */
    public function voRef()
    {
        switch ($this->getRef()) {
            case ApostasModel::getTable();
                return ApostasModel::getByLabel('id', $this->getRefId());
                break;
            case UsersModel::getTable():
                return UsersModel::getByLabel('id', $this->getRefId());
                break;
            case IndicacoesModel::getTable():
                return IndicacoesModel::getByLabel('id', $this->getRefId());
                break;
            case DepositosModel::getTable():
                return DepositosModel::getByLabel('id', $this->getRefId());
                break;
            case SaquesModel::getTable():
                return SaquesModel::getByLabel('id', $this->getRefId());
                break;
            case MenuModel::getTable():
                return MenuModel::getByLabel('id', $this->getRefId());
                break;
            case TimesModel::getTable():
                return TimesModel::getByLabel('id', $this->getRefId());
                break;
            case CampeonatosModel::getTable():
                return CampeonatosModel::getByLabel('id', $this->getRefId());
                break;
            case CotacoesModel::getTable():
                return CotacoesModel::getByLabel('id', $this->getRefId());
                break;
            case JogosModel::getTable();
                return JogosModel::getByLabel('id', $this->getRefId());
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getRefType()
    {
        return $this->refType;
    }

    /**
     * @param mixed $refType
     * @return $this
     */
    public function setRefType($refType)
    {
        $this->refType = $refType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     * @return $this
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefId()
    {
        return (int)$this->refId;
    }

    /**
     * @param mixed $refId
     * @return $this
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;
        return $this;
    }

}
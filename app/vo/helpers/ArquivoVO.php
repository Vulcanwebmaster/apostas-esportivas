<?php

namespace app\vo\helpers;

use app\core\ValueObject;
use app\helpers\Utils;

class ArquivoVO extends ValueObject
{

    private $refTable;
    private $ref;
    private $refId;
    private $source;

    /**
     * @return null|string
     */
    public function getExtension()
    {
        return Utils::getFileExtension($this->getSource());
    }

    /**
     * @param bool $url
     * @return string
     */
    public function getSource($url = false)
    {
        return ($url and $this->source) ? source_files($this->source) : $this->source;
    }

    /**
     * @param $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefTable()
    {
        return (string)$this->refTable;
    }

    /**
     * @param $refTable
     * @return $this
     */
    public function setRefTable($refTable)
    {
        $this->refTable = $refTable;
        return $this;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return (string)$this->ref;
    }

    /**
     * @param $ref
     * @return $this
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @return int
     */
    public function getRefId()
    {
        return (int)$this->refId;
    }

    /**
     * @param $refId
     * @return $this
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;
        return $this;
    }

    function excluir()
    {
        parent::excluir();
        $file = abs_source_files($this->getSource());
        if (file_exists($file) and is_file($file)) {
            unlink($file);
        }
    }

}
    
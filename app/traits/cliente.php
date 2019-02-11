<?php

namespace app\traits;

use app\models\ClientesModel;

trait cliente
{

    private $cliente;

    public function voCliente()
    {
        return ClientesModel::getByLabel('id', $this->getCliente());
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return (int)$this->cliente;
    }

    /**
     * @param mixed $cliente
     * @return $this
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }

}
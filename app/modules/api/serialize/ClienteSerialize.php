<?php

namespace app\modules\api\serialize;

use app\vo\ClienteVO;

class ClienteSerialize implements \JsonSerializable
{

    private $cliente;

    /**
     * @param ClienteVO $cliente
     */
    public function __construct(ClienteVO $cliente)
    {
        $this->cliente = $cliente;
    }

    public function jsonSerialize()
    {
        $v = $this->cliente;
        return [
            'id' => $v->getId(),
            'nome' => $v->getNome(),
        ];
    }


}
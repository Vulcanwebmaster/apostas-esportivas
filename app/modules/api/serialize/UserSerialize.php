<?php

namespace app\modules\api\serialize;

use app\vo\UserVO;

class UserSerialize implements \JsonSerializable
{

    private $user;

    public function __construct(UserVO $user)
    {
        $this->user = $user;
    }

    function jsonSerialize()
    {
        return [
            'img' => $this->user->imgCapa()->redimensiona(200, 200),
            'nome' => $this->user->getNome(),
            'email' => $this->user->getEmail(),
            'creditos' => $this->user->getCredito(),
        ];
    }

}
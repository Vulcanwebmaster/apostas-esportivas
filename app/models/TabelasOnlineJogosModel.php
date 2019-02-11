<?php

namespace app\models;

use app\core\Model;
use app\vo\TabelaOnlineJogoVO;

class TabelasOnlineJogosModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_tabelas_online_jogos';
        $this->valueObject = TabelaOnlineJogoVO::class;
    }

}
    
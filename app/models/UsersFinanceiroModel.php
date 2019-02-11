<?php

namespace app\models;

use app\core\Model;
use app\vo\UserFinanceiroVO;

class UsersFinanceiroModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_users_financeiro';
        $this->valueObject = UserFinanceiroVO::class;
    }

}
    
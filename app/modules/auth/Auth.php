<?php

namespace app\modules\auth;

class Auth
{

    public function __construct()
    {
        session_cache_limiter('nocache');
    }

}
    
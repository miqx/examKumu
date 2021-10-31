<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

class GitUserHelper
{
    public function isRequestValid(String $data)
    {
        if(empty($data))
        {
            return false;
        }

        $userArray = explode(',' ,$data);

        $userArray = collect($userArray)->unique();

        if($userArray->count() > 10)
        {
            return false;
        }

        return true;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GitUserHelper;
use Illuminate\Support\Facades\Redis;

class GithubController extends Controller
{
    public function getGitUsers(Request $data)
    {
        $isValid = (new GitUserHelper)->isRequestValid($data->user);

        if(!$isValid)
        {
            return response('must not exceed  10 users or must not be empty', 500);
        }

        $responseArray = [];
        $users = collect(explode(',', $data->user));

        foreach($users as $user)
        {
            if(Redis::exists("gitUser_{$user}"))
            {
                $responseArray[] = json_decode(Redis::get("gitUser_{$user}"));
                continue;
            }

            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/{$user}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user-agent: curl',
            ));
            $res = curl_exec($ch);
            curl_close($ch);

            if(!empty($res))
            {
                $responseArray[] = json_decode($res);
                Redis::set("gitUser_{$user}", $res, 'EX', 120);
            }
        }

        return response()->json($responseArray, 200);
    }
}

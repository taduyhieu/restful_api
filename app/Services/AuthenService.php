<?php

namespace App\Services;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenService
{
    public function setToken($data = [], $timeExpire = '') 
    {
        if ($timeExpire) {
            $data['exp'] = $timeExpire;
        }
        $encoded = JWT::encode($data, env('JWT_SECRET'), 'HS256');
        return $encoded;
    }

    public function deToken($access_token) 
    {
        try {
            $tokenArray = JWT::decode($access_token, new Key(env('JWT_SECRET'), 'HS256'));
            return $tokenArray;
        } catch (\Firebase\JWT\ExpiredException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setTimeExpireForToken () 
    {
        return time() + 60 * 60 * 24 * 30;
    }

    public function getTimeNow($timeNow)
    {
        $array = explode('-', $timeNow);
        $time  = (int)($array[0]) * 60 * 60 + (int)($array[1]) * 60 + (int)$array[2];
        return $time;
    }

}

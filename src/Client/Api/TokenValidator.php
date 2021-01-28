<?php

namespace AwemaPL\BaselinkerClient\Client\Api;
use AwemaPL\BaselinkerClient\Client\BaselinkerClient;
use AwemaPL\BaselinkerClient\Client\BaselinkerApiException;

class TokenValidator
{
    /**
     * Is valid token
     *
     * @param $token
     * @return bool
     */
    public static function isValidToken($token)
    {
        $baselinkerClient = new BaselinkerClient(['token' =>$token]);
        try{
            $baselinkerClient->storages()->getStoragesList();
            return true;
        } catch (BaselinkerApiException $e){
            return false;
        }
    }
}

<?php

namespace AwemaPL\BaselinkerClient\Facades;

use AwemaPL\BaselinkerClient\Contracts\BaselinkerClient as BaselinkerClientContract;
use Illuminate\Support\Facades\Facade;

class BaselinkerClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BaselinkerClientContract::class;
    }
}

<?php

namespace AwemaPL\BaselinkerClient\Client\Contracts;

use AwemaPL\BaselinkerClient\Client\Api\Request\Contracts\Order as OrderContract;
use AwemaPL\BaselinkerClient\Client\Api\Request\Contracts\Storage as StorageContract;
use AwemaPL\BaselinkerClient\Client\Config;

interface BaselinkerClient
{
    /**
     * Orders
     *
     * @return OrderContract
     */
    public function orders(): OrderContract;

    /**
     * Storages
     *
     * @return StorageContract
     */
    public function storages(): StorageContract;

    /**
     * Get config
     *
     * @return Config
     */
    public function getConfig(): Config;
}

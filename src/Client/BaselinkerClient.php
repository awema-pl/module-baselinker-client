<?php

namespace AwemaPL\BaselinkerClient\Client;

use AwemaPL\BaselinkerClient\Client\Api\Request\Contracts\Order as OrderContract;
use AwemaPL\BaselinkerClient\Client\Api\Request\Contracts\Storage as StorageContract;
use AwemaPL\BaselinkerClient\Client\Api\Request\Order;
use AwemaPL\BaselinkerClient\Client\Api\Request\Storage;
use AwemaPL\BaselinkerClient\Client\Contracts\BaselinkerClient as BaselinkerClientContract;

class BaselinkerClient implements BaselinkerClientContract
{
    /** @var Config $config */
    private $config;

    public function __construct(array $parameters)
    {
        $this->config = new Config($parameters);
    }

    /**
     * Orders
     *
     * @return OrderContract
     */
    public function orders(): OrderContract
    {
        return new Order($this->config);
    }

    /**
     * Storages
     *
     * @return StorageContract
     */
    public function storages(): StorageContract
    {
        return new Storage($this->config);
    }


    /**
     * Get config
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

}

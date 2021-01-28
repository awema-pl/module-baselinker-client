<?php

namespace AwemaPL\BaselinkerClient\Client\Api\Services\Storages\Contracts;
use AwemaPL\BaselinkerClient\Client\Api\Request\Contracts\Storage;
use AwemaPL\BaselinkerClient\Client\BaselinkerApiException;

interface GetAllProductsQuantityAsArray
{
    /**
     * Get all products quantity as array
     *
     * @param Storage $storageClient
     * @param array $parameters
     * @param array $options
     * @return array
     * @throws BaselinkerApiException
     */
    public function getAsArray(Storage $storageClient, array $parameters = [], array $options = []): array;
}

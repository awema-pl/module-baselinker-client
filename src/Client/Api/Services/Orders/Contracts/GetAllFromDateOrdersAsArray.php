<?php

namespace AwemaPL\BaselinkerClient\Client\Api\Services\Orders\Contracts;
use AwemaPL\BaselinkerClient\Client\Api\Request\Contracts\Order;
use AwemaPL\BaselinkerClient\Client\BaselinkerApiException;

interface GetAllFromDateOrdersAsArray
{
    /**
     * Get all from date orders as array
     *
     * @param Order $orderClient
     * @param array $parameters
     * @param array $options
     * @return array
     * @throws BaselinkerApiException
     */
    public function getAsArray(Order $orderClient, array $parameters = [], array $options = []): array;
}

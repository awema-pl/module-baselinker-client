<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Repositories\Contracts;

use AwemaPL\BaselinkerClient\Client\BaselinkerApiException;
use Illuminate\Http\Request;
use InvalidArgumentException;

interface AccountRepository
{
    /**
     * Create account
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Scope account
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);
    
    /**
     * Update account
     *
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id);
    
    /**
     * Delete account
     *
     * @param int $id
     */
    public function delete($id);

    /**
     * Statuses account
     *
     * @param int $id
     * @return array[]
     * @throws BaselinkerApiException
     */
    public function statuses($id);

    /**
     * Select storage
     *
     * @param int $id
     * @return array[]
     * @throws BaselinkerApiException
     */
    public function selectStorage($id);

    /**
     * Storage name by storage ID
     *
     * @param int $id
     * @param string $storageId
     * @return string
     * @throws InvalidArgumentException
     */
    public function storageNameById(int $id, string $storageId): string;
}

<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Repositories;

use AwemaPL\BaselinkerClient\Client\BaselinkerApiException;
use AwemaPL\BaselinkerClient\Client\BaselinkerClient;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Models\Account;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Repositories\Contracts\AccountRepository;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Scopes\EloquentAccountScopes;
use AwemaPL\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class EloquentAccountRepository extends BaseRepository implements AccountRepository
{
    protected $searchable = [

    ];

    public function entity()
    {
        return Account::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentAccountScopes($request))->scope($this->entity);

        return $this;
    }

    /**
     * Create new role
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        return Account::create($data);
    }

    /**
     * Update account
     *
     * @param array $data
     * @param int $id
     * @param string $attribute
     *
     * @return int
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        return parent::update($data, $id, $attribute);
    }

    /**
     * Delete account
     *
     * @param int $id
     */
    public function delete($id){
        $this->destroy($id);
    }

    /**
     * Statuses account
     *
     * @param int $id
     * @return array[]
     * @throws BaselinkerApiException
     */
    public function statuses($id)
    {
        $account = Account::find($id);
        $baselinkerClient = new BaselinkerClient(['token' =>$account->api_token]);
        $orderStatusList = $baselinkerClient->orders()->getOrderStatusList()->toArray();
        $statuses = [];
        foreach ($orderStatusList['statuses'] ?? [] as $status){
            array_push($statuses, [
               'id' => (int)$status['id'],
               'name' =>sprintf('%s (%s)', $status['name'], $status['name_for_customer'])
            ]);
        }
        return $statuses;
    }

    /**
     * Select storage
     *
     * @param int $id
     * @return array[]
     * @throws BaselinkerApiException
     */
    public function selectStorage($id){
        $account = Account::find($id);
        $baselinkerClient = new BaselinkerClient(['token' =>$account->api_token]);
        $storages = $baselinkerClient->storages()->getStoragesList()->toArray();
        $data = [];
        foreach ($storages['storages'] ?? [] as $storage){
            array_push($data, [
                'id' => $storage['storage_id'],
                'name' =>$storage['name']
            ]);
        }
        return $data;
    }

    /**
     * Storage name by storage ID
     *
     * @param int $id
     * @param string $storageId
     * @return string
     * @throws InvalidArgumentException
     */
    public function storageNameById(int $id, string $storageId): string{
        $account = Account::findOrFail($id);
        $baselinkerClient = new BaselinkerClient(['token' =>$account->api_token]);
        $storages = $baselinkerClient->storages()->getStoragesList()->toArray();
        foreach ($storages['storages'] ?? [] as $storage){
            if ($storage['storage_id'] === $storageId) {
                return $storage['name'];
            }
        }
        throw new InvalidArgumentException("Not found Baselinker storage $storageId for account $account->email.");
    }
}

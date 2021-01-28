<?php
namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Policies;

use AwemaPL\BaselinkerClient\User\Sections\Accounts\Models\Account;
use Illuminate\Foundation\Auth\User;

class AccountPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User $user
     * @param  Account $account
     * @return bool
     */
    public function isOwner(User $user, Account $account)
    {
        return $user->id === $account->user_id;
    }


}

<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Models\Contracts;

use AwemaPL\Task\User\Sections\Statuses\Models\Contracts\Taskable;

interface Account extends Taskable
{

    /**
     * Get the user that owns the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user();

}

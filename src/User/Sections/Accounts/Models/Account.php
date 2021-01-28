<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Models;

use AwemaPL\BaselinkerClient\Sections\Options\Models\Option;
use AwemaPL\BaselinkerClient\Sections\Applications\Models\Application;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Models\Contracts\Account as AccountContract;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;

class Account extends Model implements AccountContract
{

    use EncryptableDbAttribute;

    /** @var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
        'api_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id','email', 'api_token'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'sandbox' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('baselinker-client.database.tables.baselinker_client_accounts');
    }

    /**
     * Get the user that owns the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(config('auth.providers.users.model'));
    }
 
}

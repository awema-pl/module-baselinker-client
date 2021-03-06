<?php

namespace AwemaPL\BaselinkerClient\Admin\Sections\Settings\Models;

use AwemaPL\BaselinkerClient\Sections\Options\Models\Option;
use AwemaPL\BaselinkerClient\Sections\Applications\Models\Application;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Model;
use AwemaPL\BaselinkerClient\Admin\Sections\Settings\Models\Contracts\Setting as SettingContract;

class Setting extends Model implements SettingContract
{

    use EncryptableDbAttribute;

    /** @var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
        'value',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'key', 'value'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

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
        return config('baselinker-client.database.tables.baselinker_client_settings');
    }
}

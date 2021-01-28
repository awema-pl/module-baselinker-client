<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Requests\Rules;
use AwemaPL\BaselinkerClient\Client\Api\TokenValidator;
use Illuminate\Contracts\Validation\Rule;

class ApiTokenValid implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return TokenValidator::isValidToken($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return _p('baselinker-client::requests.user.account.messages.enter_valid_api_token', 'Please enter a valid API token.');
    }
}

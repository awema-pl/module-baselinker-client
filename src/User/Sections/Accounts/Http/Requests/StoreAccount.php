<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Requests;

use AwemaPL\BaselinkerClient\Sections\Options\Models\Option;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Requests\Rules\ApiTokenValid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255',  Rule::unique(config('baselinker-client.database.tables.baselinker_client_accounts'))->where(function ($query) {
                return $query->where('email', $this->email)
                    ->where('user_id', $this->user()->id);
            })],
            'api_token' => ['required','string','max:65535', new ApiTokenValid()],
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => _p('baselinker-client::requests.user.account.attributes.email', 'e-mail'),
            'api_token' => _p('baselinker-client::requests.user.account.attributes.api_token', 'API token'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}

<?php

namespace AwemaPL\BaselinkerClient\Admin\Sections\Settings\Resources;

use AwemaPL\BaselinkerClient\Sections\Options\Resources\EloquentOption;
use AwemaPL\BaselinkerClient\Sections\Applications\Resources\EloquentApplication;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EloquentSetting extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}

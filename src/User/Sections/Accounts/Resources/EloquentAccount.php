<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EloquentAccount extends JsonResource
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
            'email' => $this->email,
            'api_token' => $this->api_token,
            'created_at' =>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use JsonSerializable;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => Storage::url($this->avatar->url),
            'email' => $this->email,
            'about' => $this->about,
            'full_name' => $this->full_name,
            'subscriptions_count' => $this->subscriptions_count,
            'subscribers_count' => $this->subscribers_count,
            'is_following' => $this->is_following,
        ];
    }
}

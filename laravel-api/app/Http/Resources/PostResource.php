<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use JsonSerializable;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'image' => Storage::url($this->image->url),
            'user' => new UserResource($this->user),
            'likes_count' => $this->likes_count,
            'is_like_pressed' => $this->is_like_pressed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

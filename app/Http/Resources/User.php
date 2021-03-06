<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture === null ? null : base64_encode(Storage::get($this->profile_picture)),
            'summary' => $this->summary,
            'follows' => Follow::collection($this->follows),
            'followings' => Follow::collection($this->followings),
            'posts' => $this->posts,
        ];
    }
}

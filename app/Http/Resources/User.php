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
            'profile_picture' => $this->profile_picture,
            'summary' => $this->summary,
            'followers' => $this->followers,
            'following' => $this->following,
            'posts' => $this->posts,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->user_id);

        return [
            'id' => $this->id,
            'content' => $this->content,
            'photo_id' => $this->photo_id,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'profile_picture' => $user->profile_picture === null ? null : base64_encode(Storage::get($this->profile_picture)),
            ],
            'likes' => $this->likes,
        ];
    }
}


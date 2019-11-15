<?php

namespace App\Http\Resources;

use http\Env\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Like;
use App\Comment;

class Photo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $comment_number = Comment::where('photo_id', $this->id)->count();
        $like_number = Like::where('photo_id', $this->id)->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'likes' => $like_number,
            'comments' => $comment_number,
            'content' => base64_encode(Storage::get($this->name))
        ];
    }
}

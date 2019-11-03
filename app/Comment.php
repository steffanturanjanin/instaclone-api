<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    private $id;
    private $content;
    private $photo_id;
    private $user_id;
    private $likes;

    public function photo () {
        return $this->belongsTo('App\Photo');
    }
}

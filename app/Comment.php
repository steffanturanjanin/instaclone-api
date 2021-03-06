<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function photo () {
        return $this->belongsTo('App\Photo');
    }
}

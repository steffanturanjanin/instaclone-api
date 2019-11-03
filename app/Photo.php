<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    private $id;
    private $name;
    private $description;
    private $user_id;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }
}

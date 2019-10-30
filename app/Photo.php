<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    private $id;
    private $name;
    private $description;
    private $url;
    private $user_id;

    public function user() {
        return $this->belongsTo('App\User');
    }
}

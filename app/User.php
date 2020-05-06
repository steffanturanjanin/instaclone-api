<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    private $id;
    private $username;
    private $email;
    private $profile_picture;
    private $summary;
    private $followers;
    private $following;
    private $posts;

    public function photos() {
        return $this->hasMany('App\Photo');
    }

    public function follows() {
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
    }

    public function followings() {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

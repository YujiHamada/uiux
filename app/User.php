<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_image_path',
        'social', 'social_uid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // public function getFollowing(){
    //   return $this->hasMany('App\Follow', 'user_id', 'id')->get();
    // }

    public function getFollowing(){
      $followUserIds = $this->hasMany('App\Follow', 'user_id', 'id')->select('follow_id')->get();
      return User::whereIn('id', $followUserIds)->get();
    }

    public function getFollowCount(){
      return $this->getFollowing()->count();
    }

    public function getFollowers(){
      $followerUserIds = $this->hasMany('App\Follow', 'follow_id', 'id')->select('user_id')->get();
      return User::whereIn('id', $followerUserIds)->get();
    }

    public function getFollowerCount(){
      return $this->getFollowers()->count();
    }
}

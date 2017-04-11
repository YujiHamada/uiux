<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Follow;
use Auth;


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

    // フォローしているユーザを取得する
    public function getFollowing() {
      $followUserIds = $this->hasMany('App\Follow', 'user_id', 'id')->select('follow_id')->get();
      return User::whereIn('id', $followUserIds)->get();
    }

    // フォローしているユーザをカウントする
    public function getFollowCount() {
      return $this->getFollowing()->count();
    }

    // フォロワーを取得する
    public function getFollowers() {
      $followerUserIds = $this->hasMany('App\Follow', 'follow_id', 'id')->select('user_id')->get();
      return User::whereIn('id', $followerUserIds)->get();
    }

    // フォロワーの数をカウントする
    public function getFollowerCount() {
      return $this->getFollowers()->count();
    }

    // ログインユーザにフォローされているかチェックする
    public function isFollowed() {
      $follow = $this->hasMany('App\Follow', 'follow_id', 'id')->where('user_id', Auth::user()->id)->first();
      return isset($follow);
    }

    // ログインユーザからのフォローをセットする
    public function setFollow() {
      $follow = new Follow;
      $follow->user_id = Auth::user()->id;
      $follow->follow_id = $this->id;
      $follow->save();
    }

    // ログインユーザからのフォローを解除する
    public function resetFollow() {
      $follow = $this->hasMany('App\Follow', 'follow_id', 'id')->where('user_id', Auth::user()->id)->delete();
    }
}

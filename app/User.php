<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Follow;
use Auth;
use Carbon\Carbon;
use App\Notifications\HeaderNotification;

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
        'confirmation_token', 'confirmed_at', 'confirmation_sent_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirmation_token', 'confirmed_at', 'confirmation_sent_at'
    ];

    // 日付ミューテーター(Carbonインスタンスに変換される)
    protected $dates = [
        'confirmed_at',
        'confirmation_sent_at',
    ];

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


    // ユーザ確認完了
    public function confirm() {
        $this->confirmed_at = Carbon::now();
        $this->confirmation_token = null;
    }

    // ユーザ確認されているか確認
    public function isConfirmed() {
        return ! empty($this->confirmed_at);
    }

    // 引数で受け取ったユーザーIDのユーザーに通知を送る
    public static function notifyByUserId($userId, $notification) {
      $user = User::find($userId);
      $user->notify(new HeaderNotification($notification));
    }


}

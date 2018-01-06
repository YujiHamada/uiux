<?php

namespace App;
use App\User;
use Auth;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
	protected $table = 'reviews';
  	public $timestamps = true;
  	protected $dates = ['deleted_at'];
	protected $guarded = ['id'];

  	use SoftDeletes;

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function reviewTag() {
		return $this->hasMany('App\ReviewTag');
	}

	public function reviewImages() {
		return $this->hasMany('App\ReviewImage');
	}

	public function agree() {
		return $this->hasMany('App\ReviewEvaluation', 'review_id', 'id');
	}

	public function agreeCount() {
		return $this->agree()->selectRaw('count(*) as count')->where('is_agree','1')->groupBy('is_agree');
	}

	public function disagreeCount() {
		return $this->agree()->selectRaw('count(*) as count')->where('is_agree','0')->groupBy('is_agree');
	}

	public function comments() {
	  return $this->hasMany('App\ReviewComment', 'review_id', 'id')->orderBy('created_at', 'desc');
	}

	public function commentsCount() {
	  return $this->hasMany('App\ReviewComment', 'review_id', 'id')->selectRaw('count(*) as count');
	}

	// 該当のレビュー(this)に対して、自分が評価しているかを確認するために用いるメソッド
	public function myEvaluation() {
	  return $this->hasOne('App\ReviewEvaluation', 'review_id', 'id')->where('user_id', Auth::user()->id);
	}

	public static function updatePageView($id){
		$currentURL = url()->current();
        if($currentURL != session('lastURL')) {
			\DB::table('reviews')->where('id', $id)->increment('page_view');
		}
	}
}

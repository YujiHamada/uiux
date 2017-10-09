<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ReviewComment extends Model
{
    protected $table = 'review_comments';
    protected $fillable = ['review_id', 'user_id', 'comment'];

    public function user(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    // 該当のコメント(this)に対して、自分がコメントしているかを確認するために用いるメソッド
    // イイネ・ワルイネボタンの活性非活性を制御する際に利用
    public function myEvaluation(){
    	return $this->hasOne('App\CommentEvaluation', 'comment_id', 'id')->where('user_id', Auth::user()->id);
    }

    public function evaluations() {
  		return $this->hasMany('App\CommentEvaluation', 'comment_id', 'id');
  	}

    public function agreeCount() {
  		return $this->evaluations()->selectRaw('count(*) as count')->where('is_agree','1')->groupBy('is_agree');
  	}

	  public function disagreeCount() {
  		return $this->evaluations()->selectRaw('count(*) as count')->where('is_agree','0')->groupBy('is_agree');
  	}
}

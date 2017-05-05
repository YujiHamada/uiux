<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Review_Comment extends Model
{
    protected $table = 'review_comments';

    public function user(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function evaluation(){
    	return $this->hasOne('App\Comment_Evaluation', 'comment_id', 'id')->where('user_id', Auth::user()->id);
    }

    public function evaluations() {
  		return $this->hasMany('App\Comment_Evaluation', 'comment_id', 'id');
  	}

    public function agreeCount() {
  		return $this->evaluations()->selectRaw('count(*) as count')->where('is_agree','1')->groupBy('is_agree');
  	}

	public function disagreeCount() {
  		return $this->evaluations()->selectRaw('count(*) as count')->where('is_agree','0')->groupBy('is_agree');
  	}
}

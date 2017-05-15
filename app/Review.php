<?php

namespace App;
use App\User;


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

}

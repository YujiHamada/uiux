<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
		protected $table = 'reviews';
    public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function reviewCategory(){
    	return $this->hasMany('App\Review_Category');
    }

    public function agree(){
    	return $this->hasMany('App\Review_Agree', 'review_id', 'id');
    }

    public function agreeCount(){
    	return $this->agree()->selectRaw('count(*) as count')->where('is_agree','1')->groupBy('is_agree');
    }

    public function disagreeCount(){
    	return $this->agree()->selectRaw('count(*) as count')->where('is_agree','0')->groupBy('is_agree');
    }

}

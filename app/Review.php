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

}

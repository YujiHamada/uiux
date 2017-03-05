<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review_Comment extends Model
{
    protected $table = 'review_comments';

    public function user(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}

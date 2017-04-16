<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review_Tag extends Model
{
    protected $table = 'review_tag';
    public $timestamps = true;

    public function tag(){
    	return $this->hasOne('App\Tag', 'id', 'tag_id');
    }
}

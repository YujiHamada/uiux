<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewTag extends Model
{
    protected $table = 'review_tags';
    public $timestamps = true;

    protected $fillable = [
        'review_id', 'tag_id'
    ];


    public function tag(){
    	return $this->hasOne('App\Tag', 'id', 'tag_id');
    }
}

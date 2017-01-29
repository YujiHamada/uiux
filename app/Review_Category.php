<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review_Category extends Model
{
    protected $table = 'review_category';
    public $timestamps = true;

    public function category(){
    	return $this->hasOne('App\Category', 'id', 'category_id');
    }
}

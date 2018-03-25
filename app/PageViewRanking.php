<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageViewRanking extends Model
{
    protected $table = 'page_view_ranking';
    public $timestamps = true;

    public function review() {
		return $this->belongsTo('App\Review');
	}
}

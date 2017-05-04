<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ScoreHistory extends Model
{
    protected $table = 'score_histories';
    public $timestamps = true;

    protected $fillable = [
        'key', 'user_id', 'score'
    ];



}

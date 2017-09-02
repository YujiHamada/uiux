<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    protected $table = 'review_images';
    public $timestamps = true;

    protected $fillable = [
        'review_id', 'image_name'
    ];

}

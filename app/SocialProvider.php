<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
  protected $table = 'social_providers';
  public $timestamps = true;

  protected $fillable = [
      'user_id', 'social', 'social_uid'
  ];

}

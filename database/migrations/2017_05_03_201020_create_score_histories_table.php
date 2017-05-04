<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreHistoriesTable extends Migration
{
  public function up()
  {
    Schema::create('score_histories', function (Blueprint $table) {
      $table->string('key');
      $table->integer('user_id')->unsigned();
      $table->integer('score')->unsigned();
      $table->timestamps();

      // 制約
      $table->primary('key');
      $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }


  public function down()
  {
    Schema::dropIfExists('score_histories');
  }
}

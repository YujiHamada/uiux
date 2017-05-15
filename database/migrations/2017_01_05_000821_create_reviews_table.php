<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration {

  public function up() {
    Schema::create('reviews', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->tinyInteger('type')->nullable();
      $table->string('title');
      $table->string('description', 400);
      $table->string('url')->nullable();
      $table->string('image_name')->nullable();
      $table->string('domain')->nullable();
      $table->tinyInteger('is_request')->default(false);
      $table->tinyInteger('is_kaizened')->default(false);
      $table->softDeletes();
      $table->timestamps();

      // 制約
      $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }

  public function down() {
    Schema::drop('reviews');
  }
}

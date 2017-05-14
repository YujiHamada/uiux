<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialProvidersTable extends Migration {

  public function up() {
    Schema::create('social_providers', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->enum('social', ['twitter', 'facebook', 'google', 'github'])->nullable(); // ソーシャルログイン出ない場合はnull
      $table->string('social_uid')->nullable(); // ソーシャルプロバイダーそれぞれから発行されるユニークID
      $table->timestamps();

      // 制約
      $table->unique(['user_id', 'social']);
      $table->unique(['social', 'social_uid']);
    });
  }

  public function down() {
    Schema::dropIfExists('social_providers');
  }

}

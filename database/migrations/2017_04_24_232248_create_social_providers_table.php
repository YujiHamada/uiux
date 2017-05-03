<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('social_providers', function (Blueprint $table) {
          $table->integer('user_id')->unsigned();
          $table->enum('social', ['twitter', 'facebook', 'google', 'github'])->nullable(); // ソーシャルログイン出ない場合はnull
          $table->string('social_uid')->nullable(); // ソーシャルプロバイダーそれぞれから発行されるユニークID
          $table->timestamps();

          // 制約
          $table->primary(['user_id', 'social']);
          $table->unique(['social', 'social_uid']);
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_providers');
    }
}

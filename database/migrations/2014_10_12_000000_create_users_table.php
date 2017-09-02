<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email');
      $table->string('password')->nullable();
      $table->string('avatar_image_path')->nullable(); // 自己紹介画像
      $table->string('biography')->nullable(); // 自己紹介文
      $table->integer('score')->unsigned()->default(0);
      $table->string('confirmation_token')->nullable(); // 確認用トークン
      $table->timestamp('confirmed_at')->nullable(); // 確認日時
      $table->timestamp('confirmation_sent_at')->nullable(); // 確認メール送信日時
      $table->rememberToken();
      $table->tinyInteger('is_deleted')->unsigned()->default(0);
      $table->softDeletes();
      $table->timestamps();

      $table->unique(['name', 'is_deleted', 'deleted_at']);
      $table->unique(['email', 'is_deleted', 'deleted_at']);

    });
  }

  public function down() {
    Schema::drop('users');
  }

}

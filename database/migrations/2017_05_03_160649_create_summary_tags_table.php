<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryTagsTable extends Migration
{

    public function up()
    {
      Schema::create('summary_tags', function (Blueprint $table) {
        $table->integer('tag_id')->unsigned();
        $table->string('tag_name'); // テーブルのjoin数を減らすため、タグ名のカラムを持つこととする。
        $table->integer('count')->unsigned();
        $table->timestamps();

        $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');
      });
    }


    public function down()
    {
      Schema::dropIfExists('summary_tags');
    }
}

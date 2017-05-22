<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablReplaycomments extends Migration
{
    /**
     * 回复评论表
     *
     * @return void
     */
    public function up()
    {
      Schema::create('replaycomments', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('回复评论openid');
        $table->integer('comment_id')->comment('评论id');
        $table->string('content')->comment('回复评论内容');
        $table->integer('praise_num')->comment('点赞数');
        $table->integer('replay_num')->comment('回复数');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

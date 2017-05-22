<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablReplayseconds extends Migration
{
    /**
     * 回复 用户评论下的回复
     *
     * @return void
     */
    public function up()
    {
      Schema::create('replayseconds', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('回复评论openid');
        $table->integer('replaycomment_id')->comment('回复评论id');
        $table->string('replay_openid')->comment('回复人openid');
        $table->string('content')->comment('回复内容');
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

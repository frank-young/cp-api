<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablComments extends Migration
{
    /**
     * 评论
     *
     * @return void
     */
    public function up()
    {
      Schema::create('comments', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('topic_id')->comment('话题id');
        $table->string('openid')->comment('评论用户的openid');
        $table->string('content')->comment('评论的内容');
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

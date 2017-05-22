<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablReminds extends Migration
{
    /**
     * 消息提醒
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reminds', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('评论用户的openid');
        $table->integer('comment_id')->comment('评论id');
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

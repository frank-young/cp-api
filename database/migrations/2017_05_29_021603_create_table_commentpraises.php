<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommentpraises extends Migration
{
    /**
     * 评论点赞
     *
     * @return void
     */
    public function up()
    {
      Schema::create('commentpraises', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('点赞人的openid');
        $table->integer('comment_id')->comment('评论点赞的comment_id');
        $table->integer('praise_status')->default(0)->comment('点赞状态');
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

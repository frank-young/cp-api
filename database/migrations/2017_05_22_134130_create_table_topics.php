<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTopics extends Migration
{
    /**
     * 话题
     *
     * @return void
     */
    public function up()
    {
      Schema::create('topics', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('用户openid');
        $table->string('title')->comment('话题标题');
        $table->string('description')->comment('话题描述');
        $table->text('body')->comment('话题内容');
        $table->string('favorited')->comment('是否收藏');
        $table->text('thumbnail_pic')->comment('缩略图片地址数组');
        $table->text('image_path')->comment('图片路径数组');
        $table->integer('praise_num')->comment('点赞数');
        $table->integer('comment_num')->comment('评论数');
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

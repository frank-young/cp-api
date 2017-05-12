<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTaskaheads extends Migration
{
    /**
     * 任务进行表，用户做任务的数据存储，每次任务都是一次数据
     *
     * @return void
     */
    public function up()
    {
      Schema::create('taskaheads', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('用户openid');
        $table->string('group_id')->comment('cp组队的标识');
        $table->integer('taskmanager_id')->comment('任务id');
        $table->string('image_path')->nullable()->comment('图片任务，图片的数组，格式为数组字符串');
        $table->string('text')->nullable()->comment('文字任务');
        $table->string('voice')->nullable()->comment('音频任务');
        $table->string('other')->nullable()->comment('其他任务');
        $table->string('is_complete')->nullable()->comment('完成任务标识');
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

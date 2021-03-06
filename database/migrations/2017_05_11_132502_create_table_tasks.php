<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTasks extends Migration
{
    /**
     * 用户任务表，用户签到成功会存入此任务表,总记录表
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tasks', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('用户openid');
        $table->string('match_openid')->comment('匹配cp的openid');
        $table->string('group_id')->comment('cp组队的标识');
        $table->integer('is_dissolve')->default(0)->comment('是否解散，如果2天不做任务将解散cp，此为其标识');
        $table->integer('room_num')->comment('房间号');
        $table->string('task_arr')->nullable()->comment('领取任务的数组，格式为数组字符串');
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

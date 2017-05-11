<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTaskmanagers extends Migration
{
    /**
     * 此表为任务表，发布任务的功能
     *
     * @return void
     */
    public function up()
    {
      Schema::create('taskmanagers', function (Blueprint $table) {
        $table->increments('id')->comment('');
        $table->integer('model')->comment('任务模版');
        $table->integer('num')->comment('第几天任务');
        $table->string('title')->comment('任务标题');
        $table->text('body')->comment('任务内容');
        $table->integer('type')->default(0)->comment('任务类型，任务类型标识，0:IMAGE,1:TEXT,2:VOICE');
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

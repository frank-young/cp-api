<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsercaches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('usercaches', function (Blueprint $table) {
        $table->increments('id')->comment('匹配数据查询第一级缓存表');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('用户openid');
        $table->string('name')->comment('用户姓名');
        $table->integer('sex')->comment('性别');
        $table->string('city')->comment('城市');
        $table->integer('extraversion')->comment('外向性，大五人格，存入的是计算好的值');
        $table->integer('agreeableness')->comment('宜人性');
        $table->integer('conscientiousness')->comment('严谨性');
        $table->integer('neuroticism')->comment('神经质');
        $table->integer('openness')->comment('开放性');
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

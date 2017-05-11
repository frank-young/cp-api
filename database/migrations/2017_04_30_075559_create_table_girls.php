<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGirls extends Migration
{
    /**
     * 存储匹配女孩的缓存表
     *
     * @return void
     */
    public function up()
    {
      Schema::create('girls', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('用户openid');
        $table->string('name')->comment('用户姓名');
        $table->integer('sex')->comment('性别');
        $table->integer('extraversion')->comment('外向性，大五人格，存入的是计算好的值');
        $table->integer('agreeableness')->comment('宜人性');
        $table->integer('conscientiousness')->comment('严谨性');
        $table->integer('neuroticism')->comment('神经质');
        $table->integer('openness')->comment('开放性');
        $table->string('match_openid')->comment('匹配用户的openid');
        $table->string('match_name')->comment('匹配用户的姓名');
        $table->string('match_sex')->comment('匹配用户的性别');
        $table->float('offset')->comment('匹配度，存储的是差值');
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

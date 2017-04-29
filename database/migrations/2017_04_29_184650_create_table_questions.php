<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('questions', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('用户openid');
        $table->integer('extraversion')->comment('外向性，大五人格，存入的是计算好的值');
        $table->integer('agreeableness')->comment('宜人性');
        $table->integer('conscientiousness')->comment('严谨性');
        $table->integer('neuroticism')->comment('神经质');
        $table->integer('openness')->comment('开放性');
        $table->text('question_score_json')->comment('选择测评每一个答案的分数，存入json数据，仅保存选择的答案');
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

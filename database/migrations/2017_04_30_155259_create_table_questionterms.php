<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuestionterms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('questionterms', function (Blueprint $table) {
        $table->increments('id')->comment('此表和questions字段一样，但是只存每一期的问卷信息');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('用户openid');
        $table->string('name')->comment('用户姓名');
        $table->integer('sex')->comment('性别');
        $table->string('city')->comment('城市');
        // $table->integer('area_matching')->comment('接受怎样的区域匹配 0：只接受同城、 1 ：只接受异地、 2：都可以接受');
        $table->integer('extraversion')->comment('外向性，大五人格，存入的是计算好的值');
        $table->integer('agreeableness')->comment('宜人性');
        $table->integer('conscientiousness')->comment('严谨性');
        $table->integer('neuroticism')->comment('神经质');
        $table->integer('openness')->comment('开放性');
        $table->integer('is_share')->default(0)->comment('是否分享，确定是否报名成功的重要标识');
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

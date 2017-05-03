<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInfoterms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('infoterms', function (Blueprint $table) {
        $table->increments('id')->comment('此表和infos字段一样，但是只存每一期的 用户基础信息');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('openid');
        $table->string('session_key')->comment('session_key');
        $table->string('name')->comment('姓名');
        $table->string('phone')->comment('手机');
        $table->integer('sex')->comment('性别 0：未知、1：男、2：女');
        $table->string('birthday')->comment('生日');
        $table->integer('constellation')->comment('星座，按月份顺序，1月开始');
        $table->string('province')->comment('省份');
        $table->string('city')->comment('城市');
        $table->string('wechat_id')->comment('微信号');
        $table->string('school')->comment('学校');
        $table->string('hobby')->nullable()->comment('喜欢的事情，爱好');
        $table->string('dislike')->nullable()->comment('不喜欢的事情');
        $table->string('evaluate')->nullable()->comment('自我评价');
        // $table->integer('area_matching')->comment('接受怎样的区域匹配 0：只接受同城、 1 ：只接受异地、 2：都可以接受');
        // $table->integer('age_matching')->comment('接受怎样的年龄匹配 0：都可以接受、 1：只接受比自己大的、2：只接受比自己小的');
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

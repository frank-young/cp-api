<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableApplyrooms extends Migration
{
    /**
     * 申请房主
     *
     * @return void
     */
    public function up()
    {
      Schema::create('applyrooms', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('申请人的openid');
        $table->string('name')->comment('姓名');
        $table->string('phone')->comment('手机号');
        $table->string('wx_id')->comment('微信号');
        $table->string('content')->comment('备注');
        $table->string('is_agree')->default(0)->comment('是否同意申请, 0:提交申请，1:同意，2:不同意');
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

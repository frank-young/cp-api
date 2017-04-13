<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWxusers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('wxusers', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('微信端openid');
        $table->string('nickName')->nullable()->comment('用户昵称');
        $table->string('avatarUrl')->nullable()->comment('用户头像');
        $table->integer('gender')->nullable()->comment('用户性别');
        $table->string('province')->nullable()->comment('用户省份');
        $table->string('city')->nullable()->comment('用户城市');
        $table->string('country')->nullable()->comment('用户国家');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wxusers');
    }
}

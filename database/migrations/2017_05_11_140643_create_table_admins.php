<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdmins extends Migration
{
    /**
     * 管理员表
     *
     * @return void
     */
    public function up()
    {
      Schema::create('admins', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('微信端openid');
        $table->string('nickName')->comment('用户昵称');
        $table->string('avatarUrl')->comment('用户头像');
        $table->integer('gender')->comment('用户性别');
        $table->integer('role')->comment('用户权限值');
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

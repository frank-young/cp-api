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
        $table->string('openid');
        $table->string('session_key');
        $table->string('nickName')->nullable();
        $table->string('avatarUrl')->nullable();
        $table->integer('gender')->nullable();
        $table->string('province')->nullable();
        $table->string('city')->nullable();
        $table->string('country')->nullable();
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

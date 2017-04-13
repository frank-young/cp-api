<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sessions', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('用户openid');
        $table->string('session_key')->comment('微信端session_key');
        $table->string('private_session_key')->comment('服务端session_key');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sessions');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rooms', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('房主的openid');
        $table->string('name')->comment('房间名称');
        $table->integer('num')->comment('房间编号');
        $table->string('wx_id')->comment('房主微信号');
        $table->text('qrcode_path')->comment('房间二维码');
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

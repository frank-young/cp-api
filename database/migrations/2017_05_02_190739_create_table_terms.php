<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('terms', function (Blueprint $table) {
        $table->increments('id')->comment('');
        $table->integer('term')->comment('第几期匹配');
        $table->integer('status')->comment('本期报名状态');
        $table->string('start_date')->comment('活动开始时间');
        $table->string('stop_date')->comment('活动结束时间');
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

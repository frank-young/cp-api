<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMatchterms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('matchterms', function (Blueprint $table) {
        $table->increments('id')->comment('此表和matches字段一样，但是只存每一期的匹配信息');
        $table->integer('term')->comment('第几期匹配');
        $table->string('openid')->comment('用户openid');
        $table->string('name')->comment('用户姓名');
        $table->integer('sex')->comment('性别');
        $table->string('match_openid')->comment('匹配用户的openid');
        $table->string('match_name')->comment('匹配用户的姓名');
        $table->integer('match_sex')->comment('匹配用户的性别');
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

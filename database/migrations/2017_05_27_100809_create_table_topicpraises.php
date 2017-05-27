<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTopicpraises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('topicpraises', function (Blueprint $table) {
        $table->increments('id');
        $table->string('openid')->comment('点赞人的openid');
        $table->integer('topic_id')->comment('点赞的topic_id');
        $table->integer('praise_status')->default(0)->comment('点赞状态');
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('message_id');
            $table->integer('user_id')->unsigned();
            $table->string('message_from', 50);
            $table->string('message_to', 50);
            $table->string('message_type', 50);
            $table->string('message_status', 50);
            $table->text('message_content');
            $table->datetime('message_schedule');
            $table->string('message_url');
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
        Schema::drop('message');
    }
}

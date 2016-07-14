<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('con_id');
            $table->integer('user_id')->unsigned();
            $table->string('con_name', 150);
            $table->string('con_number', 50);
            $table->string('con_image');
            $table->string('con_status', 50);
            $table->date('con_date');
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
        Schema::drop('contacts');
    }
}

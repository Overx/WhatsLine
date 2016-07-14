<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->increments('port_id');
            $table->string('port_titulo');
            $table->text('port_descricao');
            $table->text('port_detalhes');
            $table->string('port_cliente'); 
            $table->string('port_tecnologias');    
            $table->integer('port_categoria')->unsigned();       
            $table->string('port_site');    
            $table->string('port_slug');
            $table->string('port_imagem');                        
            $table->string('port_video');                        
            $table->string('port_status');                        
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
        Schema::drop('portfolios');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion7Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion7', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion7_cotizacion2')->unsigned();
            $table->string('cotizacion7_texto', 200);
            $table->string('cotizacion7_ancho', 10);
            $table->string('cotizacion7_alto', 10);

            $table->foreign('cotizacion7_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion7');
    }
}

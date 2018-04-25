<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_precotizacion5', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('precotizacion5_precotizacion2')->unsigned();
            $table->string('precotizacion5_texto', 200);
            $table->string('precotizacion5_ancho', 10);
            $table->string('precotizacion5_alto', 10);

            $table->foreign('precotizacion5_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_precotizacion5');
    }
}

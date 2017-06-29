<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion_tercero')->unsigned();
            $table->date('cotizacion_fecha');
            $table->integer('cotizacion_usuario_elaboro')->unsigned();
            $table->dateTime('cotizacion_fh_elaboro');

            $table->foreign('cotizacion_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('cotizacion_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion');
    }
}

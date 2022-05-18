<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_precotizacion6', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('precotizacion6_precotizacion2')->unsigned();
            $table->integer('precotizacion6_areap')->unsigned()->nullable();
            $table->string('precotizacion6_nombre', 20)->nullable();
            $table->string('precotizacion6_tiempo', 7);
            $table->double('precotizacion6_valor')->default(0);

            $table->foreign('precotizacion6_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
            $table->foreign('precotizacion6_areap')->references('id')->on('koi_areap')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_precotizacion6');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion3Create extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion3', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion3_cotizacion1')->unsigned();
            $table->integer('cotizacion3_areap')->unsigned()->nullable();
            $table->string('cotizacion3_nombre', 20)->nullable();
            $table->integer('cotizacion3_horas')->default(0);
            $table->double('cotizacion3_valor')->default(0);

            $table->foreign('cotizacion3_cotizacion1')->references('id')->on('koi_cotizacion1')->onDelete('restrict');
            $table->foreign('cotizacion3_areap')->references('id')->on('koi_areap')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion3');
    }
}

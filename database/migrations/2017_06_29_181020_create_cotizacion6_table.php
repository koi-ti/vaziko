<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion6', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion6_cotizacion2')->unsigned();
            $table->integer('cotizacion6_areap')->unsigned()->nullable();
            $table->string('cotizacion6_nombre', 20)->nullable();
            $table->time('cotizacion6_horas');
            $table->double('cotizacion6_valor')->default(0);

            $table->foreign('cotizacion6_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
            $table->foreign('cotizacion6_areap')->references('id')->on('koi_areap')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion6');
    }
}

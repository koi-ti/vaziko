<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraslado1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_traslado1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('traslado1_sucursal')->unsigned();
            $table->integer('traslado1_numero');
            $table->integer('traslado1_destino')->unsigned();
            $table->date('traslado1_fecha');
            $table->text('traslado1_observaciones')->nullable();
            $table->integer('traslado1_usuario_elaboro')->unsigned();
            $table->datetime('traslado1_fecha_elaboro');

            $table->foreign('traslado1_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
            $table->foreign('traslado1_destino')->references('id')->on('koi_sucursal')->onDelete('restrict');
            $table->foreign('traslado1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->unique(['traslado1_sucursal', 'traslado1_numero']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_traslado1');
    }
}

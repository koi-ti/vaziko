<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion8Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion8', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion8_cotizacion2')->unsigned();
            $table->string('cotizacion8_archivo', 200);
            $table->boolean('cotizacion8_imprimir')->default(false);
            $table->datetime('cotizacion8_fh_elaboro');
            $table->integer('cotizacion8_usuario_elaboro')->unsigned();

            $table->foreign('cotizacion8_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
            $table->foreign('cotizacion8_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion8');
    }
}

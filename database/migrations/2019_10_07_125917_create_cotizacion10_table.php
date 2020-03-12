<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacion10Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_cotizacion10', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cotizacion10_cotizacion2')->unsigned();
            $table->integer('cotizacion10_transporte')->unsigned()->nullable();
            $table->string('cotizacion10_nombre', 200)->nullable();
            $table->string('cotizacion10_tiempo', 10);
            $table->double('cotizacion10_valor_unitario')->default(0);
            $table->double('cotizacion10_valor_total')->default(0);
            $table->datetime('cotizacion10_fh_elaboro');
            $table->integer('cotizacion10_usuario_elaboro')->unsigned();

            $table->foreign('cotizacion10_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
            $table->foreign('cotizacion10_transporte')->references('id')->on('koi_areap')->onDelete('restrict');
            $table->foreign('cotizacion10_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_cotizacion10');
    }
}

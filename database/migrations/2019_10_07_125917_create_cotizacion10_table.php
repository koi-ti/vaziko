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
            $table->integer('cotizacion10_materialp')->unsigned()->nullable();
            $table->integer('cotizacion10_producto')->unsigned()->nullable();
            $table->string('cotizacion10_medidas', 50);
            $table->double('cotizacion10_cantidad')->default(0);
            $table->double('cotizacion10_valor_unitario')->default(0);
            $table->double('cotizacion10_valor_total')->default(0);
            $table->datetime('cotizacion10_fh_elaboro');
            $table->integer('cotizacion10_usuario_elaboro')->unsigned();

            $table->foreign('cotizacion10_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
            $table->foreign('cotizacion10_cotizacion2')->references('id')->on('koi_cotizacion2')->onDelete('restrict');
            $table->foreign('cotizacion10_producto')->references('id')->on('koi_producto')->onDelete('restrict');
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

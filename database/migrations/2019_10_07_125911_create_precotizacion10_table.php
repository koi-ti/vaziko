<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecotizacion10Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_precotizacion10', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('precotizacion10_precotizacion2')->unsigned();
            $table->integer('precotizacion10_materialp')->unsigned()->nullable();
            $table->integer('precotizacion10_producto')->unsigned()->nullable();
            $table->string('precotizacion10_medidas', 50);
            $table->double('precotizacion10_cantidad')->default(0);
            $table->double('precotizacion10_valor_unitario')->default(0);
            $table->double('precotizacion10_valor_total')->default(0);
            $table->datetime('precotizacion10_fh_elaboro');
            $table->integer('precotizacion10_usuario_elaboro')->unsigned();

            $table->foreign('precotizacion10_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
            $table->foreign('precotizacion10_precotizacion2')->references('id')->on('koi_precotizacion2')->onDelete('restrict');
            $table->foreign('precotizacion10_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('precotizacion10_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_precotizacion10');
    }
}

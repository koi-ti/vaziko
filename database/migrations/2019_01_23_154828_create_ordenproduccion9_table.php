<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion9Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion9', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden9_orden2')->unsigned();
            $table->integer('orden9_materialp')->unsigned()->nullable();
            $table->integer('orden9_producto')->unsigned();
            $table->string('orden9_medidas', 50);
            $table->double('orden9_cantidad')->default(0);
            $table->double('orden9_valor_unitario')->default(0);
            $table->double('orden9_valor_total')->default(0);
            $table->datetime('orden9_fh_elaboro');
            $table->integer('orden9_usuario_elaboro')->unsigned();

            $table->foreign('orden9_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
            $table->foreign('orden9_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden9_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('orden9_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion9');
    }
}

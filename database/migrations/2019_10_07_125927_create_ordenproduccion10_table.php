<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenproduccion10Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_ordenproduccion10', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('orden10_orden2')->unsigned();
            $table->integer('orden10_materialp')->unsigned()->nullable();
            $table->integer('orden10_producto')->unsigned();
            $table->string('orden10_medidas', 50);
            $table->double('orden10_cantidad')->default(0);
            $table->double('orden10_valor_unitario')->default(0);
            $table->double('orden10_valor_total')->default(0);
            $table->datetime('orden10_fh_elaboro');
            $table->integer('orden10_usuario_elaboro')->unsigned();

            $table->foreign('orden10_materialp')->references('id')->on('koi_materialp')->onDelete('restrict');
            $table->foreign('orden10_orden2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('orden10_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('orden10_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_ordenproduccion10');
    }
}

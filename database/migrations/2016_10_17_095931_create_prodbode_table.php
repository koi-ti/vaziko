<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdbodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_prodbode', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('prodbode_producto')->unsigned();
            $table->integer('prodbode_sucursal')->unsigned();
            $table->integer('prodbode_cantidad')->default(0);
            $table->integer('prodbode_reservada')->default(0)->comment = 'Unidades reservadas, no se muestran disponibles';
            $table->string('prodbode_ubicacion', 200)->nullable();

            $table->foreign('prodbode_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('prodbode_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
            $table->unique(['prodbode_producto', 'prodbode_sucursal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_prodbode');
    }
}

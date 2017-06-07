<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_factura4', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('factura4_factura1')->unsigned();
            $table->double('factura4_cuota')->default(0);
            $table->double('factura4_valor')->default(0);
            $table->double('factura4_saldo')->default(0);
            $table->date('factura4_vencimiento');

            $table->foreign('factura4_factura1')->references('id')->on('koi_factura1')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_factura4');
    }
}

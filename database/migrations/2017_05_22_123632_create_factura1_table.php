<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_factura1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->date('factura1_fecha');
            $table->date('factura1_fecha_vencimiento');
            $table->integer('factura1_cuotas')->unsigned()->default(0);
            $table->integer('factura1_numero')->unsigned()->default(0);
            $table->string('factura1_prefijo', 4);
            $table->integer('factura1_puntoventa')->unsigned();
            $table->integer('factura1_tercero')->unsigned();
            $table->integer('factura1_asiento')->unsigned()->nullable();
            $table->integer('factura1_asienton1')->unsigned()->nullable();

            $table->double('factura1_subtotal')->default(0);
            $table->double('factura1_iva')->default(0);
            $table->integer('factura1_porcentaje_iva')->unsigned();
            $table->double('factura1_descuento')->default(0);
            $table->double('factura1_total')->default(0);

            $table->double('factura1_retefuente')->default(0);
            $table->double('factura1_reteica')->default(0);
            $table->double('factura1_reteiva')->default(0);

            $table->integer('factura1_usuario_elaboro')->unsigned();
            $table->dateTime('factura1_fh_elaboro');

            $table->foreign('factura1_puntoventa')->references('id')->on('koi_puntoventa')->onDelete('restrict');
            $table->foreign('factura1_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('factura1_asiento')->references('id')->on('koi_asiento1')->onDelete('restrict');
            $table->foreign('factura1_asienton1')->references('id')->on('koi_asienton1')->onDelete('restrict');
            $table->foreign('factura1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');

            $table->unique(['factura1_numero', 'factura1_prefijo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_factura1');
    }
}

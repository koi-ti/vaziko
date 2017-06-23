<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturap1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_facturap1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('facturap1_sucursal')->unsigned();
            $table->integer('facturap1_tercero')->unsigned();
            $table->integer('facturap1_asiento')->unsigned();
            $table->string('facturap1_factura', 200);
            $table->date('facturap1_fecha');
            $table->smallInteger('facturap1_cuotas');
            $table->smallInteger('facturap1_periodicidad');
            $table->text('facturap1_observaciones')->nullable();
            $table->integer('facturap1_usuario_elaboro')->unsigned();
            $table->datetime('facturap1_fecha_elaboro');

            $table->foreign('facturap1_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
            $table->foreign('facturap1_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('facturap1_asiento')->references('id')->on('koi_asiento1')->onDelete('restrict');
            $table->foreign('facturap1_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_facturap1');
    }
}

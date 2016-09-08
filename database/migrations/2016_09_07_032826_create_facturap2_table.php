<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturap2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_facturap2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('facturap2_factura')->unsigned();
            $table->smallInteger('facturap2_cuota');
            $table->date('facturap2_vencimiento');
            $table->double('facturap2_valor')->default(0);
            $table->double('facturap2_saldo')->default(0);

            $table->foreign('facturap2_factura')->references('id')->on('koi_facturap1')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_facturap2');
    }
}

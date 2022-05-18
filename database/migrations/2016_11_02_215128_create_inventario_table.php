<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_inventario', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('inventario_sucursal')->unsigned();
            $table->integer('inventario_producto')->unsigned();
            $table->string('inventario_documento', 2)->comment = 'TR:Tralados, AS: Asiento contable';
            $table->integer('inventario_unidad_entrada')->default(0);
            $table->integer('inventario_unidad_salida')->default(0);
            $table->integer('inventario_unidad_saldo')->default(0)->comment = 'Saldo de unidades por salir';
            $table->double('inventario_costo')->default(0);
            $table->double('inventario_costo_promedio')->default(0);
            $table->integer('inventario_usuario_elaboro')->unsigned();
            $table->datetime('inventario_fecha_elaboro');

            $table->foreign('inventario_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('inventario_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
            $table->foreign('inventario_usuario_elaboro')->references('id')->on('koi_tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_inventario');
    }
}

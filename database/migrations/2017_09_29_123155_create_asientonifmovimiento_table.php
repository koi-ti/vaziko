<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsientonifmovimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_asientonifmovimiento', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('movimiento_asienton2')->unsigned();
            $table->string('movimiento_tipo', 2);
            $table->boolean('movimiento_nuevo')->default(false)->nullable();
            $table->string('movimiento_facturap', 200)->nullable();
            $table->integer('movimiento_factura')->nullable()->unsigned();
            $table->integer('movimiento_factura4')->nullable()->unsigned();
            $table->integer('movimiento_sucursal')->nullable()->unsigned();
            $table->integer('movimiento_ordenp')->nullable()->unsigned();
            $table->integer('movimiento_ordenp2')->nullable()->unsigned();
            $table->integer('movimiento_puntoventa')->nullable()->unsigned();
            $table->string('movimiento_serie', 15)->nullable();
            $table->integer('movimiento_producto')->nullable()->unsigned();
            $table->double('movimiento_valor')->default(0);
            $table->date('movimiento_fecha')->nullable();
            $table->date('movimiento_vencimiento')->nullable();
            $table->integer('movimiento_item')->nullable();
            $table->integer('movimiento_periodicidad')->nullable();
            $table->text('movimiento_observaciones')->nullable();

            $table->foreign('movimiento_asienton2')->references('id')->on('koi_asienton2')->onDelete('restrict');
            $table->foreign('movimiento_factura')->references('id')->on('koi_factura1')->onDelete('restrict');
            $table->foreign('movimiento_factura4')->references('id')->on('koi_factura4')->onDelete('restrict');
            $table->foreign('movimiento_producto')->references('id')->on('koi_producto')->onDelete('restrict');
            $table->foreign('movimiento_ordenp')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
            $table->foreign('movimiento_ordenp2')->references('id')->on('koi_ordenproduccion2')->onDelete('restrict');
            $table->foreign('movimiento_puntoventa')->references('id')->on('koi_puntoventa')->onDelete('restrict');
            $table->foreign('movimiento_sucursal')->references('id')->on('koi_sucursal')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_asientonifmovimiento');
    }
}

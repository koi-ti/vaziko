<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsientomovimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_asientomovimiento', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('movimiento_asiento2')->unsigned();
            $table->string('movimiento_tipo', 2);
            $table->boolean('movimiento_nuevo')->default(false)->nullable();
            $table->string('movimiento_facturap', 200)->nullable();
            $table->integer('movimiento_sucursal')->nullable()->unsigned();
            $table->double('movimiento_valor')->default(0);
            $table->date('movimiento_fecha')->nullable();
            $table->string('movimiento_cuota')->nullable();
            $table->string('movimiento_periodicidad')->nullable();
            $table->text('movimiento_observaciones')->nullable();

            $table->foreign('movimiento_asiento2')->references('id')->on('koi_asiento2')->onDelete('restrict');
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
        Schema::dropIfExists('koi_asientomovimiento');
    }
}

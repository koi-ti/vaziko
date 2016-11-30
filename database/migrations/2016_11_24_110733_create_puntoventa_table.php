<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_puntoventa', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('puntoventa_nombre', 200)->unique();
            $table->integer('puntoventa_numero')->default(0)->comment = 'Consecutivo factura';
            $table->string('puntoventa_prefijo', 4)->nullable()->unique();
            $table->string('puntoventa_resolucion_dian', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_puntoventa');
    }
}

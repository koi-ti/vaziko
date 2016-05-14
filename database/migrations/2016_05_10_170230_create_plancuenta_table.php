<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlancuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_plancuentas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('plancuentas_cuenta', 15)->unique();
            $table->smallInteger('plancuentas_nivel');
            $table->string('plancuentas_nombre', 200);
            $table->string('plancuentas_naturaleza', 1);
            $table->integer('plancuentas_centro')->unsigned()->nullable();
            $table->boolean('plancuentas_tercero')->default(false);
            $table->string('plancuentas_tipo', 1);
            $table->float('plancuentas_tasa')->nullable();
            
            $table->integer('plancuentas_nivel1');
            $table->integer('plancuentas_nivel2');
            $table->integer('plancuentas_nivel3');
            $table->integer('plancuentas_nivel4');
            $table->integer('plancuentas_nivel5');
            $table->integer('plancuentas_nivel6');

            $table->foreign('plancuentas_centro')->references('id')->on('koi_centrocosto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_plancuentas');
    }
}

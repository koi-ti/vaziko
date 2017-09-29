<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlancuentasnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('koi_plancuentasn', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('plancuentasn_cuenta', 15)->unique();
            $table->smallInteger('plancuentasn_nivel');
            $table->string('plancuentasn_nombre', 200);
            $table->string('plancuentasn_naturaleza', 1);
            $table->integer('plancuentasn_centro')->unsigned()->nullable();
            $table->boolean('plancuentasn_tercero')->default(false);
            $table->string('plancuentasn_tipo', 1);
            $table->double('plancuentasn_tasa')->nullable();
            
            $table->integer('plancuentasn_nivel1')->default(0);
            $table->integer('plancuentasn_nivel2')->default(0);
            $table->integer('plancuentasn_nivel3')->default(0);
            $table->integer('plancuentasn_nivel4')->default(0);
            $table->integer('plancuentasn_nivel5')->default(0);
            $table->integer('plancuentasn_nivel6')->default(0);
            $table->integer('plancuentasn_nivel7')->default(0);
            $table->integer('plancuentasn_nivel8')->default(0);

            $table->foreign('plancuentasn_centro')->references('id')->on('koi_centrocosto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_plancuentasn');
    }
}

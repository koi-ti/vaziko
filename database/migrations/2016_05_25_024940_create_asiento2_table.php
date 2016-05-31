<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsiento2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_asiento2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('asiento2_asiento')->unsigned();
            $table->integer('asiento2_cuenta')->unsigned();
            $table->integer('asiento2_beneficiario')->unsigned();  
            $table->double('asiento2_debito')->default(0);
            $table->double('asiento2_credito')->default(0);
            $table->integer('asiento2_centro')->unsigned()->nullable();
            $table->double('asiento2_base')->default(0);
            $table->text('asiento2_detalle')->nullable();   
  
            $table->foreign('asiento2_asiento')->references('id')->on('koi_asiento1')->onDelete('restrict');
            $table->foreign('asiento2_cuenta')->references('id')->on('koi_plancuentas')->onDelete('restrict');
            $table->foreign('asiento2_beneficiario')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('asiento2_centro')->references('id')->on('koi_centrocosto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_asiento2');
    }
}

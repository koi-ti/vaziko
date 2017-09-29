<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsienton2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_asienton2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('asienton2_asiento')->unsigned();
            $table->integer('asienton2_cuenta')->unsigned();
            $table->integer('asienton2_beneficiario')->unsigned()->nullable();
            $table->integer('asienton2_ordenp')->unsigned()->nullable();
            $table->double('asienton2_debito')->default(0);
            $table->double('asienton2_credito')->default(0);
            $table->integer('asienton2_centro')->unsigned()->nullable();
            $table->double('asienton2_base')->default(0);
            $table->text('asienton2_detalle')->nullable();
            $table->integer('asienton2_item')->unsigned();

            $table->integer('asienton2_nivel1')->default(0);
            $table->integer('asienton2_nivel2')->default(0);
            $table->integer('asienton2_nivel3')->default(0);
            $table->integer('asienton2_nivel4')->default(0);
            $table->integer('asienton2_nivel5')->default(0);
            $table->integer('asienton2_nivel6')->default(0);
            $table->integer('asienton2_nivel7')->default(0);
            $table->integer('asienton2_nivel8')->default(0);

            $table->foreign('asienton2_asiento')->references('id')->on('koi_asienton1')->onDelete('restrict');
            $table->foreign('asienton2_cuenta')->references('id')->on('koi_plancuentasn')->onDelete('restrict');
            $table->foreign('asienton2_beneficiario')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('asienton2_centro')->references('id')->on('koi_centrocosto')->onDelete('restrict');
            $table->foreign('asienton2_ordenp')->references('id')->on('koi_ordenproduccion')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_asienton2');
    }
}

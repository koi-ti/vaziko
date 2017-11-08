<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldostercerosnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_saldostercerosn', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('saldostercerosn_cuenta')->unsigned();
            $table->integer('saldostercerosn_ano');
            $table->integer('saldostercerosn_mes');
            $table->integer('saldostercerosn_tercero')->unsigned();
            
            $table->integer('saldostercerosn_nivel1')->default(0);
            $table->integer('saldostercerosn_nivel2')->default(0);
            $table->integer('saldostercerosn_nivel3')->default(0);
            $table->integer('saldostercerosn_nivel4')->default(0);
            $table->integer('saldostercerosn_nivel5')->default(0);
            $table->integer('saldostercerosn_nivel6')->default(0);
            $table->integer('saldostercerosn_nivel7')->default(0);
            $table->integer('saldostercerosn_nivel8')->default(0);
            
            $table->double('saldostercerosn_debito_mes')->default(0);
            $table->double('saldostercerosn_credito_mes')->default(0);
            $table->double('saldostercerosn_debito_inicial')->default(0);
            $table->double('saldostercerosn_credito_inicial')->default(0);

            $table->foreign('saldostercerosn_cuenta')->references('id')->on('koi_plancuentasn')->onDelete('restrict');
            $table->foreign('saldostercerosn_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->unique(['saldostercerosn_cuenta', 'saldostercerosn_ano', 'saldostercerosn_mes', 'saldostercerosn_tercero'], 'saldostercerosn_cuenta_ano_mes_tercero_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_saldostercerosn');
    }
}

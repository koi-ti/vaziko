<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoscontablesnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_saldoscontablesn', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('saldoscontablesn_cuenta')->unsigned();
            $table->integer('saldoscontablesn_ano');
            $table->integer('saldoscontablesn_mes');
            
            $table->integer('saldoscontablesn_nivel1')->default(0);
            $table->integer('saldoscontablesn_nivel2')->default(0);
            $table->integer('saldoscontablesn_nivel3')->default(0);
            $table->integer('saldoscontablesn_nivel4')->default(0);
            $table->integer('saldoscontablesn_nivel5')->default(0);
            $table->integer('saldoscontablesn_nivel6')->default(0);
            $table->integer('saldoscontablesn_nivel7')->default(0);
            $table->integer('saldoscontablesn_nivel8')->default(0);
            
            $table->double('saldoscontablesn_debito_mes')->default(0);
            $table->double('saldoscontablesn_credito_mes')->default(0);
            $table->double('saldoscontablesn_debito_inicial')->default(0);
            $table->double('saldoscontablesn_credito_inicial')->default(0);

            $table->foreign('saldoscontablesn_cuenta')->references('id')->on('koi_plancuentasn')->onDelete('restrict');
            $table->unique(['saldoscontablesn_cuenta', 'saldoscontablesn_ano', 'saldoscontablesn_mes'], 'saldoscontablesn_cuenta_ano_mes_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_saldoscontablesn');
    }
}

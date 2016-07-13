<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoscontablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_saldoscontables', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('saldoscontables_cuenta')->unsigned();
            $table->integer('saldoscontables_ano');
            $table->integer('saldoscontables_mes');
            
            $table->integer('saldoscontables_nivel1')->default(0);
            $table->integer('saldoscontables_nivel2')->default(0);
            $table->integer('saldoscontables_nivel3')->default(0);
            $table->integer('saldoscontables_nivel4')->default(0);
            $table->integer('saldoscontables_nivel5')->default(0);
            $table->integer('saldoscontables_nivel6')->default(0);
            $table->integer('saldoscontables_nivel7')->default(0);
            $table->integer('saldoscontables_nivel8')->default(0);
            
            $table->double('saldoscontables_debito_mes')->default(0);
            $table->double('saldoscontables_credito_mes')->default(0);
            $table->double('saldoscontables_debito_inicial')->default(0);
            $table->double('saldoscontables_credito_inicial')->default(0);

            $table->foreign('saldoscontables_cuenta')->references('id')->on('koi_plancuentas')->onDelete('restrict');
            $table->unique(['saldoscontables_cuenta', 'saldoscontables_ano', 'saldoscontables_mes'], 'koi_saldoscontables_cuenta_ano_mes_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_saldoscontables');
    }
}

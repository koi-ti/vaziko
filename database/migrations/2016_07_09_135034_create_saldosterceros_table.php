<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldostercerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_saldosterceros', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('saldosterceros_cuenta')->unsigned();
            $table->integer('saldosterceros_ano');
            $table->integer('saldosterceros_mes');
            $table->integer('saldosterceros_tercero')->unsigned();
            
            $table->integer('saldosterceros_nivel1')->default(0);
            $table->integer('saldosterceros_nivel2')->default(0);
            $table->integer('saldosterceros_nivel3')->default(0);
            $table->integer('saldosterceros_nivel4')->default(0);
            $table->integer('saldosterceros_nivel5')->default(0);
            $table->integer('saldosterceros_nivel6')->default(0);
            $table->integer('saldosterceros_nivel7')->default(0);
            $table->integer('saldosterceros_nivel8')->default(0);
            
            $table->double('saldosterceros_debito_mes')->default(0);
            $table->double('saldosterceros_credito_mes')->default(0);
            $table->double('saldosterceros_debito_inicial')->default(0);
            $table->double('saldosterceros_credito_inicial')->default(0);

            $table->foreign('saldosterceros_cuenta')->references('id')->on('koi_plancuentas')->onDelete('restrict');
            $table->foreign('saldosterceros_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->unique(['saldosterceros_cuenta', 'saldosterceros_ano', 'saldosterceros_mes', 'saldosterceros_tercero'], 'koi_saldosterceros_cuenta_ano_mes_tercero_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_saldosterceros');
    }
}

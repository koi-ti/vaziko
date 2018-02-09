<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReglasasientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_regla_asiento', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            // $table->integer('regla_documento');
            // $table->integer('regla_cuenta');
            // // $table->string('koi_regla_matematica', 40);
            //
            // $table->foreign('regla_documento')->references('id')->on('koi_documento')->onDelete('restrict');
            // $table->foreign('regla_cuenta')->references('id')->on('koi_plancuentas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_regla_asiento');
    }
}

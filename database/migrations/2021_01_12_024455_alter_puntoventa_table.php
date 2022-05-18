<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPuntoventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('koi_puntoventa', function (Blueprint $table) {
            $table->integer('puntoventa_documento')->unsigned()->nullable();

            $table->foreign('puntoventa_documento')->references('id')->on('koi_documento')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

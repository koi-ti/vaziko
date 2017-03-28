<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTcontactoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_tcontacto', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('tcontacto_tercero')->unsigned();
            $table->string('tcontacto_nombres', 200);
            $table->string('tcontacto_apellidos', 200)->nullable();
            $table->integer('tcontacto_municipio')->unsigned()->nullable();
            $table->string('tcontacto_direccion', 200)->nullable();
            $table->string('tcontacto_direccion_nomenclatura', 200)->nullable();
            $table->string('tcontacto_telefono', 15)->nullable();
            $table->string('tcontacto_celular', 15)->nullable();
            $table->string('tcontacto_email', 200)->nullable();
            $table->string('tcontacto_cargo', 200)->nullable();

            $table->foreign('tcontacto_tercero')->references('id')->on('koi_tercero')->onDelete('restrict');
            $table->foreign('tcontacto_municipio')->references('id')->on('koi_municipio')->onDelete('restrict');
            $table->unique(['tcontacto_tercero', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_tcontacto');
    }
}

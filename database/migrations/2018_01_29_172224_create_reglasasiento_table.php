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
            $table->string('regla_cuenta',15)->comment('cuenta que se utiliza para el item');
            $table->string('regla_select',900);
            $table->string('regla_tabla',900);
            $table->string('regla_naturaleza', 1)->comment('naturaleza del item C o D');
            $table->string('regla_union', 900);
            $table->string('regla_condicion',900);
            $table->string('regla_grupo',900);
            $table->string('regla_documento',5);
            $table->boolean('regla_unica')->default(0);
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

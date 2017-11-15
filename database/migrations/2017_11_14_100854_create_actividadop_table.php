<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_actividadop', function( Blueprint $table ){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('actividadop_nombre', 50);
            $table->boolean('actividadop_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_actividadop');
    }
}

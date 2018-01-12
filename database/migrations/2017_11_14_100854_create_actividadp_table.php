<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_actividadp', function( Blueprint $table ){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('actividadp_nombre', 50);
            $table->boolean('actividadp_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_actividadp');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentrocostoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koi_centrocosto', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('centrocosto_codigo', 4);
            $table->string('centrocosto_centro', 20);
            $table->string('centrocosto_nombre', 200);
            $table->string('centrocosto_descripcion1', 200)->nullable();
            $table->string('centrocosto_descripcion2', 200)->nullable();
            $table->string('centrocosto_estructura', 1)->comment = 'S - Tiene subniveles, N - No tiene subniveles';
            $table->string('centrocosto_tipo', 1);   
            $table->boolean('centrocosto_activo')->default(false);  

            $table->unique(['centrocosto_codigo', 'centrocosto_centro']);
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koi_centrocosto');
    }
}

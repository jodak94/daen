<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillasPlantillaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantillas__plantilladetalles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('plantilla_id')->unsigned();
            $table->foreign('plantilla_id')->references('id')->on('plantillas__plantillas')->onDelete('cascade');
            $table->integer('determinacion_id')->unsigned();
            $table->foreign('determinacion_id')->references('id')->on('analisis__determinacions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantillas__plantilladetalles');
    }
}

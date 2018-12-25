<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaDeterminacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla_determinacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('determinacion_id')->unsigned();
            $table->foreign('determinacion_id')->references('id')->on('analisis__determinacions');
            $table->integer('plantilla_id')->unsigned();
            $table->foreign('plantilla_id')->references('id')->on('analisis__plantillas');
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
        Schema::dropIfExists('plantilla_determinacion');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalisisDeterminacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis__determinacions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('titulo');
            $table->string('rango_referencia')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->integer('subseccion_id')->unsigned();
            $table->foreign('subseccion_id')->references('id')->on('analisis__subseccions')->onDelete('cascade');
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
        Schema::dropIfExists('analisis__determinacions');
    }
}

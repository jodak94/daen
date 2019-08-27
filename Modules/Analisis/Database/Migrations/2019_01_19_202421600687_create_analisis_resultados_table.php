<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalisisResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis__resultados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('valor', 1000)->nullable();
            $table->integer('determinacion_id')->unsigned();
            $table->foreign('determinacion_id')->references('id')->on('analisis__determinacions');
            $table->integer('analisis_id')->unsigned();
            $table->foreign('analisis_id')->references('id')->on('analisis__analises')->onDelete('cascade');
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
        Schema::dropIfExists('analisis__resultados');
    }
}

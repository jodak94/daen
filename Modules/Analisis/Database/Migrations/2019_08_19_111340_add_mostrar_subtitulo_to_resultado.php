<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMostrarSubtituloToResultado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis__resultados', function (Blueprint $table) {
            $table->boolean('mostrar_subtitulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis__resultados', function (Blueprint $table) {
            $table->dropColumn('mostrar_subtitulo');
        });
    }
}

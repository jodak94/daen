<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMostrarSubtituloToDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantillas__plantilladetalles', function (Blueprint $table) {
          $table->boolean('mostrar_subtitulo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plantillas__plantilladetalles', function (Blueprint $table) {
          $table->dropColumn('mostrar_subtitulo');
        });
    }
}

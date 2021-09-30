<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCantidadDecimalesToDeterminacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis__determinacions', function (Blueprint $table) {
          $table->integer('cantidad_decimales')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis__determinacions', function (Blueprint $table) {
          $table->dropColumna('cantidad_decimales');
        });
    }
}

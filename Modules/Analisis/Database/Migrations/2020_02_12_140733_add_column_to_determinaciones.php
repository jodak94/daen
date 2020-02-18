<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDeterminaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis__determinacions', function (Blueprint $table) {
          $table->boolean('trato_especial')->default(false);
          $table->string('tipo_trato')->nullable();
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
          $table->dropColumn('trato_especial');
          $table->dropColumn('tipo_trato');
        });
    }
}

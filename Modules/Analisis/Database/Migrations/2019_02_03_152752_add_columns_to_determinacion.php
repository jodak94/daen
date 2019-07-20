<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDeterminacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis__determinacions', function (Blueprint $table) {
          $table->string('tipo_referencia')->nullable();
          $table->double('precio')->nullable();
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
          $table->dropColumn('tipo_referencia');
          $table->dropColumn('precio');
        });
    }
}

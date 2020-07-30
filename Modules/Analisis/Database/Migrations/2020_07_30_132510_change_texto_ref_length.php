<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTextoRefLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('analisis__determinacions', function (Blueprint $table) {
        $table->string('texto_ref', 1000)->change();
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
        $table->string('texto_ref', 10000)->change();
      });
    }
}

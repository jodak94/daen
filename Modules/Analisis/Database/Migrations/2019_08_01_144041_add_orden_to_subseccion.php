<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrdenToSubseccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis__subseccions', function (Blueprint $table) {
          $table->integer('orden')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis__subseccions', function (Blueprint $table) {
          $table->dropColumn('orden');
        });
    }
}

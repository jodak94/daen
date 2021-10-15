<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirmaToAnalisis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis__analises', function (Blueprint $table) {
          $table->string('firma')->nullable()->default('lujan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis__analises', function (Blueprint $table) {
          $table->dropColumn('firma');
        });
    }
}

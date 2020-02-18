<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeConfiguracionesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('configuraciones', function (Blueprint $table) {
          $table->dropColumn('cont_diario');
          $table->string('key');
          $table->string('value', 1000);
          $table->string('text');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('configuraciones', function (Blueprint $table) {
          $table->integer('cont_diario')->default(0);
          $table->dropColumn('key');
          $table->dropColumn('value');
          $table->dropColumn('text');
      });
    }
}

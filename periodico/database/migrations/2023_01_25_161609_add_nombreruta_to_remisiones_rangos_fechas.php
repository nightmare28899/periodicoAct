<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remisiones_rangos_fechas', function (Blueprint $table) {
            $table->string('ruta')->after('dias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remisiones_rangos_fechas', function (Blueprint $table) {
            $table->string('ruta')->after('dias');
        });
    }
};

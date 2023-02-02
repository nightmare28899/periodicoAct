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
        Schema::table('venta_devueltos', function (Blueprint $table) {
            $table->string('fechaInicio')->after('idDomicilio');
            $table->string('fechaFin')->after('fechaInicio');
            $table->string('ruta')->after('fechaFin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venta_devueltos', function (Blueprint $table) {
            $table->string('fechaInicio')->after('idDomicilio');
            $table->string('fechaFin')->after('fechaInicio');
            $table->string('ruta')->after('fechaFin');
        });
    }
};

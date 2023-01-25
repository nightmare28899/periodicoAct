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
        Schema::create('venta_devueltos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idVenta');
            $table->string('idRemision');
            $table->string('idCliente');
            $table->string('idDomicilio');
            $table->string('nombre');
            $table->string('devoluciones');
            $table->string('fechas');
            $table->string('dias');
            $table->string('entregados');
            $table->string('importe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta_devueltos');
    }
};

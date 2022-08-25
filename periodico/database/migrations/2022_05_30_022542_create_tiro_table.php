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
        Schema::create('tiro', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->string('cliente_id');
            $table->string('fecha');
            $table->string('cliente');
            $table->integer('entregar');
            $table->integer('devuelto');
            $table->string('estado');
            $table->integer('faltante');
            $table->integer('venta');
            $table->integer('precio');
            $table->integer('importe');
            $table->string('dia');
            $table->string('nombreruta');
            $table->string('tipo');
            $table->string('idTipo');
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
        Schema::dropIfExists('tiro');
    }
};

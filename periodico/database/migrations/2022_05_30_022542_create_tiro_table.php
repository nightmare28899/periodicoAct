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
            $table->string('fecha');
            $table->string('cliente');
            $table->string('entregar');
            $table->string('devuelto');
            $table->string('faltante');
            $table->string('venta');
            $table->string('precio');
            $table->string('importe');
            $table->string('dia');
            $table->string('nombreruta');
            $table->string('tipo');
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

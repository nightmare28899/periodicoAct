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
            $table->string('fecha')->nullable();
            $table->string('cliente')->nullable();
            $table->integer('entregar')->nullable();
            $table->integer('devuelto');
            $table->integer('faltante')->nullable();
            $table->integer('venta')->nullable();
            $table->integer('precio')->nullable();
            $table->integer('importe')->nullable();
            $table->string('dia')->nullable();
            $table->string('nombreruta')->nullable();
            $table->string('tipo')->nullable();
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

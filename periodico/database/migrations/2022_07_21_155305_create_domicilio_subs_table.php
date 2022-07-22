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
        Schema::create('domicilio_subs', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();
            $table->string('calle');
            $table->integer('noint')->nullable();
            $table->integer('noext');
            $table->string('colonia');
            $table->integer('cp');
            $table->string('localidad');
            $table->string('ciudad');
            $table->string('referencia');
            $table->string('ruta');
            $table->timestamps();
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicilio_subs');
    }
};

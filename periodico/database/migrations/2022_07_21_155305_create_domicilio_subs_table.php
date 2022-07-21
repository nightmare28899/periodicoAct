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
            $table->id();
            $table->string('calle');
            $table->integer('noint');
            $table->integer('noext');
            $table->string('colonia');
            $table->integer('cp');
            $table->string('localidad');
            $table->string('municipio');
            $table->string('referencia');
            $table->string('ruta');
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
        Schema::dropIfExists('domicilio_subs');
    }
};

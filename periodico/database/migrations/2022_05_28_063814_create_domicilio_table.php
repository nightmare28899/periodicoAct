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
        Schema::create('domicilio', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();
            $table->string('calle');
            $table->integer('noint')->nullable(); /* este es opcional en el formulario */
            $table->integer('noext');
            $table->string('colonia');
            $table->integer('cp');
            $table->string('localidad');
            $table->string('municipio');
            $table->bigInteger('ruta_id')->unsigned();
            $table->bigInteger('tarifa_id')->unsigned();
            /* $table->string('ciudad'); */
            $table->string('referencia');
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
            $table->foreign('ruta_id')->references('id')->on('ruta')->onDelete('cascade');
            $table->foreign('tarifa_id')->references('id')->on('tarifa')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicilio');
    }
};

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
        Schema::create('ventas', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();
            $table->string('idVenta');
            $table->string('desde');
            $table->string('hasta');

            $table->integer('lunes')->nullable();
            $table->integer('martes')->nullable();
            $table->integer('miércoles')->nullable();
            $table->integer('jueves')->nullable();
            $table->integer('viernes')->nullable();
            $table->integer('sábado')->nullable();
            $table->integer('domingo')->nullable();
            $table->string('tipo');
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
            $table->string('domicilio_id')->references('id')->on('domicilio')->onDelete('cascade');
            $table->timestamps();
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
        Schema::dropIfExists('ventas');
    }
};

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
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->string('suscripcion');
            $table->string('esUnaSuscripcion');
            $table->bigInteger('cliente_id')->unsigned();
            
            $table->string('tarifa');
            $table->integer('cantEjemplares');
            $table->string('precio');
            $table->string('contrato');
            $table->string('tipoSuscripcion');
            $table->string('periodo');
            $table->string('fechaInicio');
            $table->string('fechaFin');
            $table->string('dias');  
            $table->boolean('lunes')->default(0)->nullable();
            $table->boolean('martes')->default(0)->nullable();
            $table->boolean('miércoles')->default(0)->nullable();
            $table->boolean('jueves')->default(0)->nullable();
            $table->boolean('viernes')->default(0)->nullable();
            $table->boolean('sábado')->default(0)->nullable();
            $table->boolean('domingo')->default(0)->nullable(); 

            
            $table->integer('descuento')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('importe');
            $table->integer('total');
            $table->string('formaPago');

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
        Schema::dropIfExists('suscripciones');
    }
};

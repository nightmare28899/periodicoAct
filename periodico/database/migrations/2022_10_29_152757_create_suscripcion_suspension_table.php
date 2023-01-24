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
        Schema::create('suscripcion_suspension', function (Blueprint $table) {
            $table->bigIncrements('sus_sus_id');
            $table->bigInteger('id')->unsigned();
            $table->string('del');
            $table->string('al');
            $table->string('reponerDias');
            $table->string('reponerAlTermino');
            $table->string('IndicarFecha');
            $table->string('fechaReposicion')->nullable();
            $table->string('motivo');
            $table->foreign('id')->references('id')->on('suscripciones')->onDelete('cascade');
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
        Schema::dropIfExists('suscripcion_suspension');
    }
};

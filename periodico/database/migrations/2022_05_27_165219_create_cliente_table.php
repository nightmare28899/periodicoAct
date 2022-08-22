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
        Schema::create('cliente', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->string('clasificacion')->nullable();
            $table->string('rfc')->nullable();
            $table->string('rfc_input')->nullable();
            $table->string('nombre');
            $table->string('estado');
            $table->string('pais');
            $table->string('email')->unique();
            $table->string('email_cobranza')->nullable();
            $table->string('telefono')->nullable();
            $table->string('regimen_fiscal');
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
        Schema::dropIfExists('cliente');
    }
};

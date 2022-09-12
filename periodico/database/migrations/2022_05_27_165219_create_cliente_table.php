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
            $table->string('clasificacion');
            $table->string('rfc')->nullable();
            $table->string('rfc_input');
            $table->string('nombre')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('estado');
            $table->string('pais');
            $table->string('email');
            $table->string('email_cobranza');
            $table->string('telefono');
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

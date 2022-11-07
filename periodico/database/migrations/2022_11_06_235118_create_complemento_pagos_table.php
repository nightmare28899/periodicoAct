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
        Schema::create('complemento_pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_id');
            $table->string('invoice_date');
            $table->string('cliente_id');
            $table->string('paymentForm');
            $table->string('fecha_pago');
            $table->string('uuid');
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
        Schema::dropIfExists('complemento_pagos');
    }
};

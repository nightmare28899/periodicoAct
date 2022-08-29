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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_id');
            $table->string('invoice_date');
            $table->string('serie');
            $table->string('folio');
            $table->string('paymentTerms');
            $table->string('paymentMethod');
            $table->string('expeditionPlace');
            $table->string('currency');
            $table->string('fiscalRegime');
            $table->string('rfc');
            $table->string('productCode');
            $table->string('unitCode');
            $table->integer('quantity');
            $table->string('unit');
            $table->string('description');
            $table->integer('unitValue');
            $table->integer('subtotal');
            $table->integer('discount');
            $table->integer('total');
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
        Schema::dropIfExists('invoices');
    }
};

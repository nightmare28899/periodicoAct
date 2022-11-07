<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class complemento_pago extends Model
{
    use HasFactory;
    use Loggable; // Uso

    public $timestamps = true;

    protected $table = 'complemento_pagos';

    protected $fillable = [
        'invoice_id', 'invoice_date', 'cliente_id', 'paymentForm', 'fecha_pago', 'uuid'
    ];
}

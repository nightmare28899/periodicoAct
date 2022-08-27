<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'cliente';

    protected $fillable = ['clasificacion', 'rfc', 'rfc_input', 'nombre', 'estado', 'pais', 'email', 'email_cobranza', 'telefono', 'regimen_fiscal', 'razon_social'];
}

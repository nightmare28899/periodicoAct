<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventas extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'ventas';

    protected $fillable = ['idVenta','tipo','cliente_id', 'domicilio_id', 'desde', 'hasta', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo', 'total'];
}

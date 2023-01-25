<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class devolucionVenta extends Model
{
    use HasFactory;
    use Loggable; // Uso

    public $timestamps = true;

    protected $table = 'venta_devueltos';

    protected $fillable = [
        'idVenta', 'idRemision', 'idCliente', 'idDomicilio', 'nombre', 'devoluciones', 'fechas', 'dias', 'entregados', 'importe'
    ];
}

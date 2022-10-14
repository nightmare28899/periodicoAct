<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Tiro extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'tiro';

    protected $fillable = ['fecha', 'cliente', 'entregar', 'devuelto', 'faltante', 'venta', 'precio', 'importe', 'dia', 'nombreruta', 'tipo', 'estado', 'status', 'cliente_id', 'idTipo', 'domicilio_id'];

    public function user()
    {
        return $this->hasOne(Cliente::class);
    }
}

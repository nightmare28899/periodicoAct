<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Domicilio extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'domicilio';

    protected $fillable = ['cliente_id', 'calle', 'noint', 'noext', 'colonia', 'cp', 'localidad', 'municipio', 'ruta_id', 'tarifa_id', 'referencia'];
}

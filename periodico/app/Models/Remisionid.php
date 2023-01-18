<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Remisionid extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'remisiones_rangos_fechas';

    protected $fillable = ['remisiones_id', 'fechas', 'dias', 'diaAlta', 'fechaInicio', 'fechaFin'];
}

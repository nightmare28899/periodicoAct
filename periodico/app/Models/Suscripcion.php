<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Suscripcion extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'suscripciones';

    protected $fillable = ['idSuscripcion', 'tipo', 'suscripcion', 'esUnaSuscripcion', 'cliente_id', 'tarifa', 'cantEjemplares', 'precio', 'contrato', 'tipoSuscripcion', 'periodo', 'fechaInicio', 'fechaFin', 'dias', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo', 'descuento', 'observaciones', 'importe', 'total', 'domicilio_id', 'estado'];
}

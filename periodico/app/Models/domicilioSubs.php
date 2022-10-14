<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class domicilioSubs extends Model
{
    use HasFactory;
    use Loggable; // Uso

    public $timestamps = true;

    protected $table = 'domicilio_subs';

    protected $fillable = ['cliente_id', 'calle', 'noint', 'noext', 'colonia', 'cp', 'localidad', 'ciudad', 'ruta', 'referencia'];
}

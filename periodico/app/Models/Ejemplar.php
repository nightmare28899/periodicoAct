<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Ejemplar extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'ejemplares';

    protected $fillable = ['cliente_id', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo', 'created_at'];
}

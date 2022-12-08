<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class SuscripcionSupendida extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'suscripcion_suspension';

    protected $fillable = ['del', 'al', 'dias', 'motivo', 'id', 'sus_sus_id', 'reponerDias', 'IndicarFecha', 'fechaReposicion', 'diasAgre'];
}


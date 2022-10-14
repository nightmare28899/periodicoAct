<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Tarifa extends Model
{
    use HasFactory;
    use Loggable; // Uso
    public $timestamps = true;

    protected $table = 'tarifa';

    protected $fillable = ['tipo', 'ordinario', 'dominical'];
}

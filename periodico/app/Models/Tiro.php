<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiro extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'tiro';

    protected $fillable = ['cliente', 'dia', 'ejemplares', 'domicilio', 'referencia', 'fecha'];
}

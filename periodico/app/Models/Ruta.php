<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'ruta';

    protected $fillable = ['nombreruta','tiporuta','repartidor','cobrador','ctaespecial'];
}

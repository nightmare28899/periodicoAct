<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'ejemplares';

    protected $fillable = ['cliente_id','lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class domicilioSubs extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'domicilio_subs';

    protected $fillable = ['cliente_id','calle','noint','noext','colonia','cp','localidad','ciudad','ruta','referencia'];
}

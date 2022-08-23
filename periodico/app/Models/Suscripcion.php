<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'suscripciones';

    protected $fillable = ['id','suscripcion','esUnaSuscripcion','cliente_id','tarifa','cantEjemplares','precio','contrato','tipoSuscripcion','periodo','fechaInicio','fechaFin','dias','lunes','martes','miércoles','jueves','viernes','sábado','domingo','descuento','observaciones','importe','total','formaPago','domicilio_id','estado'];
}

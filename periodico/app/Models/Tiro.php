<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiro extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'tiro';

    protected $fillable = ['fecha','cliente', 'entregar', 'devuelto', 'faltante', 'venta', 'precio','importe','dia','nombreruta','tipo', 'estado', 'status', 'cliente_id', 'idTipo'];

    public function user()
    {
        return $this->hasOne(Cliente::class);
    }
}

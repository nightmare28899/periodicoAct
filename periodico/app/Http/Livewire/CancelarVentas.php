<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\models\Tiro;

class CancelarVentas extends Component
{
    public $ventas, $suscripciones;

    public function mount($tipo)
    {
        if (substr($tipo, 0, 6) == 'suscri') {
            $this->suscripciones = Tiro::where('idTipo', '=', 'suscri')->get();
        } else if (substr($tipo, 0, 5) == 'venta') {
            $this->ventas = Tiro
                ::select(\DB::raw('SUBSTRING(idTipo, 0, 5) as idTipo'))
                ->where('idTipo', '=', 'venta')
                ->get();
        }
    }

    public function render()
    {
        /* if (count($this->ventas) > 0) {
            dd($this->ventas);
        } */
        return view('livewire.cancelar-ventas');
    }
}

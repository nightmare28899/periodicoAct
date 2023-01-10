<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ventas;

class HistorialVentas extends Component
{
    public $ventas, $query = '';

    public function render()
    {
        $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
            ->join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
            ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint')
            ->get();

        if ($this->query != '') {
            $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
                ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint')
                ->where('cliente.nombre', 'like', '%' . $this->query . '%')
                ->orWhere('ventas.id', $this->query)
                ->orWhere('ventas.cliente_id', $this->query)
                ->get();
        }

        return view('livewire.historial-ventas', [
            'ventas' => $this->ventas
        ]);
    }
}

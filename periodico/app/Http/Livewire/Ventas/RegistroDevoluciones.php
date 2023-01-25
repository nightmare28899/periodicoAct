<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;
use App\Models\devolucionVenta;
use Livewire\WithPagination;

class RegistroDevoluciones extends Component
{
    use WithPagination;

    public function render()
    {
        $devolucionVenta = devolucionVenta::paginate(10);

        return view('livewire.ventas.registro-devoluciones', [
            'devolucionVenta' => $devolucionVenta
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\complemento_pago;
use Livewire\WithPagination;

class HistorialComplementoPago extends Component
{
    use WithPagination;

    public function render()
    {
        $complemento_pago = complemento_pago
            ::join('cliente', 'cliente.id', '=', 'complemento_pagos.cliente_id')
            ->select('complemento_pagos.*', 'cliente.nombre')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.historial-complemento-pago', compact('complemento_pago'));
    }
}

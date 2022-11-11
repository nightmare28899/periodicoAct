<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\complemento_pago;

class HistorialComplementoPago extends Component
{
    public $complemento_pago;

    public function render()
    {
        $this->complemento_pago = complemento_pago
            ::join('cliente', 'cliente.id', '=', 'complemento_pagos.cliente_id')
            ->select('complemento_pagos.*', 'cliente.nombre')
            ->get();

        return view('livewire.historial-complemento-pago', [
            'complementos' => $this->complemento_pago
        ]);
    }
}

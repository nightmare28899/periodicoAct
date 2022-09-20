<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invoice;

class HistorialF extends Component
{
    public $invoices;
    public function render()
    {
        $this->invoices = Invoice::all();
        return view('livewire.factura.historial-f');
    }
}

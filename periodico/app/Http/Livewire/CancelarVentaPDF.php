<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CancelarVentaPDF extends Component
{
    public function render()
    {
        $this->pdf = Storage::url('cancelarVenta.pdf');

        return view('livewire.cancelar-venta-p-d-f');
    }
}

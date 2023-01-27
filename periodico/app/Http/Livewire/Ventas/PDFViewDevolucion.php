<?php

namespace App\Http\Livewire\Ventas;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PDFViewDevolucion extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('verDevolucion.pdf');

        return view('livewire.ventas.p-d-f-view-devolucion', ['pdf' => $this->pdf]);
    }
}

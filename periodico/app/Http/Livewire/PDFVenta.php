<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PDFVenta extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('venta.pdf');

        return view('livewire.p-d-f-venta', ['pdf' => $this->pdf]);
    }
}

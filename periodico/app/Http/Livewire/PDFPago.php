<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class PDFPago extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('pagado.pdf');

        return view('livewire.pdfpago', ['pdf' => $this->pdf]);
    }
}

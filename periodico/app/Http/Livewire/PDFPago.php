<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PDFPago extends Component
{
    public $pdf;
    public function render()
    {
        $this->pdf = Storage::url('pagado.pdf');

        return view('livewire.p-d-f-pago', [
            'pdf' => $this->pdf
        ]);
    }
}

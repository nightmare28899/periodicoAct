<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PdfSuscripcionReporteVencimiento extends Component
{
    public $pdf;
    public function render()
    {
        $this->pdf = Storage::url('reporteVencimiento.pdf');
        return view('livewire.pdf-suscripcion-reporte-vencimiento', ['pdf' => $this->pdf]);
    }

}

<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ReportePDFrelacionCR extends Component
{
    public $pdf;
    public function render()
    {
        $this->pdf = Storage::url('reporteRCR.pdf');

        return view('livewire.reportes.relacionClienteRuta.reporte-p-d-frelacion-c-r', ['pdf' => $this->pdf]);
    }
}

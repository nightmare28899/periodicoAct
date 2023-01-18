<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class RemisionesRangoPdfview extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('remisionRangos.pdf');

        return view('livewire.remisiones-rango-pdfview', [
            'pdf' => $this->pdf
        ]);
    }
}

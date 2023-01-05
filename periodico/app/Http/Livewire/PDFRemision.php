<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PDFRemision extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('remision.pdf');

        return view('livewire.p-d-f-remision', [
            'pdf' => $this->pdf
        ]);
    }
}

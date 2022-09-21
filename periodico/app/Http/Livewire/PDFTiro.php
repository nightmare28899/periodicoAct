<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PDFTiro extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('tiro.pdf');

        return view('livewire.p-d-f-tiro', ['pdf' => $this->pdf]);
    }
}

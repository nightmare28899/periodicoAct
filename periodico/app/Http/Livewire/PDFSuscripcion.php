<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PDFSuscripcion extends Component
{
    public function render()
    {
        $this->pdf = Storage::url('suscripcion.pdf');
        return view('livewire.p-d-f-suscripcion', ['pdf' => $this->pdf]);
    }
}

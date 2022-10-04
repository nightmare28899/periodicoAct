<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PdfRemisionesP extends Component
{
    public function render()
    {
        $this->pdf = Storage::url('verRemision.pdf');
        return view('livewire.pdf-remisiones-p');
    }
}

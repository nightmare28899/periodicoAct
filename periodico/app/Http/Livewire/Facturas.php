<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;

class Facturas extends Component
{
    public function render()
    {
        $this->tiros = Tiro::all();
        return view('livewire.facturasListado');
    }
}

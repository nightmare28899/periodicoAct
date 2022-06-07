<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ejemplar;
use App\Models\Domicilio;
use App\Models\Cliente;
use Carbon\Carbon;

class Remisiones extends Component
{
    public function render()
    {
        return view('livewire.remisiones.remision');
    }
}

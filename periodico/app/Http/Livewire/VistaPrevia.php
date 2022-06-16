<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VistaPrevia extends Component
{
    public $dateF;

    public function render()
    {
        return view('livewire.tiros.vista-previa', [
            'dateF' => $this->dateF,
        ]);
    }
}

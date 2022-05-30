<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ejemplar;
use App\Models\Domicilio;


class Tiro extends Component
{
    public $Ejemplares, $keyWord, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo,  $ejemplar_id;
    public $Domicilios;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $ejemplares = Ejemplar::all();
        $domicilios = Domicilio::all();
        return view('livewire.tiros.tiro', [
            'ejemplares' => Ejemplar::latest()
                ->orWhere('lunes', 'LIKE', $keyWord)
                ->orWhere('martes', 'LIKE', $keyWord)
                ->orWhere('miercoles', 'LIKE', $keyWord)
                ->orWhere('jueves', 'LIKE', $keyWord)
                ->orWhere('viernes', 'LIKE', $keyWord)
                ->orWhere('sabado', 'LIKE', $keyWord)
                ->orWhere('domingo', 'LIKE', $keyWord)
                ->paginate(15),
        ], compact('ejemplares','domicilios'));
    }
}

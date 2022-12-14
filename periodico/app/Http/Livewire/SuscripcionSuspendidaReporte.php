<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SuscripcionSupendida;

class SuscripcionSuspendidaReporte extends Component
{
    public $suscsuscripcionSusripcion = [];

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->suscripcionBuscada = [];
    }

    public function render()
    {
        if ($this->query) {
            $this->suscripcionSus = SuscripcionSupendida::where('id', $this->query)->get();
        } else {
            $this->suscripcionSus = SuscripcionSupendida::all();
        }

        return view('livewire.reportes.contratos-suspendidos.suscripcion-suspendida-reporte', [
            'suscripcion' => $this->suscripcionSus
        ]);
    }
}

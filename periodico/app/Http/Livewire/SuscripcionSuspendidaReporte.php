<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SuscripcionSupendida;
use Livewire\WithPagination;

class SuscripcionSuspendidaReporte extends Component
{
    use WithPagination;

    public $suscsuscripcionSusripcion = [], $query = '';

    public function render()
    {
        if ($this->query) {
            $suscripcionSus = SuscripcionSupendida::where('id', $this->query)->paginate(10);
        } else {
            $suscripcionSus = SuscripcionSupendida::paginate(10);
        }

        return view('livewire.reportes.contratos-suspendidos.suscripcion-suspendida-reporte', compact('suscripcionSus'));
    }
}

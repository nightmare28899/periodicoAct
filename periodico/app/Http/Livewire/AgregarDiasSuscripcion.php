<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Suscripcion;
use Carbon\Carbon;

class AgregarDiasSuscripcion extends Component
{
    public $suscripcionBuscada = [], $incremento = 'aumentar', $dias, $status, $date, $query = '';

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
        if ($this->query != '') {
            $this->suscripcionBuscada = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->where("suscripciones.id", "like", "%" . $this->query . "%")
                ->select('suscripciones.*', 'cliente.nombre', 'cliente.razon_social')
                ->get();
        } else if ($this->query == '') {
            $this->suscripcionBuscada = [];
        }

        return view('livewire.agregar-dias-suscripcion', [
            'suscripciones' => $this->suscripcionBuscada,
        ]);
    }

    public function guardar()
    {
        $this->validate([
            'dias' => 'required|numeric',
        ]);

        $this->suscripcionBuscada = Suscripcion
            ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
            ->where("suscripciones.id", "like", "%" . $this->query . "%")
            ->select('suscripciones.*', 'cliente.nombre', 'cliente.razon_social')
            ->get();

        $this->date = new Carbon($this->suscripcionBuscada[0]['fechaFin']);

        if ($this->incremento == 'aumentar') {
            $this->date->addDays($this->dias)->format('Y/m/d');
        } else {
            $this->date->subDays($this->dias)->format('Y/m/d');
        }
        Suscripcion::where('id', $this->suscripcionBuscada[0]['id'])->update([
            'fechaFin' => $this->date->format('Y-m-d'),
        ]);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Días agregados exitosamente!' : ''
        ]);
    }
}

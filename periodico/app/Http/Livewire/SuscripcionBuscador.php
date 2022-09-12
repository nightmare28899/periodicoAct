<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;

class SuscripcionBuscador extends Component
{
    public $suscripcion = 0;

    public function mount($status)
    {
        $this->suscripcion = $status;
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->clientesBuscados) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->clientesBuscados) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectContact()
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$this->highlightIndex] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('razon_social', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.suscripcion-buscador');
    }
}

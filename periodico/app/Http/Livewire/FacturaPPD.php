<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use App\Models\Tiro;

class FacturaPPD extends Component
{
    public $query = '', $clienteSeleccionado, $tiros = [], $clientesBuscados = [], $fechaRemision, $idCliente;

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->highlightIndex = 0;
    }

    public function selectContact($pos)
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('id', '=',  $this->query)
            ->orWhere('nombre', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        if ($this->clienteSeleccionado && $this->fechaRemision) {
            $this->tiros = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where(function ($query) {
                    $query->where('cliente_id', $this->clienteSeleccionado['id'])
                        ->where('fecha', $this->fechaRemision);
                })
                ->select('tiro.*', 'cliente.clasificacion')
                ->get();
        } else if ($this->clienteSeleccionado) {
            $this->tiros = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente_id', $this->clienteSeleccionado['id'])
                ->select('tiro.*', 'cliente.clasificacion')
                ->get();
        } else if ($this->fechaRemision) {
            $this->tiros = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('fecha', $this->fechaRemision)
                ->select('tiro.*', 'cliente.clasificacion')
                ->get();
        } else {
            $this->tiros = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->select('tiro.*', 'cliente.clasificacion')
                ->get();
        }

        if ($this->idCliente && $this->fechaRemision) {
            $this->tiros = Tiro::where(function ($query) {
                $query->where('cliente_id', $this->idCliente)
                    ->where('fecha', $this->fechaRemision);
            })->get();
        } else if ($this->idCliente) {
            $this->tiros = Tiro::where('cliente_id', $this->idCliente)->get();
        }

        return view('livewire.factura-p-p-d', [
            'tiros' => $this->tiros,
        ]);
    }
}

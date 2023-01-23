<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use App\Models\Tiro;
use Livewire\WithPagination;

class FacturaPPD extends Component
{
    use WithPagination;

    public $query = '', $clienteSeleccionado, $tiros = [], $clientesBuscados = [], $fechaRemision, $idCliente;

    public function render()
    {
        if ($this->query && $this->fechaRemision) {
            $invoices = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where(function ($query) {
                    $query->where('cliente_id', $this->query)
                        ->orWhere('cliente', 'like', '%' . $this->query . '%')
                        ->where('fecha', $this->fechaRemision);
                })
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        } else if ($this->query) {
            $invoices = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente_id', $this->query)
                ->orWhere('cliente', 'like', '%' . $this->query . '%')
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        } else if ($this->fechaRemision) {
            $invoices = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('fecha', $this->fechaRemision)
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        } else {
            $invoices = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        }

        return view('livewire.factura-p-p-d', compact('invoices'));
    }
}

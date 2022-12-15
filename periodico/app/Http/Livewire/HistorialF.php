<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Cliente;

class HistorialF extends Component
{
    public $invoices, $clientes, $cliente_id, $fecha, $total, $invoice_id, $clienteSeleccionado, $fechaFactura, $idCliente, $fechaRemision;

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
            $this->domicilioSeleccionado = [];
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('id', '=', $this->query)
            ->orWhere('nombre', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        if ($this->clienteSeleccionado && $this->fechaRemision) {
            $this->invoices = Invoice::where(function ($query) {
                $query->where('cliente_id', $this->clienteSeleccionado['id'])
                    ->where('fecha', $this->fechaFactura);
            })->get();
        } else if ($this->clienteSeleccionado) {
            $this->invoices = Invoice::where('cliente_id', $this->clienteSeleccionado['id'])->get();
        } else if ($this->fechaFactura) {
            $this->invoices = Invoice::where('invoice_date', $this->fechaFactura)->get();
        } else {
            $this->invoices = Invoice::all();
        }

        if ($this->idCliente && $this->fechaRemision) {
            $this->invoices = Invoice::where(function ($query) {
                $query->where('cliente_id', $this->idCliente)
                    ->where('fecha', $this->fechaFactura);
            })->get();
        } else if ($this->idCliente) {
            $this->invoices = Invoice::where('cliente_id', $this->idCliente)->get();
        }

        return view('livewire.factura.historial-f');
    }
}

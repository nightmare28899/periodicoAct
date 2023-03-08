<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Cliente;
use Livewire\WithPagination;

class HistorialF extends Component
{
    use WithPagination;

    public $clientes, $cliente_id, $fecha, $total, $invoice_id, $clienteSeleccionado, $fechaFactura, $idCliente, $fechaRemision, $query = "";

    public function render()
    {
        if ($this->query && $this->fechaRemision) {
            $invoices = Invoice::where(function ($query) {
                $query->where('cliente_id', $this->query)
                    ->where('fecha', $this->fechaFactura)
                    ->orWhere('cliente', 'like', '%' . $this->query . '%')
                    ->orWhere('id', $this->query);
            })
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else if ($this->query) {
            $invoices = Invoice::where(function ($query) {
                $query->where('cliente_id', $this->query)
                    ->orWhere('cliente', 'like', '%' . $this->query . '%')
                    ->orWhere('id', $this->query);
            })
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else if ($this->fechaFactura) {
            $invoices = Invoice::where('invoice_date', $this->fechaFactura)->orderBy('id', 'desc')->paginate(10);
        } else {
            $invoices = Invoice::orderBy('id', 'desc')->paginate(10);
        }

        return view('livewire.factura.historial-f', compact('invoices'));
    }
}

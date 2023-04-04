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

    public function someInvoices()
    {
        return redirect('/someInvoices/' . 'PPD');
    }

    public function render()
    {
        if ($this->query && $this->fechaRemision) {
            $invoices = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where(function ($query) {
                    $query->where('cliente_id', $this->query)
                        ->where('clasificacion', 'CRÉDITO')
                        ->orWhere('cliente', 'like', '%' . $this->query . '%')
                        ->where('fecha', $this->fechaRemision);
                })
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        } else if ($this->query) {
            $invoices = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente_id', $this->query)
                ->where('clasificacion', 'CRÉDITO')
                ->orWhere('cliente', 'like', '%' . $this->query . '%')
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        } else if ($this->fechaRemision) {
            $invoices = Tiro
                ::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('fecha', $this->fechaRemision)
                ->where('clasificacion', 'CRÉDITO')
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        } else {
            $invoices = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente.clasificacion', 'CREDITO')
                ->where('cliente.clasificacion', 'CRÉDITO')
                ->where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '!=', 'cancelado')
                ->select('tiro.*', 'cliente.clasificacion')
                ->paginate(10);
        }

        return view('livewire.factura-p-p-d', compact('invoices'));
    }
}

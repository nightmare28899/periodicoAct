<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use Livewire\WithPagination;

class Facturas extends Component
{
    use WithPagination;

    public $query = '', $clienteSeleccionado, $clientesBuscados = [], $fechaRemision, $idCliente;

    public function someInvoices()
    {
        return redirect('/someInvoices/' . 'PUE');
    }

    public function render()
    {
        if ($this->clienteSeleccionado && $this->fechaRemision) {
            $result = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente.clasificacion', '!=', 'CREDITO')
                ->where('cliente.clasificacion', '!=', 'CRÉDITO')
                ->where(function ($query) {
                    $query->where('tiro.status', '!=', 'facturado')
                        ->where('tiro.status', '=', 'Pagado')
                        ->orWhere('tiro.status', '=', 'sin pagar');
                })
                ->where('tiro.cliente_id', $this->clienteSeleccionado['id'])
                ->where('tiro.fecha', $this->fechaRemision)
                ->select('tiro.*', 'cliente.clasificacion')
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else if ($this->query) {
            $result = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente.clasificacion', '!=', 'CREDITO')
                ->where('cliente.clasificacion', '!=', 'CRÉDITO')
                ->where(function ($query) {
                    $query->where('tiro.status', '!=', 'facturado')
                        ->where('tiro.status', '=', 'Pagado')
                        ->orWhere('tiro.status', '=', 'sin pagar');
                })
                ->where('tiro.cliente_id', $this->query)
                ->orWhere('tiro.cliente', 'like', '%' . $this->query . '%')
                ->orWhere('tiro.id', $this->query)
                ->select('tiro.*', 'cliente.clasificacion')
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else if ($this->fechaRemision) {
            $result = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente.clasificacion', '!=', 'CREDITO')
                ->where('cliente.clasificacion', '!=', 'CRÉDITO')
                ->where(function ($query) {
                    $query->where('status', '=', 'Pagado')
                        ->orWhere('status', '=', 'sin pagar');
                })
                ->where('fecha', $this->fechaRemision)
                ->select('tiro.*', 'cliente.clasificacion')
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            $result = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('cliente.clasificacion', '!=', 'CREDITO')
                ->where('cliente.clasificacion', '!=', 'CRÉDITO')
                ->where(function ($query) {
                    $query->where('tiro.status', '!=', 'facturado')
                        ->where('tiro.status', '=', 'Pagado')
                        ->orWhere('tiro.status', '=', 'sin pagar');
                })
                ->select('tiro.*', 'cliente.clasificacion')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        return view('livewire.facturasListado', [
            'invoices' => $result,
        ]);
    }
}

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
            $result = Tiro::where(function ($query) {
                $query->where('status', '=', 'Pagado')
                    ->orWhere('status', '=', 'sin pagar');
            })
                ->where('cliente_id', $this->clienteSeleccionado['id'])
                ->where('fecha', $this->fechaRemision)
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else if ($this->query) {
            $result = Tiro::where(function ($query) {
                $query->where('status', '=', 'Pagado')
                    ->orWhere('status', '=', 'sin pagar');
            })
                ->where('cliente_id', $this->query)
                ->orWhere('cliente', 'like', '%' . $this->query . '%')
                ->orWhere('id', $this->query)
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else if ($this->fechaRemision) {
            $result = Tiro::where(function ($query) {
                $query->where('status', '=', 'Pagado')
                    ->orWhere('status', '=', 'sin pagar');
            })
                ->where('fecha', $this->fechaRemision)
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            $result = Tiro::where(function ($query) {
                $query->where('status', '=', 'Pagado')
                    ->orWhere('status', '=', 'sin pagar');
            })
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        return view('livewire.facturasListado', [
            'invoices' => $result,
        ]);
    }
}

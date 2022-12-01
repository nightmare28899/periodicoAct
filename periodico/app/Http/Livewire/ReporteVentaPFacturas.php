<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use Livewire\WithPagination;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;

class ReporteVentaPFacturas extends Component
{
    use WithPagination;
    public $date, $picker, $invoices, $tipo = 'venta', $export;

    public function render()
    {
        $this->date = new Carbon();

        if ($this->tipo == 'venta') {
            $this->invoices = Invoice::join('cliente', 'cliente.id', '=', 'invoices.cliente_id')
                ->join('ventas', 'ventas.idVenta', '=', 'invoices.idTipo')
                ->select('invoices.*', 'cliente.rfc_input', 'ventas.idVenta')
                ->get();
            if ($this->picker) {
                $this->invoices = Invoice::join('cliente', 'cliente.id', '=', 'invoices.cliente_id')
                    ->join('ventas', 'ventas.idVenta', '=', 'invoices.idTipo')
                    ->where('invoices.invoice_date', $this->picker)
                    ->select('invoices.*', 'cliente.rfc_input', 'ventas.idVenta')
                    ->get();
            }
        } else if ($this->tipo == 'suscri') {
            $this->invoices = Invoice::join('cliente', 'cliente.id', '=', 'invoices.cliente_id')
                ->join('suscripciones', 'suscripciones.idSuscripcion', '=', 'invoices.idTipo')
                ->select('invoices.*', 'cliente.rfc_input', 'suscripciones.idSuscripcion')
                ->get();
            if ($this->picker) {
                $this->invoices = Invoice::join('cliente', 'cliente.id', '=', 'invoices.cliente_id')
                    ->join('suscripciones', 'suscripciones.idSuscripcion', '=', 'invoices.idTipo')
                    ->where('invoices.invoice_date', $this->picker)
                    ->select('invoices.*', 'cliente.rfc_input', 'suscripciones.idSuscripcion')
                    ->get();
            }
        } else {
            $this->invoices = Invoice::join('cliente', 'cliente.id', '=', 'invoices.cliente_id')
                ->select('invoices.*', 'cliente.rfc_input')
                ->get();
        }

        return view('livewire.reporte-venta-p-facturas', [
            'invoices' => $this->invoices,
            'tipo' => $this->tipo,
        ]);
    }

    public function downloadExcel()
    {
        return Excel::download(new InvoicesExport([
            $this->invoices->toArray()
        ]), 'reporteFacturas.xlsx');
    }
}

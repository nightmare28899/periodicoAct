<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;
class ReporteSaldos extends Component
{
    public $picker, $tiro;

    public function render()
    {
        if ($this->picker) {
            $this->tiros = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->where('tiro.fecha', '=', $this->picker)
                ->select('tiro.*', 'cliente.clasificacion', 'cliente.rfc_input')
                ->get();
        } else {
            $this->tiros = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                ->select('tiro.*', 'cliente.clasificacion', 'cliente.rfc_input')
                ->get();
        }

        return view('livewire.reporte-saldos', [
            'tiros' => $this->tiro,
        ]);
    }

    public function downloadExcel()
    {
        return Excel::download(new InvoicesExport([
            $this->tiros->toArray()
        ]), 'reporteSaldos.xlsx');
    }
}

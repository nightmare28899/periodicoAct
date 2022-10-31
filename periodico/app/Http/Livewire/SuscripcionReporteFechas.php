<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SuscripcionReporteFechas extends Component
{
    public $suscripcion = [], $fechavence;

    public function render()
    {
        if ($this->fechavence) {
            $actualDate = Carbon::now();
            $addDays = $actualDate->addDays($this->fechavence)->format('Y-m-d');
            $this->suscripcion = Suscripcion
                ::join('cliente', 'suscripciones.cliente_id', '=', 'cliente.id')
                ->where('fechaFin', $addDays)
                ->select('suscripciones.*', 'cliente.nombre')
                ->get();
        } else {
            $this->suscripcion = Suscripcion
                ::join('cliente', 'suscripciones.cliente_id', '=', 'cliente.id')
                ->select('suscripciones.*', 'cliente.nombre')
                ->get();
        }

        return view('livewire.suscripcion-reporte-fechas', [
            'suscripcion' => $this->suscripcion
        ]);
    }


    public function generarReporte()
    {

        if ($this->fechavence) {
            $actualDate = Carbon::now();
            $addDays = $actualDate->addDays($this->fechavence)->format('Y-m-d');
            $this->suscripcion = Suscripcion
                ::join('cliente', 'suscripciones.cliente_id', '=', 'cliente.id')
                ->where('fechaFin', $addDays)
                ->select('suscripciones.*', 'cliente.nombre')
                ->get();
        } else {
            $this->suscripcion = Suscripcion
                ::join('cliente', 'suscripciones.cliente_id', '=', 'cliente.id')
                ->select('suscripciones.*', 'cliente.nombre')
                ->get();
        }

        $pdf = PDF::loadView('livewire.pdfSuscripcionReporteFechas', [
            'suscripcion' => $this->suscripcion
        ])
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('reporteVencimiento.pdf', $pdf);

        return Redirect::to('/PDFSuscripcionVencimiento');
    }
}

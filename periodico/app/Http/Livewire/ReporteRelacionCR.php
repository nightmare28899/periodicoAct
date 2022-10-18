<?php

namespace App\Http\Livewire;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ventas;
use App\Models\Ruta;
use App\Models\Suscripcion;

use Livewire\Component;

class ReporteRelacionCR extends Component
{
    public $pdf, $ventas, $clientes = [], $domicilios = [], $date, $time, $diaS, $ruta, $rutaSeleccionada = 'TODOS', $suscripciones;
    public function render()
    {
        $this->ruta = Ruta::all();
        $this->date = new Carbon();
        Carbon::setLocale('es');

        $this->time = $this->date->format('H:i:s');
        $this->diaS = $this->date->translatedFormat('l');

        if ($this->rutaSeleccionada != 'TODOS') {
            $this->ventas = ventas
                ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                ->select('ventas.*', 'domicilio.*', 'ruta.*', 'cliente.*')
                ->get();

            $this->suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.id', '=', 'suscripciones.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                ->select('suscripciones.*', 'domicilio_subs.*', 'ruta.*', 'cliente.*')
                ->get();
        } else {
            $this->ventas = ventas
                ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->select('ventas.*', 'domicilio.*', 'ruta.*', 'cliente.*')
                ->get();

            $this->suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.id', '=', 'suscripciones.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->select('suscripciones.*', 'domicilio_subs.*', 'ruta.*', 'cliente.*')
                ->get();
        }

        return view('livewire.reportes.relacionClienteRuta.reporte-relacion-c-r', [
            'ruta' => $this->ruta,
        ]);
    }

    public function generarPDF()
    {
        if ($this->rutaSeleccionada != 'TODOS') {
            $this->ventas = ventas
                ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                ->select('ventas.*', 'domicilio.*', 'ruta.*', 'cliente.*')
                ->get();

            $this->suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.id', '=', 'suscripciones.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                ->select('suscripciones.*', 'domicilio_subs.*', 'ruta.*', 'cliente.*')
                ->get();
        } else {
            $this->ventas = ventas
                ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->select('ventas.*', 'domicilio.*', 'ruta.*', 'cliente.*')
                ->get();

            $this->suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.id', '=', 'suscripciones.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->select('suscripciones.*', 'domicilio_subs.*', 'ruta.*', 'cliente.*')
                ->get();
        }

        $pdf = PDF::loadView('livewire.reportes.relacionClienteRuta.reportePDF', [
            'ventas' => $this->ventas,
            'suscripciones' => $this->suscripciones,
            'date' => $this->date->format('d/m/Y'),
            'time' => $this->time,
            'diaS' => $this->diaS,
            'ruta' => $this->rutaSeleccionada,
        ])
            ->setPaper('A3', 'landscape')
            ->output();

        Storage::disk('public')->put('reporteRCR.pdf', $pdf);

        return Redirect::to('/PDFReporteRCR');
    }
}

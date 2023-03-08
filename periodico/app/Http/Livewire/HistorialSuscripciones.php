<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Suscripcion;
use App\Models\SuscripcionSupendida;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\domicilioSubs;
use App\Models\Ruta;
use Livewire\WithPagination;

class HistorialSuscripciones extends Component
{
    use WithPagination;

    public $fechaSuscripcion, $diaS, $dateF, $suscripcionSuspendida, $clientesBuscados, $query, $estatusPago = 'Todas', $contador = 0, $de, $hasta, $status, $suscripcionesSinPago;

    public function verPDF($id)
    {
        $suscripcionFound = Suscripcion::find($id);
        $clienteFound = Cliente::find($suscripcionFound->cliente_id);
        $domicilio = domicilioSubs::find($suscripcionFound->domicilio_id);
        $rutaFound = Ruta::find((int)$domicilio->ruta);

        $pdf = PDF::loadView('livewire.comprobantePDF', [
            'esUnaSuscripcion' => $suscripcionFound->esUnaSuscripcion,
            'periodo' => $suscripcionFound->periodo,
            'cantEjemplares' => $suscripcionFound->cantEjemplares,
            'observaciones' => $suscripcionFound->observaciones,
            'total' => $suscripcionFound->total,
            'ruta' => array($rutaFound),
            'cliente' => $clienteFound,
            'domicilio' => array($domicilio),
            'desde' => $suscripcionFound->fechaInicio,
            'hasta' => $suscripcionFound->fechaFin,
            'fecha' => $this->dateF,
            'idSuscripcionSig' => $suscripcionFound != null ? $suscripcionFound['id'] : 1,
        ])
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('suscripcion.pdf', $pdf);

        $this->status = 'created';

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡PDF cargado correctamente!' : ''
        ]);

        return Redirect::to('/PDFSuscripcion');
    }

    public function render()
    {
        $this->dateF = new Carbon();
        $this->diaS = $this->dateF->translatedFormat('l');

        if ($this->query && $this->estatusPago == 'Todas') {
            $suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->where(function ($query) {
                    $query->where('cliente.nombre', 'like', '%' . $this->query . '%')
                        ->orWhere('cliente.id', $this->query)
                        ->orWhere('suscripciones.id', $this->query);
                })
                ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                ->orderBy('suscripciones.id', 'desc')
                ->paginate(10);
        }

        if ($this->estatusPago != 'Todas') {
            $suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->where(function ($query) {
                    $query->where('suscripciones.estado', '=', $this->estatusPago);
                })
                ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                ->orderBy('suscripciones.id', 'desc')
                ->paginate(10);
        } else {
            $suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                ->orderBy('suscripciones.id', 'desc')
                ->paginate(10);
        }

        if ($this->de && $this->hasta) {
            if ($this->estatusPago == 'Todas') {
                $suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->where(function ($query) {
                        $query->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta);
                    })
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                    ->orderBy('suscripciones.id', 'desc')
                    ->paginate(10);
            } else {
                $suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->where(function ($query) {
                        $query->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where('suscripciones.estado', '=', $this->estatusPago);
                    })
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                    ->orderBy('suscripciones.id', 'desc')
                    ->paginate(10);
            }
        }


        return view('livewire.historial-suscripciones', [
            'fechaActual' => $this->dateF
        ], compact('suscripciones'));
    }
}

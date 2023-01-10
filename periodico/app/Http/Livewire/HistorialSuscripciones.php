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

class HistorialSuscripciones extends Component
{
    public $suscripciones, $fechaSuscripcion, $diaS, $dateF, $suscripcionSuspendida, $clientesBuscados, $query, $estatusPago = 'Todas', $contador = 0, $de, $hasta, $status, $suscripcionesSinPago;

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

        $this->suscripcionSuspendida = SuscripcionSupendida
            ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
            ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
            ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
            ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta')
            ->get();

        if ($this->query && $this->estatusPago == 'Todas') {
            $this->suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->where('cliente.nombre', 'like', '%' . $this->query . '%')
                ->orWhere('cliente.id', $this->query)
                ->orWhere('suscripciones.id', $this->query)
                ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                ->get($this->diaS);

            $this->suscripcionSuspendida = SuscripcionSupendida
                ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->where('cliente.nombre', 'like', '%' . $this->query . '%')
                ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta')
                ->get();
        } else {
            if (count($this->suscripcionSuspendida) > 0 && $this->estatusPago == 'Todas') {
                for ($i = 0; $i < count($this->suscripcionSuspendida); $i++) {
                    $this->suscripciones = Suscripcion
                        ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                        ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                        ->where('suscripciones.id', '!=', $this->suscripcionSuspendida[$i]['id'])
                        ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                        ->get($this->diaS);
                }
            } else if ($this->estatusPago == 'Todas') {
                $this->suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                    ->get($this->diaS);
            }
        }

        if ($this->estatusPago != 'Todas') {

            if (count($this->suscripcionSuspendida) > 0 && $this->estatusPago != 'Todas') {
                for ($this->contador; $this->contador < count($this->suscripcionSuspendida); $this->contador++) {
                    $this->suscripciones = Suscripcion
                        ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                        ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                        ->where(function ($query) {
                            $query->where('suscripciones.id', '!=', $this->suscripcionSuspendida[$this->contador]['id'])
                                ->where('suscripciones.estado', '=', $this->estatusPago);
                        })
                        ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                        ->get($this->diaS);
                }
                $this->contador = 0;
            } else {
                $this->suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->where('suscripciones.estado', '=', $this->estatusPago)
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                    ->get($this->diaS);
            }

            $this->suscripcionSuspendida = SuscripcionSupendida
                ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->where('suscripciones.estado', '=', $this->estatusPago)
                ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta')
                ->get();
        }

        if ($this->de && $this->hasta) {
            if (count($this->suscripcionSuspendida) > 0 && $this->estatusPago == 'Todas') {
                for ($this->contador; $this->contador < count($this->suscripcionSuspendida); $this->contador++) {
                    $this->suscripciones = Suscripcion
                        ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                        ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                        ->where(function ($query) {
                            $query->where('suscripciones.id', '!=', $this->suscripcionSuspendida[$this->contador]['id'])
                                ->where('suscripciones.fechaInicio', '<=', $this->de)
                                ->where('suscripciones.fechaFin', '>=', $this->hasta);
                        })
                        ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                        ->get($this->diaS);
                }
                $this->contador = 0;
            } else if ($this->estatusPago == 'Todas') {
                $this->suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->where(function ($query) {
                        $query->where('suscripciones.fechaInicio', '<=', $this->de)
                            ->where('suscripciones.fechaFin', '>=', $this->hasta);
                    })
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad')
                    ->get($this->diaS);
            }

            $this->suscripcionSuspendida = SuscripcionSupendida
                ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->where(function ($query) {
                    $query->where('suscripciones.fechaInicio', '<=', $this->de)
                        ->where('suscripciones.fechaFin', '>=', $this->hasta);
                })
                ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta')
                ->get();
        }


        return view('livewire.historial-suscripciones', [
            'suscripciones' => $this->suscripciones,
            'suscripcionSuspendida' => $this->suscripcionSuspendida,
            'suscripcionesSinPago' => $this->suscripcionesSinPago,
        ]);
    }
}

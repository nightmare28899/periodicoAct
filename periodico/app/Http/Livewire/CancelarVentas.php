<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use carbon\carbon;
use App\Models\ventas;
use App\Models\Suscripcion;

class CancelarVentas extends Component
{
    public $ventas, $suscripciones, $tipo, $status = 'created', $tipoMount, $fecha, $diaS, $clienteSeleccionado;

    public function mount($tipo)
    {
        $this->tipoMount = $tipo;
        if (substr($tipo, 0, 6) == 'suscri') {
            $this->tipo = 'suscripciones';
            $this->ventas = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->select('suscripciones.*', 'cliente.nombre')
                ->get();
        } else if (substr($tipo, 0, 5) == 'venta') {
            $this->tipo = 'ventas';
            $this->ventas = ventas
                ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->select('ventas.*', 'cliente.nombre')
                ->get();
        }
    }

    public function render()
    {
        $this->fecha = new Carbon();
        $this->diaS = $this->fecha->translatedFormat('l');

        if ($this->clienteSeleccionado) {
            if (substr($this->tipoMount, 0, 6) == 'suscri') {
                $this->tipo = 'suscripciones';
                $this->ventas = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->select('suscripciones.*', 'cliente.nombre')
                    ->where('cliente.nombre', 'LIKE', '%' . $this->clienteSeleccionado . '%')
                    ->orWhere('suscripciones.cliente_id', $this->clienteSeleccionado)
                    ->orWhere('suscripciones.id', $this->clienteSeleccionado)
                    ->get();
            } else if (substr($this->tipoMount, 0, 5) == 'venta') {
                $this->tipo = 'ventas';
                $this->ventas = ventas
                    ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->select('ventas.*', 'cliente.nombre')
                    ->where('cliente.nombre', 'LIKE', '%' . $this->clienteSeleccionado . '%')
                    ->orWhere('ventas.cliente_id', $this->clienteSeleccionado)
                    ->orWhere('ventas.id', $this->clienteSeleccionado)
                    ->get();
            }
        } else {
            if (substr($this->tipoMount, 0, 6) == 'suscri') {
                $this->tipo = 'suscripciones';
                $this->ventas = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->select('suscripciones.*', 'cliente.nombre')
                    ->get();
            } else if (substr($this->tipoMount, 0, 5) == 'venta') {
                $this->tipo = 'ventas';
                $this->ventas = ventas
                    ::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->select('ventas.*', 'cliente.nombre')
                    ->get();
            }
        }

        return view('livewire.cancelar-ventas', [
            'ventas' => $this->ventas,
        ]);
    }

    public function verPDF($idVenta)
    {
        if (substr($this->tipoMount, 0, 6) == 'suscri') {
            $this->tipo = 'suscripciones';
            $this->ventas = Tiro
                ::join('suscripciones', 'suscripciones.idSuscripcion', '=', 'tiro.idTipo')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.id', '=', 'suscripciones.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('suscripciones.idSuscripcion', $idVenta)
                ->select('tiro.*', 'suscripciones.idSuscripcion', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.total', 'cliente.id', 'cliente.razon_social', 'cliente.rfc_input', 'cliente.estado', 'cliente.pais', 'domicilio_subs.noext', 'domicilio_subs.noint', 'domicilio_subs.colonia', 'domicilio_subs.ciudad', 'cliente.estado', 'domicilio_subs.cp', 'domicilio_subs.calle', 'ruta.nombreruta')
                ->get($this->diaS);
        } else if (substr($this->tipoMount, 0, 5) == 'venta') {
            $this->tipo = 'ventas';
            $this->ventas = Tiro
                ::join('ventas', 'ventas.idVenta', '=', 'tiro.idTipo')
                ->join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                ->where('ventas.idVenta', $idVenta)
                ->select('tiro.*', 'ventas.idVenta', 'ventas.cliente_id', 'ventas.domicilio_id', 'ventas.desde', 'ventas.hasta', 'ventas.lunes', 'ventas.martes', 'ventas.miércoles', 'ventas.jueves', 'ventas.viernes', 'ventas.sábado', 'ventas.domingo', 'cliente.razon_social', 'cliente.rfc_input', 'cliente.estado', 'cliente.pais', 'domicilio.calle', 'domicilio.noext', 'domicilio.noint', 'domicilio.colonia', 'domicilio.municipio', 'cliente.estado', 'domicilio.cp', 'tarifa.ordinario', 'tarifa.dominical')
                ->get($this->diaS);
        }

        $pdf = PDF::loadView('livewire.cancelarVentaPDF', [
            'ventas' => $this->ventas,
            'tipo' => $this->tipo,
            'fecha' => $this->fecha,
            'diaS' => $this->diaS,
        ])
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('cancelarVenta.pdf', $pdf);

        return Redirect::to('/CancelarVentaPDF');
    }

    public function cancelarVenta($id)
    {
        if (substr($this->tipoMount, 0, 6) == 'suscri') {
            Suscripcion::where('idSuscripcion', $id)->update([
                'estado' => 'Cancelada',
                'remisionStatus' => 'Cancelada',
            ]);
        } else if (substr($this->tipoMount, 0, 5) == 'venta') {
            Ventas::where('idVenta', $id)->update([
                'estado' => 'Cancelada',
                'remisionStatus' => 'Cancelada'
            ]);
        }

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->tipo == 'suscripciones') ? '¡Suscripción cancelada correctamente!' : '¡Venta cancelada correctamente!'
        ]);
    }
}

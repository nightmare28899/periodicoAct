<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\ventas;
use App\Models\Cliente;
use App\Models\Domicilio;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use App\Models\Ruta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class Historial extends Component
{
    public $tiros, $id_cliente, $status = 'created', $ventas = [], $tiro, $cliente, $date, $domicilio, $ruta, $modalEditar = 0, $devuelto, $faltante = 0, $entregar, $suscri = [], $clienteSeleccionado, $clientesBuscados, $modalDomicilio = 0, $rutas, $calle, $noint, $noext, $colonia, $cp, $localidad, $referencia, $ciudad, $fechaRemision, $state = false, $datos = [], $type = [], $id_domicilio, $remisionIdSearch, $diaDevolucion, $idVentaEditar, $diaPdf, $modalCapturar = 0, $cantActual = 0, $cantAgregar, $capturarPeriodicos_id, $cantDevueltos, $cantCancelar = 0, $tipo, $domicilioSeleccionado, $suscripcion, $domicilioSubs, $Ruta, $modalHistorial, $modalRemision, $showingModal, $tiros_id, $diaS, $fecha, $statusTiro = 'Todos', $tarifaOrdinario = 0, $tarifaDominical = 0, $tarifa = 0;

    public $query = '';

    public function mount($editar)
    {
        if ($editar != 'normal') {
            $this->state = true;
        }
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
    }

    public function selectContact($pos)
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            $this->domicilioSeleccionado = [];
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('id', '=', $this->query . '%')
            ->orWhere('nombre', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->fecha = new Carbon();
        $this->diaS = $this->fecha->translatedFormat('l');
        $this->rutas = Ruta::pluck('nombreruta', 'id');
        $this->date = Carbon::now()->format('d-m-Y');

        if ($this->state != true) {
            if ($this->query) {
                $this->tiros = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                    ->where('tiro.id', $this->query)
                    ->orWhere('tiro.cliente_id', $this->query)
                    ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                    ->select('tiro.*', 'cliente.clasificacion', 'cliente.nombre', "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();
            } else if ($this->statusTiro != 'Todos') {
                $this->tiros = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                    ->where('tiro.status', $this->statusTiro)
                    ->select('tiro.*', 'cliente.clasificacion', 'cliente.nombre', "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();
            } else {
                $this->tiros = Tiro::join('cliente', 'cliente.id', '=', 'tiro.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'tiro.domicilio_id')
                    ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                    ->select('tiro.*', 'cliente.clasificacion', 'cliente.nombre', "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();
            }
        } else {
            if ($this->clienteSeleccionado) {
                $this->datos = Tiro::all();

                for ($i = 0; $i < count($this->datos); $i++) {
                    if (substr($this->datos[$i]->idTipo, 0, 6) == 'suscri') {
                        array_push($this->type, $this->datos[$i]->idTipo);

                        $this->tiros = Tiro::where(function ($query) {
                            $query->whereIn('idTipo', $this->type)
                                ->where('cliente_id', $this->clienteSeleccionado['id']);
                        })->get();
                    }
                }
            } else {
                $this->datos = Tiro::all();
                for ($i = 0; $i < count($this->datos); $i++) {
                    if (substr($this->datos[$i]->idTipo, 0, 6) == 'suscri') {
                        array_push($this->type, $this->datos[$i]->idTipo);
                        $this->tiros = Tiro::where(function ($query) {
                            $query->whereIn('idTipo', $this->type);
                        })->get();
                    }
                }
            }
        }

        if ($this->remisionIdSearch) {
            $this->tiros = Tiro::where('id', $this->remisionIdSearch)->get();
        }

        return view('livewire.remisiones.historial', [
            'entregar' => $this->entregar,
            'tarifaOrdinario' => $this->tarifaOrdinario,
            'tarifaDominical' => $this->tarifaDominical,
        ]);
    }

    public function pagar($id_cliente, $idTipo, $dia)
    {
        $this->diaPdf = $dia;
        $this->id_cliente = $id_cliente;
        if (substr($idTipo, 0, 6) == 'suscri') {
            $this->cliente = Cliente
                ::join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'cliente.id')
                ->where('cliente.id', '=', $this->id_cliente)
                ->get();
            $this->suscripcion = Suscripcion::Where('cliente_id', $this->id_cliente)->get();
            $this->domicilioSubs = DomicilioSubs::Where('cliente_id', $this->id_cliente)->get();
            $this->Ruta = Ruta::Where('id', $this->domicilioSubs[0]->ruta)->get();
            $pdf = Pdf::loadView('livewire.pagado', [
                'ruta' => $this->Ruta[0],
                'suscripcion' => $this->suscripcion[0],
                'total' => $this->suscripcion[0]['total'],
                'cliente' => $this->cliente[0],
                'desde' => $this->suscripcion[0]['desde'],
                'hasta' => $this->suscripcion[0]['hasta'],
                'fecha' => $this->date,
                'tipo' => 'suscri',
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->tiro = Tiro
                ::where('cliente_id', $this->id_cliente)
                ->where('idTipo', '=', $idTipo)
                ->update(['status' => 'Pagado']);

            Suscripcion::where('cliente_id', $this->id_cliente)->update(['estado' => 'Pagado']);
        } else if (substr($idTipo, 0, 5) == 'venta') {
            $this->cliente = Cliente
                ::join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                ->where('cliente.id', '=', $this->id_cliente)
                ->get();

            $this->ventas = ventas::Where('idVenta', $idTipo)->get();
            $this->domicilio = Domicilio::Where('cliente_id', $this->id_cliente)->first();
            $this->Ruta = Ruta::Where('id', $this->domicilio->ruta_id)->get();

            $pdf = Pdf::loadView('livewire.pagado', [
                'ventas' => $this->ventas,
                'total' => $this->ventas[0]['total'],
                'cliente' => $this->cliente[0],
                'desde' => $this->ventas[0]['desde'],
                'hasta' => $this->ventas[0]['hasta'],
                'lunes' => $this->ventas[0]['lunes'],
                'martes' => $this->ventas[0]['martes'],
                'miercoles' => $this->ventas[0]['miercoles'],
                'jueves' => $this->ventas[0]['jueves'],
                'viernes' => $this->ventas[0]['viernes'],
                'sabado' => $this->ventas[0]['sabado'],
                'domingo' => $this->ventas[0]['domingo'],
                'diaS' => $this->diaPdf,
                'fecha' => $this->date,
                'tipo' => 'venta',
                'ruta' => $this->Ruta[0],
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->tiro = Tiro
                ::where('cliente_id', $this->id_cliente)
                ->where('idTipo', '=', $idTipo)
                ->update(['status' => 'Pagado']);
        }

        Storage::disk('public')->put('pagado.pdf', $pdf);

        $this->status = 'created';

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Se realizo el pago!' : ''
        ]);

        return Redirect::to('/PDFPago');
    }

    public function editarRemision($id, $idVenta, $dia)
    {
        $this->modalEditar = true;
        $this->modalHistorial = false;
        $this->modalRemision = false;
        $this->showingModal = false;
        $tiros = Tiro::join("domicilio", "domicilio.id", "domicilio_id")->join("tarifa", "tarifa.id", "tarifa_id")->find($id);
        $this->tiros_id = $id;
        $this->tarifaOrdinario = $tiros->ordinario;
        $this->tarifaDominical = $tiros->dominical;
        $this->devuelto = $tiros->devuelto;
        $this->idVentaEditar = $idVenta;
        $this->diaDevolucion = $dia;
        $this->cantActual = $tiros->entregar;
        $this->entregar = $tiros->entregar;
        $this->cantCancelar = false;
    }

    public function cerrarEditar()
    {
        $this->modalEditar = false;
    }

    public function pausarRemision($id)
    {
        $tiro = Tiro
            ::join('suscripciones', 'suscripciones.idSuscripcion', '=', 'tiro.idTipo')
            ->where('suscripciones.idSuscripcion', $id)
            ->select('suscripciones.*')
            ->get();

        if ($tiro[0]->estado == 'Pausado') {
            Tiro::where('idTipo', $id)->update([
                'estado' => 'Activo'
            ]);
            Suscripcion::where('idSuscripcion', $id)->update([
                'estado' => 'Activo'
            ]);
        } else {
            Tiro::where('idTipo', $id)->update([
                'estado' => 'Pausado'
            ]);
            Suscripcion::where('idSuscripcion', $id)->update([
                'estado' => 'Pausado'
            ]);
        }
        $this->modalHistorial = false;
    }

    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisión generada exitosamente!' : ''
        ]);
    }

    public function updateDevueltos()
    {
        $tiros = Tiro::find($this->tiros_id);
        $this->entregar = $tiros->entregar;
        $ventas = ventas::where('idVenta', $this->idVentaEditar)->first();
        $this->devuelto = $this->cantDevueltos;
        if ($this->devuelto && $this->tarifa) {
            $this->cantCancelar = false;
            $total = $this->tarifa * $this->devuelto;

            if ($tiros->entregar >= $this->devuelto) {
                $tiros->update([
                    'devuelto' => $tiros->devuelto + $this->devuelto,
                    'entregar' => $tiros->entregar - $this->devuelto,
                    'venta' => $tiros->venta - $this->devuelto,
                    'importe' => $tiros->importe - $total,
                ]);

                $cant = ventas::where('idVenta', $this->idVentaEditar)->get($this->diaDevolucion);

                /* $ventas->update([
                    $this->diaDevolucion => $cant[0][$this->diaDevolucion] - $this->devuelto,
                ]); */

                $this->status = 'updated';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'updated') ? '¡Se generó exitosamente la devolución!' : ''
                ]);

                $this->entregar = $tiros->entregar;
                $this->modalEditar = false;
                $this->modalHistorial = false;
                $this->showingModal = true;
                $this->devuelto = null;
                $this->cantDevueltos = null;
            } else if (($tiros->entregar + $this->devuelto) <= $tiros->devuelto) {
                $this->cantCancelar = true;
                $tiros->update([
                    'devuelto' => $tiros->devuelto - $this->devuelto,
                    'entregar' => $tiros->entregar + $this->devuelto,
                    'venta' => $tiros->venta + $this->devuelto,
                    'importe' => $tiros->importe - $total,
                ]);

                $cant = ventas::where('idVenta', $this->idVentaEditar)->get($this->diaDevolucion);

                /* $ventas->update([
                    $this->diaDevolucion => $cant[0][$this->diaDevolucion] + $this->devuelto,
                ]); */

                $this->status = 'adjust';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'adjust') ? '¡Ajuste realizado!' : ''
                ]);
                $this->entregar = $tiros->entregar;
                $this->modalEditar = false;
                $this->modalHistorial = false;
                $this->showingModal = true;
                $this->devuelto = 0;
                $this->cantDevueltos = null;
            } else {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡No puedes devolver más cantidad de la que hay!' : ''
                ]);
            }
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡No puedes dejar campos vacíos!' : ''
            ]);
        }
    }

    public function modalCapturarPeriodicos($id)
    {
        $this->capturarPeriodicos_id = $id;
        $this->modalCapturar = true;
        $tiros = Tiro::find($id);
        $this->cantActual = $tiros->entregar;
    }

    public function capturarPeriodicos()
    {
        if ($this->cantAgregar != 0) {
            $tiros = Tiro::find($this->capturarPeriodicos_id);
            $tiros->update([
                'entregar' => $tiros->entregar + $this->cantAgregar,
                'venta' => $tiros->entregar + $this->cantAgregar,
                'importe' => ($tiros->entregar + $this->cantAgregar) * $tiros->precio,
            ]);
            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Se agregaron con éxito!' : ''
            ]);
            $this->cantAgregar = null;
            $this->modalCapturar = false;
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡No puedes capturar 0 periodicos!' : ''
            ]);
        }
    }

    public function generarPDF($id, $idTipo, $dia, $idRemision)
    {
        if (substr($idTipo, 0, 6) == 'suscri') {
            $this->cliente = Cliente
                ::join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'cliente.id')
                ->where('cliente.id', '=', $id)
                ->get();

            $this->suscri = Suscripcion::where('idSuscripcion', '=', $idTipo)->get();
            $this->domicilioSubs = DomicilioSubs::Where('cliente_id', $id)->get();
            $this->Ruta = Ruta::Where('id', $this->domicilioSubs[0]->ruta)->get();
            $pdf = Pdf::loadView('livewire.pdfRemisionVer', [
                'ruta' => $this->Ruta[0],
                'suscripcion' => $this->suscri[0],
                'total' => $this->suscri[0]['total'],
                'cliente' => $this->cliente[0],
                'desde' => $this->suscri[0]['desde'],
                'hasta' => $this->suscri[0]['hasta'],
                'fecha' => $this->date,
                'tipo' => 'suscri',
                'idRemision' => $idRemision,
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            Storage::disk('public')->put('verRemision.pdf', $pdf);

            return Redirect::to('/PDFRemisionesP');
        } else if (substr($idTipo, 0, 5) == 'venta') {
            $this->cliente = Cliente
                ::join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                ->where('domicilio.cliente_id', '=', $id)
                ->get();

            $this->ventas = ventas::Where('idVenta', $idTipo)->get();
            $this->domicilio = Domicilio::Where('cliente_id', $id)->first();
            $this->Ruta = Ruta::Where('id', $this->domicilio->ruta_id)->get();

            $pdf = Pdf::loadView('livewire.pdfRemisionVer', [
                'ventas' => $this->ventas,
                'total' => $this->ventas[0]['total'],
                'cliente' => $this->cliente[0],
                'desde' => $this->ventas[0]['desde'],
                'hasta' => $this->ventas[0]['hasta'],
                'lunes' => $this->ventas[0]['lunes'],
                'martes' => $this->ventas[0]['martes'],
                'miercoles' => $this->ventas[0]['miercoles'],
                'jueves' => $this->ventas[0]['jueves'],
                'viernes' => $this->ventas[0]['viernes'],
                'sabado' => $this->ventas[0]['sabado'],
                'domingo' => $this->ventas[0]['domingo'],
                'diaS' => $dia,
                'fecha' => $this->date,
                'tipo' => 'venta',
                'ruta' => $this->Ruta[0],
                'idRemision' => $idRemision,
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            Storage::disk('public')->put('verRemision.pdf', $pdf);

            return Redirect::to('/PDFRemisionesP');
        }
    }

    public function editarDomicilio($id)
    {
        $this->modalDomicilio = true;
        $this->domicilio = domicilioSubs::where('id', $id)->get();
        $this->id_domicilio = $id;
        $this->calle = $this->domicilio[0]->calle;
        $this->noint = $this->domicilio[0]->noint;
        $this->noext = $this->domicilio[0]->noext;
        $this->colonia = $this->domicilio[0]->colonia;
        $this->cp = $this->domicilio[0]->cp;
        $this->localidad = $this->domicilio[0]->localidad;
        $this->ciudad = $this->domicilio[0]->ciudad;
        $this->referencia = $this->domicilio[0]->referencia;
        $this->ruta = $this->domicilio[0]->ruta;
    }

    public function actualizarDomicilioSubs()
    {

        $this->domicilio = domicilioSubs::where('id', $this->id_domicilio)->first();
        $this->domicilio->update([
            'calle' => $this->calle,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'noint' => $this->noint,
            'noext' => $this->noext,
            'referencia' => $this->referencia,
            'ciudad' => $this->ciudad,
            'ruta' => $this->ruta,
        ]);
        $this->modalDomicilio = false;

        $this->status = 'created';

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio actualizado correctamente!' : ''
        ]);
    }

    /* public function cancelar($idTipo)
    {
        $tiro = Tiro
            ::join('ventas', 'ventas.idVenta', '=', 'tiro.idTipo')
            ->where('ventas.idVenta', '=', $idTipo)
            ->select('ventas.*')
            ->get();

        if ($tiro[0]->estado == 'Cancelado') {
            Tiro::where('idTipo', $idTipo)->update([
                'estado' => 'Activo'
            ]);
            Ventas::where('idVenta', $idTipo)->update([
                'estado' => 'Activo'
            ]);
        } else {
            Tiro::where('idTipo', $idTipo)->update([
                'estado' => 'Cancelado'
            ]);
            Ventas::where('idVenta', $idTipo)->update([
                'estado' => 'Cancelado'
            ]);
        }
        $this->modalHistorial = false;
    } */

    public function cancelarVenta($id)
    {
        $venta = Tiro::where('idTipo', $id)->first();
        $venta->update([
            'status' => 'Cancelado',
        ]);
        Ventas::where('idVenta', $id)->update([
            'remisionStatus' => 'Cancelada',
        ]);

        if (substr($id, 0, 6) == 'suscri') {
            $this->tipo = 'suscripciones';
            $this->ventas = Tiro
                ::join('suscripciones', 'suscripciones.idSuscripcion', '=', 'tiro.idTipo')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.id', '=', 'suscripciones.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('suscripciones.idSuscripcion', $id)
                ->select('tiro.*', 'suscripciones.idSuscripcion', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.total', 'cliente.id', 'cliente.razon_social', 'cliente.rfc_input', 'cliente.estado', 'cliente.pais', 'domicilio_subs.noext', 'domicilio_subs.noint', 'domicilio_subs.colonia', 'domicilio_subs.ciudad', 'cliente.estado', 'domicilio_subs.cp', 'domicilio_subs.calle', 'ruta.nombreruta')
                ->get($this->diaS);
        } else if (substr($id, 0, 5) == 'venta') {
            $this->tipo = 'ventas';
            $this->ventas = Tiro
                ::join('ventas', 'ventas.idVenta', '=', 'tiro.idTipo')
                ->join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                ->where('ventas.idVenta', $id)
                ->select('tiro.*', 'ventas.idVenta', 'ventas.cliente_id', 'ventas.domicilio_id', 'ventas.desde', 'ventas.hasta', 'ventas.lunes', 'ventas.martes', 'ventas.miércoles', 'ventas.jueves', 'ventas.viernes', 'ventas.sábado', 'ventas.domingo', 'cliente.razon_social', 'cliente.rfc_input', 'cliente.estado', 'cliente.pais', 'domicilio.calle', 'domicilio.noext', 'domicilio.noint', 'domicilio.colonia', 'domicilio.municipio', 'cliente.estado', 'domicilio.cp', 'tarifa.ordinario', 'tarifa.dominical')
                ->get($this->diaS);
        }

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->tipo == 'suscripciones') ? '¡Suscripción cancelada correctamente!' : '¡Venta cancelada correctamente!'
        ]);

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
}

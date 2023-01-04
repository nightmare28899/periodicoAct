<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Tiro;
use App\Models\Domicilio;
use App\Models\Ruta;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ventas;
use App\Models\Invoice;
use App\Models\SuscripcionSupendida;

class Tiros extends Component
{
    public $Ejemplares, $keyWord, $cliente = [], $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $res = [], $modal, $dateF, $Domicilios, $status = 'error', $devuelto = 0, $faltante = 0, $precio, $updateMode = false, $from, $to, $isGenerateTiro = 0, $clienteSeleccionado = [], $showingModal = false, $modalRemision = false, $importe, $modalHistorial = 0, $count = 0, $tiros = [], $modalEditar = 0, $tiro_id, $op, $ruta, $rutaSeleccionada = 'Todos', $de, $hasta, $dateFiltro, $entregar, $suscripcion = [], $sus = [], $array_merge = [], $ventas = [], $ventaCopia = [], $datosTiroSuscripcion = [], $domsubs = [], $suscripcionCopia = [], $rutaEncontrada = [], $domiciliosIdSacados = [], $rutasNombre = [], $domiPDF = [], $pausa = false, $idVentas, $tipoSeleccionada = 'venta', $tiro, $modalHistorialFactura = 0, $invoices, $estado, $tiros_id;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        $domicilios = Domicilio::all();
        $this->ruta = Ruta::all();
        $suscripcion = Suscripcion::all();
        $this->invoices = Invoice::all();
        $ventas = ventas::all();
        $keyWord = '%' . $this->keyWord . '%';
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        $this->dateFiltro = new Carbon($this->de);
        $this->tiro = Tiro::all();

        if ($this->from) {
            $this->diaS = $this->dateF->translatedFormat('l');

            if ($this->rutaSeleccionada != 'Todos') {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('desde', '<=', $this->from)
                            ->where('hasta', '>=', $this->from)
                            ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                            ->where('ventas.tiroStatus', '=', 'Activo');
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.repartidor", "ruta.cobrador", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where('fechaInicio', '<=', $this->from)
                            ->where('fechaFin', '>=', $this->from)
                            ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                            ->where('suscripciones.tiroStatus', '=', 'Activo');
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador")
                    ->get($this->diaS);
            } else {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('desde', '<=', $this->from)
                            ->where('hasta', '>=', $this->from)
                            ->where('ventas.tiroStatus', '=', 'Activo');
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where('fechaInicio', '<=', $this->from)
                            ->where('fechaFin', '>=', $this->from)
                            ->where('suscripciones.tiroStatus', '=', 'Activo');
                    })
                    ->select("suscripciones.*", "cliente.id", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador")
                    ->get($this->diaS);

                $suscripcionSuspension = SuscripcionSupendida::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')->select('suscripcion_suspension.*', 'suscripciones.fechaFin', 'suscripciones.importe', 'suscripciones.cliente_id')->get();

                if (count($suscripcionSuspension) > 0) {

                    for ($i = 0; $i < count($suscripcionSuspension); $i++) {

                        if ($suscripcionSuspension[$i]->al <= $this->from) {
                            Suscripcion::where('id', $suscripcionSuspension[$i]->id)->update([
                                'estado' => 'Activo',
                                'tiroStatus' => 'Activo'
                            ]);

                            Tiro::where('cliente_id', $suscripcionSuspension[$i]->cliente_id)->where('importe', $suscripcionSuspension[$i]->importe)->update([
                                'estado' => 'Activo',
                            ]);

                            if ($suscripcionSuspension[$i]->IndicarFecha === 'reponer' && $suscripcionSuspension[$i]->reponerDias === 'si' && $suscripcionSuspension[$i]->fechaReposicion === null) {
                                if ($suscripcionSuspension[$i]->fechaFin <= $this->from) {
                                    $dateNow = Carbon::parse($suscripcionSuspension[$i]->fechaFin)->addDays($suscripcionSuspension[$i]->diasAgre)->format('Y-m-d');

                                    Suscripcion::where('id', $suscripcionSuspension[$i]->id)->update([
                                        'fechaFin' => $dateNow,
                                    ]);
                                }
                            } else if ($suscripcionSuspension[$i]->IndicarFecha === 'reponer' && $suscripcionSuspension[$i]->reponerDias === 'si' && $suscripcionSuspension[$i]->fechaReposicion != null) {
                                if ($suscripcionSuspension[$i]->fechaReposicion <= $this->from) {
                                    $dateNow = Carbon::parse($suscripcionSuspension[$i]->fechaFin)->addDays($suscripcionSuspension[$i]->diasAgre)->format('Y-m-d');

                                    Suscripcion::where('id', $suscripcionSuspension[$i]->id)->update([
                                        'fechaFin' => $dateNow,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $this->ventas = [];
            $this->suscripcion = [];
        }

        return view('livewire.tiros.tiro', [
            'ventas' => $this->ventas,
            'resultado' => $this->resultados,
            'suscripcion' => $this->suscripcion,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
            'de' => $this->de,
            'hasta' => $this->hasta,
            'facturas' => $this->invoices,/*
            'tiro' => $this->tiroStatus, */
        ], compact('domicilios'));
    }

    public function regresarQuitados()
    {
        $this->ventas = ventas::all();
        if (count((is_countable($this->ventas) ? $this->ventas : [])) > 0) {
            for ($i = 0; $i < count((is_countable($this->ventas) ? $this->ventas : [])); $i++) {
                if ($this->ventas[$i]['tiroStatus'] == 'inactivo') {
                    $this->ventas[$i]->update([
                        'tiroStatus' => 'Activo',
                    ]);
                }
            }
        }

        $this->suscripcion = Suscripcion::all();
        if (count((is_countable($this->suscripcion) ? $this->suscripcion : [])) > 0) {
            for ($i = 0; $i < count((is_countable($this->suscripcion) ? $this->suscripcion : [])); $i++) {
                if ($this->suscripcion[$i]['tiroStatus'] == 'inactivo') {
                    $this->suscripcion[$i]->update([
                        'tiroStatus' => 'Activo',
                    ]);
                }
            }
        }

        $this->status = 'created';

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Se regresaron correctamente!' : ''
        ]);
    }

    public function pausarVenta($idVenta)
    {
        $venta = ventas::where('idVenta', $idVenta)->first();

        $venta->update([
            'tiroStatus' => 'inactivo',
        ]);
    }

    public function pausarSuscripcion($idcripcion)
    {
        $suscripcion = Suscripcion::where('idSuscripcion', $idcripcion)->first();

        $suscripcion->update([
            'tiroStatus' => 'inactivo',
        ]);
    }

    public function descarga()
    {
        $this->isGenerateTiro = true;
        $this->modalRemision = false;

        if ($this->from) {
            if ($this->rutaSeleccionada != 'Todos') {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('desde', '<=', $this->from)
                            ->where('hasta', '>=', $this->from)
                            ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                            ->where('ventas.tiroStatus', '=', 'Activo');
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where('fechaInicio', '<=', $this->from)
                            ->where('fechaFin', '>=', $this->from)
                            ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                            ->where('suscripciones.tiroStatus', '=', 'Activo');
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador")
                    ->get($this->diaS);
            } else {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('desde', '<=', $this->from)
                            ->where('hasta', '>=', $this->from)
                            ->where('ventas.tiroStatus', '=', 'Activo');
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where('fechaInicio', '<=', $this->from)
                            ->where('fechaFin', '>=', $this->from)
                            ->where('suscripciones.tiroStatus', '=', 'Activo');
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta", "ruta.repartidor", "ruta.cobrador")
                    ->get($this->diaS);
            }
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes escoger una fecha primero!' : ''
            ]);
            $this->ventas = [];
            $this->suscripcion = [];
        }


        $pdf = PDF::loadView('livewire.tiros.pdf', [
            'ventas' => $this->ventas,
            'suscripcion' => $this->suscripcion,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
            'filtro' => $this->rutaSeleccionada != 'Todos' ? $this->rutaSeleccionada : '',
        ])
            ->setPaper('A3', 'landscape')
            ->output();

        Storage::disk('public')->put('tiro.pdf', $pdf);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Tiro generado exitosamente!' : ''
        ]);

        return Redirect::to('/PDFTiro');
    }

    public function historialFactura()
    {
        $this->modalHistorialFactura = true;
    }

    public function historialRemision()
    {
        $this->modalHistorial = true;
        $this->modalRemision = false;
        $this->showingModal = false;

        $this->tiros = Tiro::all();
    }

    public function cerrarHistorial()
    {
        $this->modalHistorial = false;
        $this->modalRemision = false;
        $this->showingModal = true;
    }

    public function generarRemision()
    {
        $this->modalRemision = true;
        $this->showingModal = false;
    }

    public function editarRemision($id)
    {
        $this->modalEditar = true;
        $this->modalHistorial = false;
        $this->modalRemision = false;
        $this->showingModal = false;
        $tiros = Tiro::find($id);
        $this->tiros_id = $id;
        $this->devuelto = $tiros->devuelto;
    }

    public function showModal()
    {
        if ($this->from) {
            $this->showingModal = true;
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes escoger una fecha primero!' : ''
            ]);
        }
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function hideModalRemision()
    {
        $this->modalRemision = false;
        $this->showingModal = true;
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\Ejemplar;
use App\Models\Domicilio;
use App\Models\Cliente;
use App\Models\Ruta;
use App\Models\Suscripcion;
use App\Models\domicilioSubs;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ventas;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use function PHPUnit\Framework\isEmpty;

class Tiros extends Component
{
    public $Ejemplares, $keyWord, $cliente = [], $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $res = [], $modal, $dateF, $Domicilios, $status = 'error', $devuelto = 0, $faltante = 0, $precio, $updateMode = false, $from, $to, $isGenerateTiro = 0, $clienteSeleccionado = [], $showingModal = false, $modalRemision = false, $importe, $modalHistorial = 0, $count = 0, $tiros = [], $modalEditar = 0, $tiro_id, $op, $ruta, $rutaSeleccionada = 'Todos', $de, $hasta, $dateFiltro, $entregar, $suscripcion = [], $sus = [], $array_merge = [], $ventas = [], $ventaCopia = [], $datosTiroSuscripcion = [], $domsubs = [], $suscripcionCopia = [], $rutaEncontrada = [], $domiciliosIdSacados = [], $rutasNombre = [], $domiPDF = [], $pausa = false, $idVentas, $tipoSeleccionada = 'venta', $tiro, $modalHistorialFactura = 0, $invoices;

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
        /* este es la primer info que se muestra del primer picker */
        if ($this->from) {
            $this->diaS = $this->dateF->translatedFormat('l');
            try {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('desde', '<=', $this->from)
                            ->where('hasta', '>=', $this->from);
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where('fechaInicio', '<=', $this->from)
                            ->where('fechaFin', '>=', $this->from);
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get($this->diaS);
                /* foreach ($this->suscripcion as $key => $value) {
                    array_push($this->domiciliosIdSacados, $this->domsubs = domicilioSubs
                        ::whereIn('id', json_decode($this->suscripcion[$key]['domicilio_id']))
                        ->get());
                    array_push($this->rutaEncontrada, Ruta::where('id', $this->domiciliosIdSacados[$key][0]['ruta'])->get());
                } */
            } catch (\Exception $e) {
                /* if ($e->getMessage()) {
                    $this->status = 'created';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡No hay datos registrados!' : ''
                    ]);
                } */
            }
            /* $this->datosTiroSuscripcion = array_merge($this->suscripcion, $this->domsubs); */
        }

        if ($this->rutaSeleccionada == "Todos") {
            $this->diaS = $this->dateF->translatedFormat('l');

            $this->ventaCopia = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where("ventas.tipo", "=", $this->tipoSeleccionada)
                ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->suscripcionCopia = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS);
            $this->rutaEncontrada;
        } else {
            $this->ventaCopia = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where(function ($query) {
                    $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                        ->where('ventas.tipo', '=', $this->tipoSeleccionada);
                })
                ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            dd('else', $this->ventaCopia);

            $this->suscripcionCopia = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->where(function ($query) {
                    $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                        ->where('suscripciones.tipo', '=', $this->tipoSeleccionada);
                })
                ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS);
        }

        /* if (count($this->tiro) > 0) {
            $this->tiroStatus = Tiro
                ::join("invoices", "invoices.idTipo", "=", "tiro.idTipo")
                ->select("tiro.status")
                ->get();
        } */

        return view('livewire.tiros.tiro', [
            'ventas' => $this->ventas,
            'ventaCopia' => $this->ventaCopia,
            'resultado' => $this->resultados,
            'suscripcionCopia' => $this->suscripcionCopia,
            'suscripcion' => $this->suscripcion,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
            'de' => $this->de,
            'hasta' => $this->hasta,
            'facturas' => $this->invoices,/*
            'tiro' => $this->tiroStatus, */
        ], compact('domicilios'));
    }

    public function descarga()
    {
        $this->isGenerateTiro = true;
        $this->modalRemision = false;

        $this->ventas = ventas
            ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("ventas.*", "cliente.id", "cliente.nombre", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->get($this->diaS);

        $this->suscripcion = Suscripcion
            ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
            ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
            ->select("suscripciones.*", "cliente.id", "cliente.nombre", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
            ->get($this->diaS);

        $pdfContent = PDF::loadView('livewire.tiros.pdf', [
            'ventas' => $this->ventas,
            'suscripcion' => $this->suscripcion,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
        ])
            /* ->setPaper('A5', 'landscape') */
            ->output();

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Tiro generado exitosamente!' : ''
        ]);

        return response()
            ->streamDownload(
                fn () => print($pdfContent),
                "tiros.pdf"
            );
    }

    public function descargaRemision()
    {
        if ($this->clienteSeleccionado) {
            $this->status = 'created';

            $this->ventas = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->whereIn('ventas.idVenta', $this->clienteSeleccionado)
                ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->suscripcion = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->whereIn('suscripciones.idSuscripcion', $this->clienteSeleccionado)
                ->select("cliente.*", "suscripciones.*", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS);
            /* if (count($this->suscripcion) > 0) {
                $this->domsubs = domicilioSubs
                    ::whereIn('id', json_decode($this->suscripcion[0]['domicilio_id']))
                    ->get();

                foreach ($this->domsubs as $key => $value) {
                    $this->suscripcion[$key]['domicilio_id'] = $value;
                }

                foreach ($this->domsubs as $key => $value) {
                    array_push($this->rutasNombre, ruta
                        ::where('ruta.id', '=', $this->domsubs[$key]['ruta'])
                        ->select('ruta.nombreruta')
                        ->get());
                }
            } */

            if ($this->de && $this->hasta) {
                $pdfContent = PDF::loadView('livewire.tiros.remisionesPDFP', [
                    'ventas' => $this->ventas,
                    'suscripcion' => $this->suscripcion,
                    'diaS' => $this->diaS,
                    'dateF' => $this->dateF,
                    'de' => $this->de,
                    'domsubs' => $this->domsubs,
                    'hasta' => $this->hasta,
                    'rutasNombre' => $this->rutasNombre,
                ])
                    ->setPaper('A5', 'landscape')
                    ->output();

                $this->rutasNombre = [];
                $this->modalRemision = false;
                $this->showingModal = true;
                $this->de = '';
                $this->hasta = '';
            } else {
                $pdfContent = PDF::loadView('livewire.tiros.remisionPDF', [
                    'ventas' => $this->ventas,
                    'suscripcion' => $this->suscripcion,
                    'diaS' => $this->diaS,
                    'dateF' => $this->dateF,
                    'domsubs' => $this->domsubs,
                    'rutasNombre' => $this->rutasNombre,
                ])
                    ->setPaper('A5', 'landscape')
                    ->output();

                $this->rutasNombre = [];
                $this->modalRemision = false;
                $this->showingModal = true;
            }

            if (count($this->ventas) > 0) {
                for ($i = 0; $i < count($this->clienteSeleccionado); $i++) {
                    if (!Tiro::where('idTipo', '=', $this->clienteSeleccionado[$i])->exists()) {
                        Tiro::create([
                            'fecha' => $this->dateF,
                            'cliente' => $this->ventas[$i]['razon_social'],
                            'entregar' => $this->ventas[$i]->{$this->diaS},
                            'devuelto' => $this->devuelto,
                            'faltante' => $this->faltante,
                            'venta' => $this->ventas[$i]->{$this->diaS},
                            'estado' => 'Activo',
                            'cliente_id' => $this->ventas[$i]->cliente_id,
                            'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                            'importe' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'] * $this->ventas[$i]->{$this->diaS},
                            'dia' => $this->diaS,
                            'idTipo' => $this->clienteSeleccionado[$i],
                            'nombreruta' => $this->ventas[$i]['nombreruta'],
                            'status' => 'sin facturar',
                            'tipo' => $this->ventas[$i]['tiporuta'],
                        ]);
                        $this->modalRemision = false;
                        $this->showingModal = true;
                        $this->toast();
                    } else {
                        $this->status = 'error';
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'error') ? '¡Ya existe esa remisión!' : ''
                        ]);
                    }
                }
            }

            if (count($this->suscripcion) > 0) {
                for ($i = 0; $i < count($this->clienteSeleccionado); $i++) {
                    if (!Tiro::where('idTipo', '=', $this->clienteSeleccionado[$i])->exists()) {
                        Tiro::create([
                            'fecha' => $this->dateF,
                            'cliente' => $this->ventas[$i]['razon_social'],
                            'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                            'devuelto' => $this->devuelto,
                            'faltante' => $this->faltante,
                            'estado' => 'Activo',
                            'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                            'venta' => $this->suscripcion[$i]['cantEjemplares'],
                            'precio' => $this->suscripcion[$i]->tarifa == 'Base' ? 330 : 300,
                            'importe' => $this->suscripcion[$i]->total,
                            'dia' => $this->diaS,
                            'idTipo' => $this->clienteSeleccionado[$i],
                            'nombreruta' => $this->suscripcion[$i]['nombreruta'],
                            'status' => 'sin facturar',
                            'tipo' => $this->suscripcion[$i]['tiporuta'],
                        ]);
                        $this->modalRemision = false;
                        $this->showingModal = true;
                        $this->toast();
                    } else {
                        $this->status = 'error';
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'error') ? '¡Ya existe esa remisión!' : ''
                        ]);
                    }
                }
            }

            $this->clienteSeleccionado = [];
            return response()
                ->streamDownload(
                    fn () => print($pdfContent),
                    "remisiones.pdf"
                );
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes seleccionar un cliente primero!' : ''
            ]);
        }
    }

    public function pausarRemision($id)
    {
        $tiro = Tiro
            ::join('suscripciones', 'suscripciones.cliente_id', '=', 'tiro.cliente_id')
            ->where('suscripciones.cliente_id', '=', $id)
            ->select('suscripciones.*')
            ->get();

        if ($tiro[0]->estado == 'Pausado') {
            Tiro::where('cliente_id', $id)->update([
                'estado' => 'Activo'
            ]);
            Suscripcion::where('cliente_id', $id)->update([
                'estado' => 'Activo'
            ]);
        } else {
            Tiro::where('cliente_id', $id)->update([
                'estado' => 'Pausado'
            ]);
            Suscripcion::where('cliente_id', $id)->update([
                'estado' => 'Pausado'
            ]);
        }
        $this->modalHistorial = false;
    }

    public function descargaTodasRemisiones()
    {
        $this->ventas = ventas
            ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            /* ->where("ventas.tipo", "=", $this->tipoSeleccionada) */
            ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->get($this->diaS);

        $this->suscripcion = Suscripcion
            ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
            ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")/*
            ->where("suscripciones.tipo", "=", $this->tipoSeleccionada) */
            ->select("suscripciones.*", "cliente.*", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
            ->get($this->diaS);

        /* for ($i = 0; $i < count($this->suscripcion); $i++) {
            array_push($this->domiPDF, $this->domsubs = domicilioSubs
                ::whereIn('id', json_decode($this->suscripcion[$i]['domicilio_id']))
                ->get());
        }

        foreach ($this->domsubs as $key => $value) {
            array_push($this->rutasNombre, ruta
                ::where('ruta.id', '=', $this->domsubs[$key]['ruta'])
                ->select('ruta.nombreruta')
                ->get());
        } */

        if ($this->de && $this->hasta) {
            $pdfContent = PDF::loadView('livewire.tiros.remisionesPDFP', [
                'ventas' => $this->ventas,
                'suscripcion' => $this->suscripcion,
                'diaS' => $this->diaS,
                'dateF' => $this->dateF,
                'de' => $this->de,
                'domiPDF' => $this->domiPDF,
                'hasta' => $this->hasta,
                'rutasNombre' => $this->rutasNombre,
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->clienteSeleccionado = [];
            $this->rutasNombre = [];
            $this->modalRemision = false;
            $this->de = '';
            $this->hasta = '';
        } else {
            $pdfContent = PDF::loadView('livewire.tiros.remisionPDF', [
                'ventas' => $this->ventas,
                'suscripcion' => $this->suscripcion,
                'diaS' => $this->diaS,
                'dateF' => $this->dateF,
                'domsubs' => $this->domiPDF,
                'rutasNombre' => $this->rutasNombre,
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->clienteSeleccionado = [];
            $this->rutasNombre = [];
            $this->modalRemision = false;
        }

        if (count($this->ventas) > 0) {
            for ($i = 0; $i < count($this->ventas); $i++) {
                if (count($this->tiro) > 0) {
                    if (!Tiro::where('idTipo', '=', $this->ventas[$i]['idVenta'])->exists()) {
                        Tiro::create([
                            'fecha' => $this->dateF,
                            'cliente' => $this->ventas[$i]['razon_social'],
                            'entregar' => $this->ventas[$i]->{$this->diaS},
                            'devuelto' => $this->devuelto,
                            'faltante' => $this->faltante,
                            'venta' => $this->ventas[$i]->{$this->diaS},
                            'estado' => 'Activo',
                            'cliente_id' => $this->ventas[$i]->cliente_id,
                            'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                            'importe' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'] * $this->ventas[$i]->{$this->diaS},
                            'dia' => $this->diaS,
                            'status' => 'sin facturar',
                            'idTipo' => $this->ventas[$i]['idVenta'],
                            'nombreruta' => $this->ventas[$i]['nombreruta'],
                            'tipo' => $this->ventas[$i]['tiporuta'],
                        ]);
                        $this->toast();
                    } else {
                        $this->status = 'error';
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'error') ? '¡Ya existe esa remisión!' : ''
                        ]);
                    }
                } else {
                    Tiro::create([
                        'fecha' => $this->dateF,
                        'cliente' => $this->ventas[$i]['razon_social'],
                        'entregar' => $this->ventas[$i]->{$this->diaS},
                        'devuelto' => $this->devuelto,
                        'faltante' => $this->faltante,
                        'venta' => $this->ventas[$i]->{$this->diaS},
                        'estado' => 'Activo',
                        'cliente_id' => $this->ventas[$i]->cliente_id,
                        'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                        'importe' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'] * $this->ventas[$i]->{$this->diaS},
                        'dia' => $this->diaS,
                        'status' => 'sin facturar',
                        'idTipo' => $this->ventas[$i]['idVenta'],
                        'nombreruta' => $this->ventas[$i]['nombreruta'],
                        'tipo' => $this->ventas[$i]['tiporuta'],
                    ]);
                    $this->toast();
                }
            }
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡No hay ventas para generar la remisión!' : ''
            ]);
        }

        if (count($this->suscripcion) > 0) {
            for ($i = 0; $i < count($this->suscripcion); $i++) {
                if (count($this->tiro) > 0) {
                    if (!Tiro::where('idTipo', '=', $this->suscripcion[$i]['idSuscripcion'])->exists()) {
                        Tiro::create([
                            'fecha' => $this->dateF,
                            'cliente' => $this->ventas[$i]['razon_social'],
                            'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                            'devuelto' => $this->devuelto,
                            'faltante' => $this->faltante,
                            'estado' => 'Activo',
                            'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                            'venta' => $this->suscripcion[$i]['cantEjemplares'],
                            'precio' => $this->suscripcion[$i]->tarifa == 'Base' ? 330 : 300,
                            'importe' => $this->suscripcion[$i]->total,
                            'dia' => $this->diaS,
                            'status' => 'sin facturar',
                            'idTipo' => $this->suscripcion[$i]['idSuscripcion'],
                            'nombreruta' => $this->suscripcion[$i]['nombreruta'],
                            'tipo' => $this->suscripcion[$i]['tiporuta'],
                        ]);
                        $this->toast();
                    } else {
                        $this->status = 'error';
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'error') ? '¡Ya existe esa remisión!' : ''
                        ]);
                    }
                } else {
                    Tiro::create([
                        'fecha' => $this->dateF,
                        'cliente' => $this->ventas[$i]['razon_social'],
                        'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                        'devuelto' => $this->devuelto,
                        'faltante' => $this->faltante,
                        'estado' => 'Activo',
                        'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                        'venta' => $this->suscripcion[$i]['cantEjemplares'],
                        'precio' => $this->suscripcion[$i]->tarifa == 'Base' ? 330 : 300,
                        'importe' => $this->suscripcion[$i]->total,
                        'dia' => $this->diaS,
                        'status' => 'sin facturar',
                        'idTipo' => $this->suscripcion[$i]['idSuscripcion'],
                        'nombreruta' => $this->suscripcion[$i]['nombreruta'],
                        'tipo' => $this->suscripcion[$i]['tiporuta'],
                    ]);
                    $this->toast();
                }
            }
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡No hay suscripciones para generar la remisión!' : ''
            ]);
        }

        $this->modalRemision = false;
        $this->showingModal = true;
        $this->clienteSeleccionado = [];

        return response()
            ->streamDownload(
                fn () => print($pdfContent),
                "remisiones.pdf"
            );
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

    public function cerrarEditar()
    {
        $this->modalEditar = false;
        $this->modalHistorial = true;
        $this->modalRemision = false;
        $this->showingModal = false;
    }

    public function updateDevueltos()
    {
        $tiros = Tiro::find($this->tiros_id);
        if ($this->devuelto) {
            if ($tiros->entregar >= $this->devuelto) {
                $tiros->update([
                    'devuelto' => $tiros->devuelto + $this->devuelto,
                    'entregar' => $tiros->entregar - $this->devuelto,
                    'venta' => $tiros->venta - $this->devuelto,
                    'importe' => $tiros->importe = ($tiros->entregar - $this->devuelto) * $tiros->precio,
                ]);
                $this->status = 'updated';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'updated') ? '¡Se generó exitosamente la devolución!' : ''
                ]);
                $this->entregar = $tiros->entregar;
                $this->modalEditar = false;
                $this->modalHistorial = false;
                $this->showingModal = true;
                $this->devuelto = 0;
            } else if (($tiros->entregar + $this->devuelto) <= $tiros->devuelto) {
                $tiros->update([
                    'devuelto' => $tiros->devuelto - $this->devuelto,
                    'entregar' => $tiros->entregar + $this->devuelto,
                    'venta' => $tiros->venta + $this->devuelto,
                    'importe' => $tiros->importe = ($tiros->entregar + $this->devuelto) * $tiros->precio,
                ]);
                $this->status = 'adjust';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'adjust') ? '¡Ajuste realizado!' : ''
                ]);
                $this->entregar = $tiros->entregar;
                $this->modalEditar = false;
                $this->modalHistorial = false;
                $this->showingModal = true;
                $this->devuelto = 0;
            } else {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡No puedes devolver más cantidad de la que hay!' : ''
                ]);
            }
        }
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

    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisión generada exitosamente!' : ''
        ]);
    }
}

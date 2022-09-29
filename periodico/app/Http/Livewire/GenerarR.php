<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\ventas;
use App\Models\Suscripcion;
use App\Models\Ruta;
use App\Models\Invoice;
use App\Models\Tiro;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GenerarR extends Component
{
    public $Ejemplares, $keyWord, $cliente = [], $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $res = [], $modal, $dateF, $Domicilios, $status = 'created', $devuelto = 0, $faltante = 0, $precio, $updateMode = false, $from, $to, $isGenerateTiro = 0, $clienteSeleccionado = [], $showingModal = false, $modalRemision = false, $importe, $modalHistorial = 0, $count = 0, $tiros = [], $modalEditar = 0, $tiro_id, $op, $ruta, $rutaSeleccionada = 'Todos', $de, $hasta, $dateFiltro, $entregar, $suscripcion = [], $sus = [], $array_merge = [], $ventas = [], $ventaCopia = [], $datosTiroSuscripcion = [], $domsubs = [], $suscripcionCopia = [], $rutaEncontrada = [], $domiciliosIdSacados = [], $rutasNombre = [], $domiPDF = [], $pausa = false, $idVentas, $tipoSeleccionada = 'venta', $tiro, $modalHistorialFactura = 0, $invoices, $query = '', $clienteBarraBuscadora = [], $fechaRemision;

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->clientesBuscados) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->clientesBuscados) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectContact($pos)
    {
        $this->clienteBarraBuscadora = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteBarraBuscadora) {
            $this->clienteBarraBuscadora;
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clienteBarraBuscadora = [];
        $this->clientesBuscados = Cliente
            ::where('razon_social', 'like', '%' . $this->query . '%')
            ->orWhere('nombre', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->ruta = Ruta::all();
        $this->invoices = Invoice::all();
        Carbon::setLocale('es');
        $this->dateF = new Carbon();
        $this->dateFiltro = new Carbon($this->de);
        $this->tiro = Tiro::all();

        if ($this->rutaSeleccionada == "Todos" && $this->clienteBarraBuscadora) {
            $this->diaS = $this->dateF->translatedFormat('l');

            if ($this->fechaRemision) {
                $this->dateF = new Carbon($this->fechaRemision);
                $this->diaS = $this->dateF->translatedFormat('l');

                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get($this->diaS);
            } else {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get($this->diaS);
            }
            if ($this->tipoSeleccionada == 'venta') {

                if (count($this->ventaCopia) > 0 && $this->ventaCopia != null) {
                    $this->status = 'created';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Si tiene ventas!' : ''
                    ]);
                } else {
                    $this->status = 'error';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'error') ? '¡No tiene ventas!' : ''
                    ]);
                }
            } else {
                if (count($this->suscripcionCopia) > 0 && $this->suscripcionCopia != null) {
                    $this->status = 'created';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Si tiene suscripciones!' : ''
                    ]);
                } else {
                    $this->status = 'error';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'error') ? '¡No tiene suscripciones!' : ''
                    ]);
                }
            }
        } else if ($this->clienteBarraBuscadora) {
            $this->ventaCopia = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.cliente_id", "=", "ventas.cliente_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where(function ($query) {
                    $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                        ->where('ventas.tipo', '=', $this->tipoSeleccionada)
                        ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                })
                ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->suscripcionCopia = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->where(function ($query) {
                    $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                        ->where('suscripciones.tipo', '=', $this->tipoSeleccionada)
                        ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                })
                ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS);
        }

        return view('livewire.remisiones.generar', ['ventaCopia' => $this->ventaCopia, 'suscripcionCopia' => $this->suscripcionCopia,]);
    }

    public function descargaRemision()
    {
        if ($this->clienteSeleccionado && $this->clienteBarraBuscadora) {
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
                $pdf = PDF::loadView('livewire.tiros.remisionesPDFP', [
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
                $pdf = PDF::loadView('livewire.tiros.remisionPDF', [
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
                            'cliente' => $this->ventas[$i]['nombre'],
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
                            'status' => 'sin pagar',
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
                            'cliente' => $this->suscripcion[$i]['nombre'],
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
                            'status' => 'sin pagar',
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

            Storage::disk('public')->put('remision.pdf', $pdf);

            return Redirect::to('/PDFRemision');

            /*return response()
                ->streamDownload(
                    fn () => print($pdfContent),
                    "remisiones.pdf"
                );*/
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes seleccionar y buscar un cliente primero!' : ''
            ]);
        }
    }

    public function descargaTodasRemisiones()
    {
        if ($this->clienteBarraBuscadora) {
            if ($this->rutaSeleccionada != 'Todos') {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                            ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                    })
                    ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                            ->where('cliente.id', '=', $this->clienteBarraBuscadora['id']);
                    })
                    ->select("suscripciones.*", "cliente.*", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get($this->diaS);
            } else if ($this->clienteBarraBuscadora) {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where('cliente.id', '=', $this->clienteBarraBuscadora['id'])
                    ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where('cliente.id', '=', $this->clienteBarraBuscadora['id'])
                    ->select("suscripciones.*", "cliente.*", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get($this->diaS);
            }


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
                $pdf = PDF::loadView('livewire.tiros.remisionesPDFP', [
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
                $pdf = PDF::loadView('livewire.tiros.remisionPDF', [
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
                                'cliente' => $this->ventas[$i]['nombre'],
                                'entregar' => $this->ventas[$i]->{$this->diaS},
                                'devuelto' => $this->devuelto,
                                'faltante' => $this->faltante,
                                'venta' => $this->ventas[$i]->{$this->diaS},
                                'estado' => 'Activo',
                                'cliente_id' => $this->ventas[$i]->cliente_id,
                                'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                                'importe' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'] * $this->ventas[$i]->{$this->diaS},
                                'dia' => $this->diaS,
                                'status' => 'sin pagar',
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
                            'cliente' => $this->ventas[$i]['nombre'],
                            'entregar' => $this->ventas[$i]->{$this->diaS},
                            'devuelto' => $this->devuelto,
                            'faltante' => $this->faltante,
                            'venta' => $this->ventas[$i]->{$this->diaS},
                            'estado' => 'Activo',
                            'cliente_id' => $this->ventas[$i]->cliente_id,
                            'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                            'importe' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'] * $this->ventas[$i]->{$this->diaS},
                            'dia' => $this->diaS,
                            'status' => 'sin pagar',
                            'idTipo' => $this->ventas[$i]['idVenta'],
                            'nombreruta' => $this->ventas[$i]['nombreruta'],
                            'tipo' => $this->ventas[$i]['tiporuta'],
                        ]);
                        $this->toast();
                    }
                }
            } /* else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡No hay ventas para generar la remisión!' : ''
            ]);
        } */

            if (count($this->suscripcion) > 0) {
                for ($i = 0; $i < count($this->suscripcion); $i++) {
                    if (count($this->tiro) > 0) {
                        if (!Tiro::where('idTipo', '=', $this->suscripcion[$i]['idSuscripcion'])->exists()) {
                            Tiro::create([
                                'fecha' => $this->dateF,
                                'cliente' => $this->suscripcion[$i]['nombre'],
                                'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                                'devuelto' => $this->devuelto,
                                'faltante' => $this->faltante,
                                'estado' => 'Activo',
                                'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                                'venta' => $this->suscripcion[$i]['cantEjemplares'],
                                'precio' => $this->suscripcion[$i]->tarifa == 'Base' ? 330 : 300,
                                'importe' => $this->suscripcion[$i]->total,
                                'dia' => $this->diaS,
                                'status' => 'sin pagar',
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
                            'cliente' => $this->suscripcion[$i]['nombre'],
                            'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                            'devuelto' => $this->devuelto,
                            'faltante' => $this->faltante,
                            'estado' => 'Activo',
                            'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                            'venta' => $this->suscripcion[$i]['cantEjemplares'],
                            'precio' => $this->suscripcion[$i]->tarifa == 'Base' ? 330 : 300,
                            'importe' => $this->suscripcion[$i]->total,
                            'dia' => $this->diaS,
                            'status' => 'sin pagar',
                            'idTipo' => $this->suscripcion[$i]['idSuscripcion'],
                            'nombreruta' => $this->suscripcion[$i]['nombreruta'],
                            'tipo' => $this->suscripcion[$i]['tiporuta'],
                        ]);
                        $this->toast();
                    }
                }
            } /* else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡No hay suscripciones para generar la remisión!' : ''
            ]);
        } */

            $this->modalRemision = false;
            $this->showingModal = true;
            $this->clienteSeleccionado = [];

            Storage::disk('public')->put('remision.pdf', $pdf);

            return Redirect::to('/PDFRemision');
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Selecciona un cliente primero!' : ''
            ]);
        }
        /*return response()
            ->streamDownload(
                fn () => print($pdfContent),
                "remisiones.pdf"
            );*/
    }

    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisión generada exitosamente!' : ''
        ]);
    }
}

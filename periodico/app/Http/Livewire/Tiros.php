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
use Illuminate\Support\Facades\Redirect;
use App\Models\ventas;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class Tiros extends Component
{
    public $Ejemplares, $keyWord, $cliente = [], $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $res = [], $modal, $dateF, $Domicilios, $status = 'error', $devuelto = 0, $faltante = 0, $precio, $updateMode = false, $from, $to, $isGenerateTiro = 0, $clienteSeleccionado = [], $showingModal = false, $modalRemision = false, $importe, $modalHistorial = 0, $count = 0, $tiros = [], $modalEditar = 0, $tiro_id, $op, $ruta, $rutaSeleccionada = 'Todos', $de, $hasta, $dateFiltro, $entregar, $suscripcion = [], $sus = [], $array_merge = [], $ventas = [], $ventaCopia = [], $datosTiroSuscripcion = [], $domsubs = [], $suscripcionCopia = [], $rutaEncontrada = [], $domiciliosIdSacados = [], $rutasNombre = [], $domiPDF = [], $pausa = false;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        $domicilios = Domicilio::all();
        $this->ruta = Ruta::all();
        $suscripcion = Suscripcion::all();
        $ventas = ventas::all();
        $keyWord = '%' . $this->keyWord . '%';
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        $this->dateFiltro = new Carbon($this->de);

        if ($this->from) {
            $this->diaS = $this->dateF->translatedFormat('l');

            try {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('desde', '<=', $this->from)
                            ->where('hasta', '>=', $this->from);
                    })
                    ->select("ventas.*", "cliente.id", "cliente.nombre", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get($this->diaS);

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->where(function ($query) {
                        $query->where('fechaInicio', '<=', $this->from)
                            ->where('fechaFin', '>=', $this->from);
                    })
                    ->select("cliente.id", "cliente.nombre", "suscripciones.*")
                    ->get($this->diaS);

                foreach ($this->suscripcion as $key => $value) {
                    array_push($this->domiciliosIdSacados, $this->domsubs = domicilioSubs
                        ::whereIn('id', json_decode($this->suscripcion[$key]['domicilio_id']))
                        ->get());
                    array_push($this->rutaEncontrada, Ruta::where('id', $this->domiciliosIdSacados[$key][0]['ruta'])->get());
                }

                /* dd($this->rutaEncontrada[0][0]['nombreruta']); */

                /* dd($this->rutaEncontrada); */
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

            $this->ventaCopia = $this->ventas;
            $this->suscripcionCopia = $this->suscripcion;
            $this->rutaEncontrada;
        } else {
            $this->ventaCopia = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where(function ($query) {
                    $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada);
                })
                ->select("ventas.*", "cliente.id", "cliente.nombre", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->suscripcionCopia = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.cliente_id", "=", "suscripciones.cliente_id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->where(function ($query) {
                    $query->where('ruta.nombreruta', '=', $this->rutaSeleccionada);
                })
                ->select("cliente.id", "cliente.nombre", "suscripciones.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS);
        }

        return view('livewire.tiros.tiro', [
            'ventas' => $this->ventas,
            'resultado' => $this->resultados,
            'suscripcion' => $this->suscripcion,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
            'de' => $this->de,
            'hasta' => $this->hasta,
        ], compact('domicilios'));
    }

    /* public function busqueda()
    {
        if ($this->keyWord) {
        } else {
            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Primero escribe el nombre!' : ''
            ]);
        }
    } */

    public function descarga()
    {
        $this->isGenerateTiro = true;
        $this->modalRemision = false;

        $this->ventas = ventas
            ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("ventas.*", "cliente.id", "cliente.nombre", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->get($this->diaS);

        $this->suscripcion = Suscripcion
            ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
            ->join("domicilio_subs", "domicilio_subs.cliente_id", "=", "cliente.id")
            ->where('cliente.nombre', 'like', '%' . $this->keyWord . '%')
            ->select("cliente.id", "cliente.nombre", "suscripciones.*", "domicilio_subs.*")
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
    /* voy en esta parte recuerda checar la remision faltan datos de la suscripcion */
    public function descargaRemision()
    {
        // dd($this->clienteSeleccionado);
        if ($this->clienteSeleccionado) {
            // if (count($this->clienteSeleccionado) <= 1) {
            $this->status = 'created';

            $this->ventas = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->whereIn('cliente.id', $this->clienteSeleccionado)
                ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->suscripcion = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->whereIn('cliente.id', $this->clienteSeleccionado)
                ->select("cliente.*", "suscripciones.*")
                ->get($this->diaS);

            if (count($this->suscripcion) > 0) {
                $this->domsubs = domicilioSubs
                    ::whereIn('id', json_decode($this->suscripcion[0]['domicilio_id']))
                    ->get();

                /* foreach ($this->domsubs as $key => $value) {
                    $this->suscripcion[$key]['domicilio_id'] = $value;
                } */

                foreach ($this->domsubs as $key => $value) {
                    array_push($this->rutasNombre, ruta
                        ::where('ruta.id', '=', $this->domsubs[$key]['ruta'])
                        ->select('ruta.nombreruta')
                        ->get());
                }
                /* dd($this->rutasNombre[0][0]['nombreruta']); */
            }


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
                    'domsubs' => $this->domsubs,
                    'rutasNombre' => $this->rutasNombre,
                ])
                    ->setPaper('A5', 'landscape')
                    ->output();

                $this->clienteSeleccionado = [];
                $this->rutasNombre = [];
                $this->modalRemision = false;
            }

            $this->toast();

            /* es para el historial */
            if (count($this->ventas) > 0) {
                Tiro::create([
                    'fecha' => $this->dateF,
                    'cliente' => $this->ventas[0]['nombre'],
                    'entregar' => $this->ventas[0]->{$this->diaS},
                    'devuelto' => $this->devuelto,
                    'faltante' => $this->faltante,
                    'venta' => $this->ventas[0]->{$this->diaS},
                    'precio' => $this->diaS == 'domingo' ? $this->ventas[0]['dominical'] : $this->ventas[0]['ordinario'],
                    'importe' => $this->diaS == 'domingo' ? $this->ventas[0]['dominical'] : $this->ventas[0]['ordinario'] * $this->ventas[0]->{$this->diaS},
                    'dia' => $this->diaS,
                    'nombreruta' => $this->ventas[0]['nombreruta'],
                    'tipo' => $this->ventas[0]['tiporuta'],
                ]);
            }
            /* es para el historial subs */
            if (count($this->suscripcion) > 0) {
                // dd($this->suscripcion);
                $this->domsubs = domicilioSubs
                    ::whereIn('id', json_decode($this->suscripcion[0]['domicilio_id']))
                    ->get();

                /* foreach ($this->domsubs as $key => $value) {
                    $this->suscripcion[$key]['domicilio_id'] = $value;
                } */

                foreach ($this->domsubs as $key => $value) {
                    array_push($this->rutasNombre, ruta
                        ::where('ruta.id', '=', $this->domsubs[$key]['ruta'])
                        ->select('ruta.nombreruta', 'ruta.tiporuta')
                        ->get());
                }

                Tiro::create([
                    'fecha' => $this->dateF,
                    'cliente' => $this->suscripcion[0]['nombre'],
                    'entregar' => $this->suscripcion[0]->{$this->diaS},
                    'devuelto' => $this->devuelto,
                    'faltante' => $this->faltante,
                    'venta' => $this->suscripcion[0]->{$this->diaS},
                    'precio' => $this->suscripcion[0]->tarifa == 'Base' ? 330 : 300,
                    'importe' => $this->suscripcion[0]->total,
                    'dia' => $this->diaS,
                    'nombreruta' => $this->rutasNombre[0][0]['nombreruta'],
                    'tipo' => $this->rutasNombre[0][0]['tiporuta'],
                ]);
            }

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
        if ($state = Suscripcion::find($id)->estado == 'Pausado') {
            Suscripcion::find($id)->update([
                'estado' => 'Activo',
            ]);
        } else {
            Suscripcion::find($id)->update([
                'estado' => 'Pausado',
            ]);
        }
    }
    /* me quede en esta parte ya solo es crear otro pdf para evitar cagarla en el envio de información */
    public function descargaTodasRemisiones()
    {
        /* if ($this->clienteSeleccionado) { */

        $this->status = 'created';

        $this->ventas = ventas
            ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->get($this->diaS);

        $this->suscripcion = Suscripcion
            ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
            ->select("cliente.*", "suscripciones.*")
            ->get($this->diaS);

        // dd($this->suscripcion);

        for ($i = 0; $i < count($this->suscripcion); $i++) {
            array_push($this->domiPDF, $this->domsubs = domicilioSubs
                ::whereIn('id', json_decode($this->suscripcion[$i]['domicilio_id']))
                ->get());
        }
        dd($this->domiPDF);

        foreach ($this->domsubs as $key => $value) {
            array_push($this->rutasNombre, ruta
                ::where('ruta.id', '=', $this->domsubs[$key]['ruta'])
                ->select('ruta.nombreruta')
                ->get());
        }


        if ($this->de && $this->hasta) {
            $pdfContent = PDF::loadView('livewire.remisiones.todasremisiones', [
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
            $pdfContent = PDF::loadView('livewire.remisiones.todasremisiones', [
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

        $this->toast();

        foreach ($this->resultados as $resultado) {
            Tiro::create([
                'fecha' => $this->dateF,
                'cliente' => $resultado['nombre'],
                'entregar' => $resultado->{$this->diaS},
                'devuelto' => $this->devuelto,
                'faltante' => $this->faltante,
                'venta' => $resultado->{$this->diaS},
                'precio' => $this->diaS == 'domingo' ? $resultado['dominical'] : $resultado['ordinario'],
                'importe' => $this->diaS == 'domingo' ? $resultado['dominical'] : $resultado['ordinario'] * $resultado->{$this->diaS},
                'dia' => $this->diaS,
                'nombreruta' => $resultado['nombreruta'],
                'tipo' => $resultado['tiporuta'],
            ]);
        }

        $this->modalRemision = false;
        $this->showingModal = true;

        return response()
            ->streamDownload(
                fn () => print($pdfContent),
                "remisiones.pdf"
            );
        /* } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes seleccionar un elemento primero!' : ''
            ]);
        } */
    }

    public function historialRemision()
    {
        $this->modalHistorial = true;
        $this->modalRemision = false;
        $this->showingModal = false;

        $this->tiros = Tiro::all();
        /* dd($this->tiros[1]['cliente']); */
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

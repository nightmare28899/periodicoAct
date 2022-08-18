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

class Tiros extends Component
{
    public $Ejemplares, $keyWord, $cliente = [], $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $res = [], $modal, $dateF, $Domicilios, $status = 'error', $devuelto = 0, $faltante = 0, $precio, $updateMode = false, $from, $to, $isGenerateTiro = 0, $clienteSeleccionado = [], $showingModal = false, $modalRemision = false, $importe, $modalHistorial = 0, $count = 0, $tiros = [], $modalEditar = 0, $tiro_id, $op, $ruta, $rutaSeleccionada = 'Todos', $de, $hasta, $dateFiltro, $entregar, $suscripcion = [], $sus = [], $array_merge = [], $ventas = [], $ventaCopia = [];

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
            /* $ejemplares = Ejemplar::whereBetween('created_at', [$dateF->format('Y-m-d')." 00:00:00", $dateT->format('Y-m-d')." 23:59:59"])->get(); */
            /* $ejemplares = Ejemplar::whereDate('created_at', [$dateF->format('Y-m-d H:i:s')])->get($this->dia); */
            /* $this->resultados = Cliente
                ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
                ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where('nombre', 'like', '%' . $this->keyWord . '%')
                ->select("cliente.id", "cliente.nombre", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS); */
            /* dd($this->from); */

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
                ->select("cliente.id", "cliente.nombre", "suscripciones.*", "suscripciones.domicilio_id")
                ->get($this->diaS);
                /* dd($this->suscripcion); */
                /* dd(json_decode($this->suscripcion[0]->domicilio_id)); */
            
            /* $this->subs = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->whereIn('domicilio_subs.id', json_decode($this->suscripcion[0]->domicilio_id))
                ->where(function ($query) {
                    $query->where('fechaInicio', '<=', $this->from)
                          ->where('fechaFin', '>=', $this->from);
                })
                ->select("cliente.id", "cliente.nombre", "suscripciones.*", "domicilio_subs.*")
                ->get($this->diaS);
                dd($this->subs); */

                /* dd($this->suscripcion[0]->domicilio_id);
                dd(json_decode($this->suscripcion[0]->domicilio_id)); */
                $domsubs = DB::table('domicilio_subs')
                    ->whereIn('id', json_decode($this->suscripcion[0]->domicilio_id))
                    ->get();
                /* dd($domsubs); */
        }

        if ($this->rutaSeleccionada == "Todos") {
            $this->diaS = $this->dateF->translatedFormat('l');

            $this->ventaCopia = $this->ventas;

            /* $this->res = Cliente
                ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
                ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->select("cliente.id", "cliente.nombre", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->sus = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.cliente_id", "=", "cliente.id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->select("cliente.id", "cliente.nombre", "suscripciones.*", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS); */
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

            /* $this->res = Cliente
                ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
                ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                ->select("cliente.id", "cliente.nombre", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            $this->sus = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.cliente_id", "=", "cliente.id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->where('ruta.nombreruta', '=', $this->rutaSeleccionada)
                ->select("cliente.id", "cliente.nombre", "suscripciones.*", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get($this->diaS); */
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

        /* $this->resultados = Cliente
            ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->select("cliente.id", "cliente.nombre", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*")
            ->get($this->diaS); */

        /* $this->ventas = ventas
            ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("cliente.id", "cliente.nombre", "ventas.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->get($this->diaS); */

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

    public function descargaRemision()
    {
        /* dd($this->clienteSeleccionado); */
        if ($this->clienteSeleccionado) {
            // if (count($this->clienteSeleccionado) <= 1) {
            $this->status = 'created';

            $this->ventas = ventas
                ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                ->join("domicilio", "domicilio.cliente_id", "=", "ventas.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where('cliente.id', '=', $this->clienteSeleccionado)
                ->select("ventas.*", "cliente.id", "cliente.nombre", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            if ($this->de && $this->hasta) {
                $pdfContent = PDF::loadView('livewire.tiros.remisionesPDFP', [
                    'ventas' => $this->ventas,
                    'suscripcion' => $this->suscripcion,
                    'diaS' => $this->diaS,
                    'dateF' => $this->dateF,
                    'de' => $this->de,
                    'hasta' => $this->hasta,
                ])
                    ->setPaper('A5', 'landscape')
                    ->output();
            } else {
                $pdfContent = PDF::loadView('livewire.tiros.remisionPDF', [
                    'ventas' => $this->ventas,
                    'suscripcion' => $this->suscripcion,
                    'diaS' => $this->diaS,
                    'dateF' => $this->dateF,
                ])
                    ->setPaper('A5', 'landscape')
                    ->output();
            }

            $this->toast();

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

    public function descargaTodasRemisiones()
    {
        /* if ($this->clienteSeleccionado) { */

        $this->status = 'created';

        $this->resultados = Cliente
            ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("cliente.*", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->get($this->diaS);

        if ($this->de && $this->hasta) {
            $pdfContent = PDF::loadView('livewire.tiros.remisionesPDFP', [
                'resultado' => $this->resultados,
                'diaS' => $this->diaS,
                'dateF' => $this->dateF,
                'de' => $this->de,
                'hasta' => $this->hasta,
            ])
                ->setPaper('A5', 'landscape')
                ->output();
        } else {
            $pdfContent = PDF::loadView('livewire.tiros.remisionPDF', [
                'resultado' => $this->resultados,
                'diaS' => $this->diaS,
                'dateF' => $this->dateF,
            ])
                ->setPaper('A5', 'landscape')
                ->output();
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

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\Domicilio;
use App\Models\Ruta;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ventas;
use App\Models\Invoice;

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

        /* if (count($this->tiro) > 0) {
            $this->tiroStatus = Tiro
                ::join("invoices", "invoices.idTipo", "=", "tiro.idTipo")
                ->select("tiro.status")
                ->get();
        } */

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

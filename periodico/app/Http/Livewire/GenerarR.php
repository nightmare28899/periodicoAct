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
use Livewire\WithPagination;

class GenerarR extends Component
{
    use WithPagination;

    public $Ejemplares, $keyWord, $cliente = [], $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $res = [], $modal, $dateF, $Domicilios, $status = 'created', $devuelto = 0, $faltante = 0, $precio, $updateMode = false, $from, $to, $isGenerateTiro = 0, $clienteSeleccionado = [], $showingModal = false, $modalRemision = false, $importe, $modalHistorial = 0, $count = 0, $tiros = [], $modalEditar = 0, $tiro_id, $op, $ruta, $rutaSeleccionada = 'Todos', $de, $hasta, $dateFiltro, $entregar, $suscripcion = [], $sus = [], $array_merge = [], $ventas, $ventaCopia = [], $datosTiroSuscripcion = [], $domsubs = [], $suscripcionCopia = [], $rutaEncontrada = [], $domiciliosIdSacados = [], $rutasNombre = [], $domiPDF = [], $pausa = false, $idVentas, $tipoSeleccionada = 'todos', $tiro, $modalHistorialFactura = 0, $invoices, $query = '', $clienteBarraBuscadora = [], $fechaRemision, $ventaDia = [], $suscripcionesEncontradas = [], $clienteClasificacion = [], $ventasEncontradas = [], $clienteClasificacionVentas = [], $clientesBuscados = [];

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
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
        if ($this->query != '') {
            $this->clientesBuscados = Cliente
                ::where('id', '=',  $this->query)
                ->orWhere('nombre', 'like', '%' . $this->query . '%')
                ->limit(6)
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        $this->ruta = Ruta::all();
        $this->invoices = Invoice::all();
        Carbon::setLocale('es');
        $this->dateF = new Carbon();
        $this->dateFiltro = new Carbon($this->de);
        $this->tiro = Tiro::all();
        $this->diaS = $this->dateF->translatedFormat('l');

        if ($this->de && $this->hasta) {
            if ($this->tipoSeleccionada != 'todos') {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            } else {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }

            if ($this->rutaSeleccionada != "Todos" && $this->tipoSeleccionada != "todos") {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }

            if ($this->rutaSeleccionada != "Todos") {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }
        } else {
            if ($this->tipoSeleccionada != 'todos') {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            } else {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }

            if ($this->rutaSeleccionada != "Todos") {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }

            if ($this->rutaSeleccionada != "Todos" && $this->tipoSeleccionada != "todos") {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }
        }

        if ($this->de && $this->hasta && $this->query != "") {
            if ($this->tipoSeleccionada != 'todos') {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->whereDate("ventas.desde", ">=", $this->de)
                            ->whereDate("ventas.hasta", "<=", $this->hasta)
                            ->where('cliente.id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where('suscripciones.cliente_id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->whereBetween('suscripciones.created_at', [$this->de, $this->hasta])
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            } else {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('cliente.id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->whereDate("ventas.desde", ">=", $this->de)
                            ->whereDate("ventas.hasta", "<=", $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where('suscripciones.cliente_id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }

            if ($this->rutaSeleccionada != "Todos" && $this->tipoSeleccionada != "todos") {
                $this->ventaCopia = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate("ventas.desde", ">=", $this->de)
                            ->whereDate("ventas.hasta", "<=", $this->hasta)
                            ->where('cliente.id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get();

                $this->suscripcionCopia = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate("suscripciones.fechaInicio", ">=", $this->de)
                            ->whereDate("suscripciones.fechaFin", "<=", $this->hasta)
                            ->where('suscripciones.cliente_id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get();
            }
        } else {
            if ($this->query != "") {
                if ($this->tipoSeleccionada != 'todos') {
                    $this->ventaCopia = ventas
                        ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                        ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                        ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                        ->where(function ($query) {
                            $query->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where('ventas.tipo', '=', $this->tipoSeleccionada)
                                ->where("ventas.remisionStatus", "!=", "Remisionado")
                                ->where("ventas.estado", "=", "Activo");
                        })
                        ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                        ->get();

                    $this->suscripcionCopia = Suscripcion
                        ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                        ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                        ->where(function ($query) {
                            $query->where('suscripciones.cliente_id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where('suscripciones.tipo', '=', $this->tipoSeleccionada)
                                ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                        })
                        ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                        ->get();
                } else {
                    $this->ventaCopia = ventas
                        ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                        ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                        ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                        ->where(function ($query) {
                            $query->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("ventas.remisionStatus", "!=", "Remisionado")
                                ->where("ventas.estado", "=", "Activo");
                        })
                        ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                        ->get();

                    $this->suscripcionCopia = Suscripcion
                        ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                        ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                        ->where(function ($query) {
                            $query->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                        })
                        ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                        ->get();
                }

                if ($this->rutaSeleccionada != "Todos") {
                    $this->ventaCopia = ventas
                        ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                        ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                        ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                        ->where(function ($query) {
                            $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                                ->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("ventas.remisionStatus", "!=", "Remisionado")
                                ->where("ventas.estado", "=", "Activo");
                        })
                        ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                        ->get();

                    $this->suscripcionCopia = Suscripcion
                        ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                        ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                        ->where(function ($query) {
                            $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                                ->where('suscripciones.cliente_id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                        })
                        ->select("suscripciones.*", "cliente.nombre", "cliente.razon_social", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                        ->get();
                }
            }
        }

        return view('livewire.remisiones.generar', ['ventaCopia' => $this->ventaCopia, 'suscripcionCopia' => $this->suscripcionCopia, 'diaS' => $this->diaS, 'tiro' => $this->tiro]);
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
                ->get();

            $this->suscripcion = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                ->whereIn('suscripciones.idSuscripcion', $this->clienteSeleccionado)
                ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                ->get();

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
                    /* if (!Tiro::where('idTipo', '=', $this->clienteSeleccionado[$i])->exists()) { */
                    $clienteVenta = ventas::where('idVenta', '=', $this->ventas[$i]['idVenta'])->first();
                    $clienteFound = Cliente::find($clienteVenta->cliente_id);
                    Tiro::create([
                        'fecha' => $this->dateF->format('Y-m-d'),
                        'cliente' => $this->ventas[$i]['nombre'],
                        'entregar' => $this->ventas[$i]->lunes + $this->ventas[$i]->martes + $this->ventas[$i]->miércoles + $this->ventas[$i]->jueves + $this->ventas[$i]->viernes + $this->ventas[$i]->sábado + $this->ventas[$i]->domingo,
                        'devuelto' => $this->devuelto,
                        'faltante' => $this->faltante,
                        'venta' => $this->ventas[$i]->lunes + $this->ventas[$i]->martes + $this->ventas[$i]->miércoles + $this->ventas[$i]->jueves + $this->ventas[$i]->viernes + $this->ventas[$i]->sábado + $this->ventas[$i]->domingo,
                        'estado' => 'Activo',
                        'cliente_id' => $this->ventas[$i]->cliente_id,
                        'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                        'importe' => $this->ventas[$i]->total,
                        'dia' => $this->diaS,
                        'idTipo' => $this->clienteSeleccionado[$i],
                        'nombreruta' => $this->ventas[$i]['nombreruta'],
                        'status' => $clienteFound->clasificacion  == 'CRÉDITO' ? 'CREDITO' : 'sin pagar',
                        'tipo' => $this->ventas[$i]['tiporuta'],
                        'domicilio_id' => $this->ventas[$i]->domicilio_id,
                    ]);

                    ventas::where('idVenta', '=', $this->ventas[$i]['idVenta'])->update([
                        'remisionStatus' => 'Remisionado',
                    ]);

                    $this->modalRemision = false;
                    $this->showingModal = true;
                    $this->toast();
                    /* } */
                }
            }

            if (count($this->suscripcion) > 0) {
                for ($i = 0; $i < count($this->clienteSeleccionado); $i++) {
                    /* if (!Tiro::where('idTipo', '=', $this->clienteSeleccionado[$i])->exists()) { */
                    $clienteSuscripcion = Suscripcion::where('idSuscripcion', '=', $this->suscripcion[$i]['idSuscripcion'])->first();
                    $clienteFoundSus = Cliente::find($clienteSuscripcion->cliente_id);

                    Tiro::create([
                        'fecha' => $this->dateF->format('Y-m-d'),
                        'cliente' => $this->suscripcion[$i]['nombre'],
                        'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                        'devuelto' => $this->devuelto,
                        'faltante' => $this->faltante,
                        'estado' => 'Activo',
                        'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                        'venta' => $this->suscripcion[$i]['cantEjemplares'],
                        'precio' => ($this->suscripcion[$i]->total / $this->suscripcion[$i]->cantEjemplares),
                        'importe' => $this->suscripcion[$i]->total,
                        'dia' => $this->diaS,
                        'idTipo' => $this->clienteSeleccionado[$i],
                        'nombreruta' => $this->suscripcion[$i]['nombreruta'],
                        'status' => $clienteFoundSus->clasificacion == 'CRÉDITO' ? 'CREDITO' : 'sin pagar',
                        'tipo' => $this->suscripcion[$i]['tiporuta'],
                        'domicilio_id' => $this->suscripcion[$i]['domicilio_id'],
                    ]);

                    Suscripcion::where('idSuscripcion', '=', $this->suscripcion[$i]['idSuscripcion'])->update([
                        'remisionStatus' => 'Remisionado',
                    ]);

                    $this->modalRemision = false;
                    $this->showingModal = true;
                    $this->toast();
                    /* } */
                }
            }

            $this->clienteSeleccionado = [];

            Storage::disk('public')->put('remision.pdf', $pdf);

            return Redirect::to('/PDFRemision');
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes seleccionar un elemento primero!' : ''
            ]);
        }
    }

    public function descargaTodasRemisiones()
    {
        if ($this->de && $this->hasta) {
            if ($this->tipoSeleccionada != 'todos') {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            } else {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }

            if ($this->rutaSeleccionada != "Todos" && $this->tipoSeleccionada != "todos") {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }

            if ($this->rutaSeleccionada != "Todos") {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->whereDate('ventas.desde', '<=', $this->de)
                            ->whereDate('ventas.hasta', '>=', $this->hasta)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }
        } else {
            if ($this->tipoSeleccionada != 'todos') {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            } else {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }

            if ($this->rutaSeleccionada != "Todos") {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }

            if ($this->rutaSeleccionada != "Todos" && $this->tipoSeleccionada != "todos") {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }
        }

        if ($this->de && $this->hasta && $this->query != "") {
            if ($this->tipoSeleccionada != 'todos') {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->whereDate("ventas.desde", ">=", $this->de)
                            ->whereDate("ventas.hasta", "<=", $this->hasta)
                            ->where('cliente.id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where('suscripciones.cliente_id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->whereBetween('suscripciones.created_at', [$this->de, $this->hasta])
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            } else {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where('cliente.id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->whereDate("ventas.desde", ">=", $this->de)
                            ->whereDate("ventas.hasta", "<=", $this->hasta)
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->whereDate('suscripciones.fechaInicio', '<=', $this->de)
                            ->whereDate('suscripciones.fechaFin', '>=', $this->hasta)
                            ->where('suscripciones.cliente_id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }

            if ($this->rutaSeleccionada != "Todos" && $this->tipoSeleccionada != "todos") {
                $this->ventas = ventas
                    ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                    ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                    ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                    ->where(function ($query) {
                        $query->where("ventas.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate("ventas.desde", ">=", $this->de)
                            ->whereDate("ventas.hasta", "<=", $this->hasta)
                            ->where('cliente.id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("ventas.remisionStatus", "!=", "Remisionado")
                            ->where("ventas.estado", "=", "Activo");
                    })
                    ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                    ->get()
                    ->toArray();

                $this->suscripcion = Suscripcion
                    ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                    ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                    ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                    ->where(function ($query) {
                        $query->where("suscripciones.tipo", "=", $this->tipoSeleccionada)
                            ->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                            ->whereDate("suscripciones.fechaInicio", ">=", $this->de)
                            ->whereDate("suscripciones.fechaFin", "<=", $this->hasta)
                            ->where('suscripciones.cliente_id', '=', $this->query)
                            ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                            ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                    })
                    ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                    ->get()
                    ->toArray();
            }
        } else {
            if ($this->query != "") {
                if ($this->tipoSeleccionada != 'todos') {
                    $this->ventas = ventas
                        ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                        ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                        ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                        ->where(function ($query) {
                            $query->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where('ventas.tipo', '=', $this->tipoSeleccionada)
                                ->where("ventas.remisionStatus", "!=", "Remisionado")
                                ->where("ventas.estado", "=", "Activo");
                        })
                        ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                        ->get()
                        ->toArray();

                    $this->suscripcion = Suscripcion
                        ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                        ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                        ->where(function ($query) {
                            $query->where('suscripciones.cliente_id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where('suscripciones.tipo', '=', $this->tipoSeleccionada)
                                ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                        })
                        ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                        ->get()
                        ->toArray();
                } else {
                    $this->ventas = ventas
                        ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                        ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                        ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                        ->where(function ($query) {
                            $query->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("ventas.remisionStatus", "!=", "Remisionado")
                                ->where("ventas.estado", "=", "Activo");
                        })
                        ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                        ->get()
                        ->toArray();

                    $this->suscripcion = Suscripcion
                        ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                        ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                        ->where(function ($query) {
                            $query->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                        })
                        ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                        ->get()
                        ->toArray();
                }

                if ($this->rutaSeleccionada != "Todos") {
                    $this->ventas = ventas
                        ::join("cliente", "cliente.id", "=", "ventas.cliente_id")
                        ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                        ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                        ->where(function ($query) {
                            $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                                ->where('cliente.id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("ventas.remisionStatus", "!=", "Remisionado")
                                ->where("ventas.estado", "=", "Activo");
                        })
                        ->select("ventas.*", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                        ->get()
                        ->toArray();

                    $this->suscripcion = Suscripcion
                        ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                        ->join("domicilio_subs", "domicilio_subs.id", "=", "suscripciones.domicilio_id")
                        ->join("ruta", "ruta.id", "=", "domicilio_subs.ruta")
                        ->where(function ($query) {
                            $query->where("ruta.nombreruta", "=", $this->rutaSeleccionada)
                                ->where('suscripciones.cliente_id', '=', $this->query)
                                ->orWhere('cliente.nombre', 'like', '%' . $this->query . '%')
                                ->orWhere('cliente.razon_social', 'like', '%' . $this->query . '%')
                                ->where("suscripciones.remisionStatus", "!=", "Remisionado");
                        })
                        ->select("suscripciones.suscripcion", "suscripciones.cliente_id", "suscripciones.esUnaSuscripcion", "suscripciones.idSuscripcion", "suscripciones.tarifa", "suscripciones.cantEjemplares", "suscripciones.precio", "suscripciones.contrato", "suscripciones.tipoSuscripcion", "suscripciones.periodo", "suscripciones.fechaInicio", "suscripciones.fechaFin", "suscripciones.dias", "suscripciones.lunes", "suscripciones.martes", "suscripciones.miércoles", "suscripciones.jueves", "suscripciones.viernes", "suscripciones.sábado", "suscripciones.domingo", "suscripciones.tipo", "suscripciones.descuento", "suscripciones.observaciones", "suscripciones.importe", "suscripciones.total", "suscripciones.domicilio_id", "suscripciones.created_at", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.estado", "cliente.pais", "domicilio_subs.*", "ruta.nombreruta", "ruta.tiporuta")
                        ->get()
                        ->toArray();
                }
            }
        }

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
                /* if (!Tiro::where('idTipo', '=', $this->ventas[$i]['idVenta'])->exists()) { */
                $clienteVenta = ventas::where('idVenta', '=', $this->ventas[$i]['idVenta'])->first();
                $clienteFound = Cliente::find($clienteVenta->cliente_id);

                Tiro::create([
                    'fecha' => $this->dateF->format('Y-m-d'),
                    'cliente' => $this->ventas[$i]['nombre'],
                    'entregar' => $this->ventas[$i]['lunes'] + $this->ventas[$i]['martes'] + $this->ventas[$i]['miércoles'] + $this->ventas[$i]['jueves'] + $this->ventas[$i]['viernes'] + $this->ventas[$i]['sábado'] + $this->ventas[$i]['domingo'],
                    'devuelto' => $this->devuelto,
                    'faltante' => $this->faltante,
                    'venta' => $this->ventas[$i]['lunes'] + $this->ventas[$i]['martes'] + $this->ventas[$i]['miércoles'] + $this->ventas[$i]['jueves'] + $this->ventas[$i]['viernes'] + $this->ventas[$i]['sábado'] + $this->ventas[$i]['domingo'],
                    'estado' => 'Activo',
                    'cliente_id' => $this->ventas[$i]['cliente_id'],
                    'precio' => $this->diaS == 'domingo' ? $this->ventas[$i]['dominical'] : $this->ventas[$i]['ordinario'],
                    'importe' => $this->ventas[$i]['total'],
                    'dia' => $this->diaS,
                    'status' => $clienteFound->clasificacion == 'CRÉDITO' ? 'CREDITO' : 'sin pagar',
                    'idTipo' => $this->ventas[$i]['idVenta'],
                    'nombreruta' => $this->ventas[$i]['nombreruta'],
                    'tipo' => $this->ventas[$i]['tiporuta'],
                    'domicilio_id' => $this->ventas[$i]['domicilio_id'],
                ]);
                ventas::where('idVenta', '=', $this->ventas[$i]['idVenta'])->update([
                    'remisionStatus' => 'Remisionado',
                ]);
                /* } */
            }
        }

        if (count($this->suscripcion) > 0) {
            for ($i = 0; $i < count($this->suscripcion); $i++) {
                /* if (!Tiro::where('idTipo', '=', $this->suscripcion[$i]['idSuscripcion'])->exists()) { */
                $clienteSuscripcion = Suscripcion::where('idSuscripcion', '=', $this->suscripcion[$i]['idSuscripcion'])->first();
                $clienteFoundSus = Cliente::find($clienteSuscripcion->cliente_id);

                Tiro::create([
                    'fecha' => $this->dateF->format('Y-m-d'),
                    'cliente' => $this->suscripcion[$i]['nombre'],
                    'entregar' => $this->suscripcion[$i]['cantEjemplares'],
                    'devuelto' => $this->devuelto,
                    'faltante' => $this->faltante,
                    'estado' => 'Activo',
                    'cliente_id' => $this->suscripcion[$i]['cliente_id'],
                    'venta' => $this->suscripcion[$i]['cantEjemplares'],
                    'precio' => $this->suscripcion[$i]['total'] = ($this->suscripcion[$i]['total'] / $this->suscripcion[$i]['cantEjemplares']),
                    'importe' => $this->suscripcion[$i]['total'],
                    'dia' => $this->diaS,
                    'status' => $clienteFoundSus->clasificacion == 'CRÉDITO' ? 'CREDITO' : 'sin pagar',
                    'idTipo' => $this->suscripcion[$i]['idSuscripcion'],
                    'nombreruta' => $this->suscripcion[$i]['nombreruta'],
                    'tipo' => $this->suscripcion[$i]['tiporuta'],
                    'domicilio_id' => $this->suscripcion[$i]['domicilio_id'],
                ]);
                Suscripcion::where('idSuscripcion', '=', $this->suscripcion[$i]['idSuscripcion'])->update([
                    'remisionStatus' => 'Remisionado',
                ]);
                /* } */
            }
        }

        $this->modalRemision = false;
        $this->showingModal = true;
        /* $this->clienteSeleccionado = []; */

        Storage::disk('public')->put('remision.pdf', $pdf);

        $this->toast();

        return Redirect::to('/PDFRemision');
    }

    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisión generada exitosamente!' : ''
        ]);
    }
}

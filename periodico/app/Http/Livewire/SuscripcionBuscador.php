<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use Carbon\Carbon;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use Barryvdh\DomPDF\Facade\Pdf;

class SuscripcionBuscador extends Component
{
    public $suscripcion = 0, $query, $clientesBuscados, $highlightIndex, $dataClient = [], $clienteSeleccionado, $status = 'created';
    public $oferta = false, $tipoSubscripcion = 'Normal', $subscripcionEs = 'Apertura', $precio = 'Normal', $contrato = 'Suscripción', $cantEjem = 0, $diasSuscripcionSeleccionada = '', $observacion, $descuento = 0, $totalDesc = 0, $tipoSuscripcionSeleccionada, $allow = true, $tarifaSeleccionada, $formaPagoSeleccionada, $periodoSuscripcionSeleccionada = '', $modificarFecha = false, $from, $to, $total = 0, $iva = 0, $modalDomSubs = 0, $modalFormDom = 0, $domiciliosSubs, $datoSeleccionado, $domicilioSeleccionado = [], $parametro = [], $domicilioSubsId, $arregloDatos = [], $modalV = 0, $desde, $hasta, $converHasta, $domicilioId, $editEnabled = false, $ventas, $cantDom = 0, $cantArray = [], $inputCantidad, $posicion, $posicionDomSubs, $idSuscrip, $clients;
    public $Ejemplares, $lunes, $martes, $miércoles, $jueves, $viernes, $sábado, $domingo;

    public function mount()
    {
        /* $this->suscripcion = $status; */
        $this->resetear();
    }

    public function modalCrearDomSubs()
    { {
            $this->clienteSeleccionado ? $this->modalDomSubs = true : $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Seleccione un cliente!' : ''
            ]);
        }
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->highlightIndex = 0;
    }

    public function selectContact($pos)
    {
        /* $this->clienteSeleccionado = $this->clientesBuscados[$this->highlightIndex] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            $this->resetear();
        } */
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('razon_social', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->date = new Carbon();
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        $this->converHasta = new Carbon($this->desde);
        $this->dateFiltro = new Carbon($this->to);
        $this->desde = $this->converHasta->format('Y-m-d');
        $this->from = $this->dateF->format('Y-m-d');

        $days = $this->periodoSuscripcionSeleccionada === 'Mensual'
            ? 1
            : ($this->periodoSuscripcionSeleccionada === 'Trimestral'
                ? 3
                : ($this->periodoSuscripcionSeleccionada === 'Semestral'
                    ? 6
                    : ($this->periodoSuscripcionSeleccionada === 'Anual'
                        ? 12
                        : 0)));

        $this->to = $this->dateF->addMonth($days)->format('Y-m-d');

        $days > 0 ? $this->modificarFecha = false : $this->modificarFecha = true;


        $this->domiciliosSubs = DomicilioSubs
            ::join("cliente", "cliente.id", "=", "domicilio_subs.cliente_id")
            ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
            ->select('domicilio_subs.*', 'ruta.nombreruta')
            ->get();

        if ($this->diasSuscripcionSeleccionada) {
            if ($this->diasSuscripcionSeleccionada == 'l_v') {
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = false;
                $this->domingo = false;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'l_d') {
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = true;
                $this->domingo = true;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'esc_man') {
                $this->allow = true;
            }
        }

        if ($this->tarifaSeleccionada) {
            $costo = 0;
            if ($this->cantEjem >= 1) {
                $costo = $this->tarifaSeleccionada === 'Base' ? 330 : ($this->tarifaSeleccionada === 'Ejecutiva' ? 300 : 0);
                $this->total = $this->cantEjem * $costo;
                $this->totalDesc = $this->cantEjem * $costo;
            } else {
                $this->total = 0;
                $this->totalDesc = 0;
            }
            if ($this->descuento) { {
                    $this->descuento <= $this->total ? $this->totalDesc = ($this->total - $this->descuento) : $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡No puedes aplicar un descuento mayora la cantidad!' : ''
                    ]);
                }
            }
        }

        if ($this->clienteSeleccionado && $this->subscripcionEs == 'Renovación') {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();

            $this->domicilioId = $this->suscripciones[0]->domicilio_id;
            $this->cantEjem = $this->suscripciones[0]->cantEjemplares;
            $this->tipoSubscripcion = $this->suscripciones[0]->suscripcion;
            /* $this->subscripcionEs = $this->suscripciones[0]->esUnaSuscripcion; */
            $this->tarifaSeleccionada = $this->suscripciones[0]->tarifa;
            $this->tipoSuscripcionSeleccionada = $this->suscripciones[0]->tipoSuscripcion;
            /* $this->periodoSuscripcionSeleccionada = $this->suscripciones[0]->periodo; */
            $this->diasSuscripcionSeleccionada = $this->suscripciones[0]->dias;
            /* $this->from = $this->suscripciones[0]->fechaInicio;
            $this->to = $this->suscripciones[0]->fechaFin; */
            $this->contrato = $this->suscripciones[0]->contrato;
            $this->lunes = $this->suscripciones[0]->lunes;
            $this->martes = $this->suscripciones[0]->martes;
            $this->miércoles = $this->suscripciones[0]->miércoles;
            $this->jueves = $this->suscripciones[0]->jueves;
            $this->viernes = $this->suscripciones[0]->viernes;
            $this->sábado = $this->suscripciones[0]->sábado;
            $this->domingo = $this->suscripciones[0]->domingo;
            $this->descuento = $this->suscripciones[0]->descuento;
            $this->observacion = $this->suscripciones[0]->observaciones;
            $this->total = $this->suscripciones[0]->importe;
            $this->totalDesc = $this->suscripciones[0]->total;
            $this->formaPagoSeleccionada = $this->suscripciones[0]->formaPago;
            /* $this->domicilioS = domicilioSubs
                ::join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('cliente_id', $this->clienteSeleccionado)
                ->select('domicilio_subs.*', 'ruta.nombreruta')
                ->get();
            $this->domicilioSeleccionado = $this->domicilioS;

            $this->inputCantidad = $this->domicilioS[0]->ejemplares;
            $this->cantDom = $this->inputCantidad; */
        }

        if ($this->clienteSeleccionado && $this->contrato == 'Cortesía') {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();
            $this->total = 0;
            $this->totalDesc = 0;
        }

        return view('livewire.suscripcion-buscador', [
            'clientes' => $this->clientesBuscados,
            'desde' => $this->desde,
        ]);
    }
}

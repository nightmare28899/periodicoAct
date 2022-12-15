<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Suscripcion;
use App\Models\SuscripcionSupendida;
use App\Models\Cliente;
use Carbon\Carbon;
use Doctrine\DBAL\Query;

class HistorialSuscripciones extends Component
{
    public $suscripciones, $fechaSuscripcion, $diaS, $dateF, $suscripcionSuspendida, $clientesBuscados, $query, $estatusPago = 'Todas', $contador = 0, $de, $hasta;

    public function render()
    {
        $this->dateF = new Carbon();
        $this->diaS = $this->dateF->translatedFormat('l');

        $this->suscripcionSuspendida = SuscripcionSupendida
            ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
            ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
            ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
            ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
            ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta', 'tiro.idTipo', 'tiro.status')
            ->get();

        if ($this->query && $this->estatusPago == 'Todas') {
            $this->suscripciones = Suscripcion
                ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                ->where('cliente.nombre', 'like', '%' . $this->query . '%')
                ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                ->get($this->diaS);
        } else {
            if (count($this->suscripcionSuspendida) > 0 && $this->estatusPago == 'Todas') {
                for ($i = 0; $i < count($this->suscripcionSuspendida); $i++) {
                    $this->suscripciones = Suscripcion
                        ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                        ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                        ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                        ->where('suscripciones.id', '!=', $this->suscripcionSuspendida[$i]['id'])
                        ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                        ->get($this->diaS);
                }
            } else if ($this->estatusPago == 'Todas') {
                $this->suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                    ->get($this->diaS);
            }
        }

        if ($this->estatusPago != 'Todas') {

            if (count($this->suscripcionSuspendida) > 0 && $this->estatusPago != 'Todas') {
                for ($this->contador; $this->contador < count($this->suscripcionSuspendida); $this->contador++) {
                    $this->suscripciones = Suscripcion
                        ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                        ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                        ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                        ->where(function ($query) {
                            $query->where('suscripciones.id', '!=', $this->suscripcionSuspendida[$this->contador]['id'])
                                ->where('tiro.status', '=', $this->estatusPago);
                        })
                        ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                        ->get($this->diaS);
                }
                $this->contador = 0;
            } else if ($this->estatusPago == 'Todas') {
                $this->suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                    ->where(function ($query) {
                        $query->where('tiro.status', '=', $this->estatusPago);
                    })
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                    ->get($this->diaS);
            }

            $this->suscripcionSuspendida = SuscripcionSupendida
                ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                ->where('tiro.status', '=', $this->estatusPago)
                ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta', 'tiro.idTipo', 'tiro.status')
                ->get();
        }

        if ($this->de && $this->hasta) {
            if (count($this->suscripcionSuspendida) > 0 && $this->estatusPago == 'Todas') {
                for ($this->contador; $this->contador < count($this->suscripcionSuspendida); $this->contador++) {
                    $this->suscripciones = Suscripcion
                        ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                        ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                        ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                        ->where(function ($query) {
                            $query->where('suscripciones.id', '!=', $this->suscripcionSuspendida[$this->contador]['id'])
                                ->where('suscripciones.fechaInicio', '<=', $this->de)
                                ->where('suscripciones.fechaFin', '>=', $this->hasta);
                        })
                        ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                        ->get($this->diaS);
                }
                $this->contador = 0;
            } else if ($this->estatusPago == 'Todas') {
                $this->suscripciones = Suscripcion
                    ::join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                    ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                    ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                    ->where(function ($query) {
                        $query->where('suscripciones.fechaInicio', '<=', $this->de)
                            ->where('suscripciones.fechaFin', '>=', $this->hasta);
                    })
                    ->select('suscripciones.*', 'cliente.nombre', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.ciudad', 'tiro.idTipo', 'tiro.status')
                    ->get($this->diaS);
            }

            $this->suscripcionSuspendida = SuscripcionSupendida
                ::join('suscripciones', 'suscripciones.id', '=', 'suscripcion_suspension.id')
                ->join('cliente', 'cliente.id', '=', 'suscripciones.cliente_id')
                ->join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'suscripciones.cliente_id')
                ->join('tiro', 'tiro.idTipo', '=', 'suscripciones.idSuscripcion')
                ->where(function ($query) {
                    $query->where('suscripciones.fechaInicio', '<=', $this->de)
                        ->where('suscripciones.fechaFin', '>=', $this->hasta);
                })
                ->select('suscripcion_suspension.*', 'suscripciones.cliente_id', 'suscripciones.cantEjemplares', 'suscripciones.periodo', 'suscripciones.fechaInicio', 'suscripciones.fechaFin', 'suscripciones.lunes', 'suscripciones.martes', 'suscripciones.miércoles', 'suscripciones.jueves', 'suscripciones.viernes', 'suscripciones.sábado', 'suscripciones.domingo', 'suscripciones.estado', 'suscripciones.created_at', 'cliente.nombre', 'domicilio_subs.cliente_id', 'domicilio_subs.calle', 'domicilio_subs.noint', 'domicilio_subs.noext', 'domicilio_subs.colonia', 'domicilio_subs.cp', 'domicilio_subs.localidad', 'domicilio_subs.ciudad', 'domicilio_subs.referencia', 'domicilio_subs.ruta', 'tiro.idTipo', 'tiro.status')
                ->get();
        }


        return view('livewire.historial-suscripciones', [
            'suscripciones' => $this->suscripciones,
            'suscripcionSuspendida' => $this->suscripcionSuspendida
        ]);
    }
}

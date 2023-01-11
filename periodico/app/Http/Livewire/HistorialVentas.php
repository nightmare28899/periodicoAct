<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ventas;
use App\Models\Ruta;

class HistorialVentas extends Component
{
    public $ventas, $query = '', $estatusPago = 'Todas', $desde, $hasta, $ruta, $rutaSeleccionada = "Todos";

    public function render()
    {
        $this->ruta = Ruta::all();

        if ($this->estatusPago != 'Todas') {
            $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                ->where('ventas.estado', $this->estatusPago)
                ->get();

            if ($this->desde && $this->hasta) {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ventas.estado', $this->estatusPago)
                            ->whereDate('ventas.desde', '<=', $this->desde)
                            ->whereDate('ventas.hasta', '>=', $this->hasta);
                    })
                    ->get();
            }

            if ($this->query != '') {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ventas.estado', $this->estatusPago)
                            ->where('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('ventas.id', $this->query)
                            ->orWhere('ventas.cliente_id', $this->query);
                    })
                    ->get();
            }

            if ($this->desde && $this->hasta && $this->query != '') {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->where(function ($query) {
                        $query->where('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->where('ventas.estado', $this->estatusPago)
                            ->orWhere('ventas.id', $this->query)
                            ->orWhere('ventas.cliente_id', $this->query)
                            ->whereDate('ventas.desde', '<=', $this->desde)
                            ->whereDate('ventas.hasta', '>=', $this->hasta);
                    })
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->get();
            }
        } else {
            if ($this->rutaSeleccionada == 'Todos') {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->get();
            } else {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ruta.nombreruta', $this->rutaSeleccionada);
                    })
                    ->get();
            }

            if ($this->desde && $this->hasta) {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->where(function ($query) {
                        $query->whereDate('ventas.desde', '<=', $this->desde)
                            ->whereDate('ventas.hasta', '>=', $this->hasta);
                    })
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->get();
            }

            if ($this->query != '') {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('ventas.id', $this->query)
                            ->orWhere('ventas.cliente_id', $this->query);
                    })
                    ->get();
            }

            if ($this->desde && $this->hasta && $this->query != '') {
                $this->ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('ventas.id', $this->query)
                            ->orWhere('ventas.cliente_id', $this->query)
                            ->whereDate('ventas.desde', '<=', $this->desde)
                            ->whereDate('ventas.hasta', '>=', $this->hasta);
                    })
                    ->get();
            }
        }

        return view('livewire.historial-ventas', [
            'ventas' => $this->ventas,
            'ruta' => $this->ruta,
        ]);
    }
}

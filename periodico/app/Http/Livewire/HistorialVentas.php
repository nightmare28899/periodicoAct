<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ventas;
use App\Models\Ruta;
use Livewire\WithPagination;

class HistorialVentas extends Component
{
    use WithPagination;

    public $query = '', $estatusPago = 'Todas', $desde, $hasta, $ruta, $rutaSeleccionada = "Todos";

    public function render()
    {
        $this->ruta = Ruta::all();

        if ($this->estatusPago != 'Todas') {
            $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                ->where('ventas.estado', $this->estatusPago)
                ->paginate(10);

            if ($this->desde && $this->hasta) {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ventas.estado', $this->estatusPago)
                            ->whereDate('ventas.desde', '<=', $this->desde)
                            ->whereDate('ventas.hasta', '>=', $this->hasta);
                    })
                    ->paginate(10);
            }

            if ($this->query != '') {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ventas.estado', $this->estatusPago)
                            ->where('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('ventas.id', $this->query)
                            ->orWhere('ventas.cliente_id', $this->query);
                    })
                    ->paginate(10);
            }

            if ($this->desde && $this->hasta && $this->query != '') {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
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
                    ->paginate(10);
            }

            if ($this->rutaSeleccionada != 'Todos') {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ruta.nombreruta', $this->rutaSeleccionada)
                            ->where('ventas.estado', $this->estatusPago);
                    })
                    ->paginate(10);
            }
        } else {
            if ($this->rutaSeleccionada == 'Todos') {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->paginate(10);
            } else {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('ruta.nombreruta', $this->rutaSeleccionada);
                    })
                    ->paginate(10);
            }

            if ($this->desde && $this->hasta) {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->where(function ($query) {
                        $query->whereDate('ventas.desde', '<=', $this->desde)
                            ->whereDate('ventas.hasta', '>=', $this->hasta);
                    })
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->paginate(10);
            }

            if ($this->query != '') {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
                    ->join('domicilio', 'domicilio.id', '=', 'ventas.domicilio_id')
                    ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                    ->select('ventas.*', 'cliente.nombre', 'domicilio.calle', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.cp', 'domicilio.noext', 'domicilio.noint', 'ruta.nombreruta')
                    ->where(function ($query) {
                        $query->where('cliente.nombre', 'like', '%' . $this->query . '%')
                            ->orWhere('ventas.id', $this->query)
                            ->orWhere('ventas.cliente_id', $this->query);
                    })
                    ->paginate(10);
            }

            if ($this->desde && $this->hasta && $this->query != '') {
                $ventas = ventas::join('cliente', 'cliente.id', '=', 'ventas.cliente_id')
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
                    ->paginate(10);
            }
        }

        return view('livewire.historial-ventas', [
            'ruta' => $this->ruta,
        ], compact('ventas'));
    }
}

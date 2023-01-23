<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\ventas;
use App\Models\Remisionid;
use Carbon\Carbon;

class Devolver extends Component
{
    public $ventas, $tiro, $remisiones = [], $idRemision, $datoEncontrado, $datesFound = [], $dias = [];

    public function render()
    {
        $this->remisiones = Remisionid::all();
        foreach ($this->remisiones as $remision) {
            $remisionFoundId = explode(',', $remision->remisiones_id);

            for ($i = 0; $i < count($remisionFoundId); $i++) {
                if ((int)$remisionFoundId[$i] == $this->idRemision) {
                    $this->datesFound = explode(',', $remision->fechas);
                    $this->dias = explode(',', $remision->dias);
                    /* dd($this->idRemision, $remision->remisiones_id, $remision->fechas); */
                }
            }
        }

        return view('livewire.ventas.devolver', [
            'ventas' => $this->ventas,
            'tiro' => $this->tiro,
            'remisiones' => $this->remisiones,
            'fechas' => $this->datesFound,
            'dias' => $this->dias
        ]);
    }

    public function mount($id)
    {
        $this->idRemision = $id;
        $this->tiro = Tiro::find($id);
        $this->ventas = Ventas::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->where('idVenta', $this->tiro->idTipo)
            ->first();
    }
}

<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\ventas;
use App\Models\Remisionid;
use App\Models\devolucionVenta;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class Devolver extends Component
{
    public $ventas, $tiro, $remisiones = [], $idRemision, $datoEncontrado, $datesFound = [], $dias = [], $cantDevolver = [], $cantidades = [], $modalConfirmar = false, $status = 'created', $implodeCant, $calculoImporte = 0;

    public function render()
    {
        $this->remisiones = Remisionid::all();
        $this->ventas = Ventas::join("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->join("domicilio", "domicilio.id", "=", "ventas.domicilio_id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
            ->select("ventas.*", "cliente.*", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
            ->where('idVenta', $this->tiro->idTipo)
            ->first();

        foreach ($this->remisiones as $remision) {
            $remisionFoundId = explode(',', $remision->remisiones_id);

            for ($i = 0; $i < count($remisionFoundId); $i++) {
                if ((int)$remisionFoundId[$i] == $this->idRemision) {
                    $this->datesFound = explode(',', $remision->fechas);
                    $this->dias = explode(',', $remision->dias);
                }
            }
        }

        return view('livewire.ventas.devolver', [
            'ventas' => $this->ventas,
            'tiro' => $this->tiro,
            'remisiones' => $this->remisiones,
            'fechas' => $this->datesFound,
            'dias' => $this->dias,
            'calculoImporte' => $this->calculoImporte,
            'idRemision' => $this->idRemision,
        ]);
    }

    public function calcular() {
        if (count($this->cantDevolver) > 0) {
            for ($i = 0; $i < count($this->cantDevolver); $i++) {
                array_push($this->cantidades, $this->cantDevolver[$i][$this->dias[$i]]);
            }
            $this->implodeCant = implode(",", $this->cantidades);
        }
    }

    public function confirmar($cantDevolverTotales)
    {
        if (count($this->cantDevolver) > 0) {

            devolucionVenta::create([
                'idVenta' => $this->tiro->idTipo,
                'idRemision' => $this->idRemision,
                'idCliente' => $this->ventas->cliente_id,
                'idDomicilio' => $this->ventas->domicilio_id,
                'nombre' => $this->tiro->cliente,
                'devoluciones' => $this->implodeCant,
                'fechas' => implode(",", $this->datesFound),
                'dias' => implode(",",$this->dias),
                'entregados' => $this->tiro->entregar,
                'importe' => $cantDevolverTotales
            ]);

            Tiro::where('idTipo', $this->tiro->idTipo)->update([
                'importe' => $cantDevolverTotales
            ]);

            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Devolución realizada!' : ''
            ]);

            return Redirect::to('/devolucionInforme');
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Llena toda la información!' : ''
            ]);
        }
    }

    public function devolver()
    {
        if (count($this->cantDevolver) > 0) {
            $this->modalConfirmar = true;
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Llena toda la información!' : ''
            ]);
        }
    }

    public function mount($id)
    {
        $this->idRemision = $id;
        $this->tiro = Tiro::find($id);
    }
}

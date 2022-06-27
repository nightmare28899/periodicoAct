<?php

namespace App\Http\Livewire\Remisiones;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Domicilio;
use Illuminate\Support\Facades\DB;

class RmCliente extends Component
{
    public $fechaHoy, $clientes, $clienteData, $clienteSeleccionado, $data, $tipo, $datoInput, $keyWord;

    public function render()
    {
        Carbon::setLocale('es');
        $this->fechaHoy = Carbon::now();
        $this->fechaHoy = $this->fechaHoy->format('d/m/Y');
        /* dd($fechaHoy); */
        $this->keyWord = '%' . $this->keyWord . '%';
        $this->clientes = (object)Cliente::all();
        /* $data = DB::select('SELECT * FROM `cliente` WHERE id =', $this->clienteSeleccionado); */
        /* $this->data = DB::table('cliente')->select('id', 'nombre')->where('id', '=', $this->clienteSeleccionado)->get(); */

        $this->data = Cliente
            ::join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            /* ->where('cliente.id', 'like', '%' . $this->keyWord . '%') */
            ->where('cliente.id', '=', $this->clienteSeleccionado)
            ->select('cliente.*', 'domicilio.*', 'ruta.tiporuta')
            ->get();

        /* dd($this->data);  */
        /* ['id' => $this->clienteSeleccionado] */
        /* $this->clienteData = Cliente::all(); */

        /* if($this->clienteSeleccionado != null) {
            dd($this->data);
        } */

        return view('livewire.remisiones.cliente', [
            'fechaHoy' => $this->fechaHoy,
            'clientes' => $this->clientes,
            'data' => $this->data,
            'tipo' => $this->tipo,
            'datoInput' => $this->datoInput,
        ]);
    }
}

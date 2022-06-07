<?php

namespace App\Http\Livewire\Remisiones;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class RmCliente extends Component
{
    public $fechaHoy, $clientes, $clienteData, $clienteSeleccionado, $data;

    public function render()
    {
        Carbon::setLocale('es');
        $this->fechaHoy = Carbon::now();
        $this->fechaHoy = $this->fechaHoy->format('d/m/Y');
        /* dd($fechaHoy); */

        $this->clientes = (object)Cliente::all();
        /* $data = DB::select('SELECT * FROM `cliente` WHERE id =', $this->clienteSeleccionado); */
        $this->data = DB::table('cliente')->select('nombre')->where('id', '=', $this->clienteSeleccionado+1)->get();
        
        /* ['id' => $this->clienteSeleccionado] */
        /* $this->clienteData = Cliente::all(); */

        /* if($this->clienteSeleccionado != null) {
            dd($this->data);
        } */
        
        return view('livewire.remisiones.cliente', [
            'fechaHoy' => $this->fechaHoy,
            'clientes' => $this->clientes,
            'data' => $this->data,
        ]);
    }
}

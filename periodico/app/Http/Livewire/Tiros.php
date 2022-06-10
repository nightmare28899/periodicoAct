<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\Ejemplar;
use App\Models\Domicilio;
use App\Models\Cliente;
use Carbon\Carbon;
use PDF;

class Tiros extends Component
{
    public $Ejemplares, $keyWord, $cliente, $ejemplares, $domicilio, $referencia, $fecha, $dia, $created_at, $ejemplar_id, $date;
    public $Domicilios;
    public $updateMode = false;
    public $from;
    public $to;

    public function render()
    {
        $ejemplares = Ejemplar::where('id', '>=', 1);
        $resultado = Cliente::where('id', '>=', 1);
        /* $ejemplares = Ejemplar::all(); */
        $domicilios = Domicilio::all();
        $keyWord = '%' . $this->keyWord . '%';
        Carbon::setLocale('es');
        $dateF = new Carbon($this->from);
        $dateT = new Carbon($this->to);
        if ($this->from) {
            $this->dia = $dateF->translatedFormat('l');
            /* $ejemplares = Ejemplar::whereBetween('created_at', [$dateF->format('Y-m-d')." 00:00:00", $dateT->format('Y-m-d')." 23:59:59"])->get(); */
            /* $ejemplares = Ejemplar::whereDate('created_at', [$dateF->format('Y-m-d H:i:s')])->get($this->dia); */
            $resultado = Cliente
                ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
                ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
                ->where('nombre', 'like', '%' . $this->keyWord . '%')
                ->select("cliente.nombre", "ejemplares.*", "domicilio.*")
                ->get($this->dia);
            /* $ejemplares = Ejemplar::all('ejemplares')->get($this->dia);
            $domicilio = Domicilio::all('domicilio')->get($this->dia); */
            /* $this->store(); */
        }

        return view('livewire.tiros.tiro', [
            'resultado' => $resultado,
            'dia' => $this->dia,
        ], compact('domicilios', 'dateF'));
    }

    /* public function store() {
        Tiro::updateOrCreate(['id' => $this->id], [
            'cliente' => $this->cliente,
            'dia' => $this->dia,
            'ejemplares' => $this->ejemplares,
            'domicilio' => $this->domicilio,
            'referencia' => $this->referencia,
            'fecha' => $this->fecha
        ]);
    } */
    
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ejemplar;
use App\Models\Domicilio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class Tiro extends Component
{
    public $Ejemplares, $keyWord, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $created_at, $ejemplar_id, $date;
    public $Domicilios;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $ejemplares = Ejemplar::all();
        $domicilios = Domicilio::all();
        /* $fechas = DB::table('ejemplares')
        ->selectRaw('DATE(created_at) AS Fecha')
        ->get(); */
        /* dd(Ejemplar::where('cliente_id', 1)->get('lunes')); */
        /* $ejemplares = Ejemplar::whereMonth('created_at', '>=', now()->month(2))->get(); */
        return view('livewire.tiros.tiro', [
            'ejemplares' => Ejemplar::latest()
                ->orWhere('lunes', 'LIKE', $keyWord)
                ->orWhere('martes', 'LIKE', $keyWord)
                ->orWhere('miercoles', 'LIKE', $keyWord)
                ->orWhere('jueves', 'LIKE', $keyWord)
                ->orWhere('viernes', 'LIKE', $keyWord)
                ->orWhere('sabado', 'LIKE', $keyWord)
                ->orWhere('domingo', 'LIKE', $keyWord)
                ->paginate(15),
        ], compact('ejemplares','domicilios'));
    }

    public function date()
    {
        $date = $this->date;
        dd($date);
    }
}

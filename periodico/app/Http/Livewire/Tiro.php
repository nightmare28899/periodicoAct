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
    public $Ejemplares, $keyWord, $Monday, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $dia, $created_at, $ejemplar_id, $date;
    public $Domicilios;
    public $updateMode = false;
    public $from;
    public $to;

    public function render()
    {
        $ejemplares = Ejemplar::where('id', '>=', 1);
        /* $ejemplares = Ejemplar::all(); */
        $domicilios = Domicilio::all();
        $keyWord = '%' . $this->keyWord . '%';
        Carbon::setLocale('es');
        $dateF = new Carbon($this->from);
        $dateT = new Carbon($this->to);
        if($this->from) {
            $this->dia = $dateF->translatedFormat('l');
            /* $ejemplares = Ejemplar::whereBetween('created_at', [$dateF->format('Y-m-d')." 00:00:00", $dateT->format('Y-m-d')." 23:59:59"])->get(); */
            $ejemplares = Ejemplar::whereDate('created_at', [$dateF->format('Y-m-d H:i:s')])->get($this->dia);
            /* $ejemplares->whereDay('cliente_id', 1)->get($this->dia); */
            
            /* dd($dateF); */  
            /* $date = new Carbon('tomorrow'); */
            
            
            /* $ejemplares = Ejemplar::all('ejemplares')->get($this->dia);
            $domicilio = Domicilio::all('domicilio')->get($this->dia); */
        }
        
        return view('livewire.tiros.tiro', [
            'ejemplares' => $ejemplares,
            'dia' => $this->dia,
        ], compact('domicilios'));

        
    }

    public function date()
    {
        $date = $this->date;
        dd($date);
    }
}

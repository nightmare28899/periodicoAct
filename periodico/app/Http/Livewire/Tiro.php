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
        $dateF = new Carbon($this->from);
        $dateT = new Carbon($this->to);
        if($this->from) {
            /* $ejemplares = Ejemplar::whereBetween('created_at', [$dateF->format('Y-m-d')." 00:00:00", $dateT->format('Y-m-d')." 23:59:59"])->get(); */
            $ejemplares = Ejemplar::whereDate('created_at', [$dateF->format('Y-m-d')." 00:00:00"])->get();
            /* $ejemplares = Ejemplar::where('cliente_id', 1)->get('lunes'); */
            /* dd($dateF); */  
            $date = new Carbon('tomorrow');
            switch($dateF ->format('l')) {
                case("Monday"):
                    /* dd($ejemplares = Ejemplar::where('cliente_id', 2)->get('martes')); */
                    dd($ejemplares = DB::table('ejemplares')->get('martes'), $domicilio = DB::table('domicilio')->get());
                    /* dd('lunes'); */
                    break;
                case("Tuesday"):
                    dd($ejemplares = DB::table('ejemplares')->get('miercoles'));
                    /* dd('martes'); */
                    break;
                case("Wednesday"):
                    dd($ejemplares = DB::table('ejemplares')->get('jueves'));
                    /* dd('miercoles'); */
                    break;
                case("Thursday"):
                    dd($ejemplares = DB::table('ejemplares')->get('viernes'));
                    /* dd('jueves'); */
                    break;
                case("Friday"):
                    dd($ejemplares = DB::table('ejemplares')->get('sabado'));
                    /* dd('viernes'); */
                    break;
                case("Saturday"):
                    dd($ejemplares = DB::table('ejemplares')->get('lunes'));
                    /* dd('sabado'); */
                    break;
            }
            

        }
        
        return view('livewire.tiros.tiro', [
            'ejemplares' => $ejemplares
        ], compact('domicilios'));

        
    }

    public function date()
    {
        $date = $this->date;
        dd($date);
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\Ejemplar;
use App\Models\Domicilio;
use App\Models\Cliente;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;

class Tiros extends Component
{
    public $Ejemplares, $keyWord, $cliente, $ejemplares, $domicilio, $referencia, $fecha, $diaS, $created_at, $ejemplar_id, $date, $resultados = [], $modal, $dateF;
    public $Domicilios;
    public $updateMode = false;
    public $from;
    public $to, $isGenerateTiro = 0;

    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        /* $ejemplares = Ejemplar::where('id', '>=', 1); */
        /* $resultado = Cliente::where('id', '>=', 1); */
        /* $ejemplares = Ejemplar::all(); */
        $domicilios = Domicilio::all();
        $keyWord = '%' . $this->keyWord . '%';
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        /* $dateT = new Carbon($this->to); */
        if ($this->from) {
            $this->diaS = $this->dateF->translatedFormat('l');
            /* $ejemplares = Ejemplar::whereBetween('created_at', [$dateF->format('Y-m-d')." 00:00:00", $dateT->format('Y-m-d')." 23:59:59"])->get(); */
            /* $ejemplares = Ejemplar::whereDate('created_at', [$dateF->format('Y-m-d H:i:s')])->get($this->dia); */
            $this->resultados = Cliente
                ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
                ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
                ->where('nombre', 'like', '%' . $this->keyWord . '%')
                ->select("cliente.nombre", "ejemplares.*", "domicilio.*")
                ->get($this->diaS);
        }

        /* return view('livewire.tiros.tiro-modal'); */
        return view('livewire.tiros.tiro', [
            'resultado' => $this->resultados,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
        ], compact('domicilios'));
    }

    /* public function updatedFrom()
    {
        $this->resultados = Cliente
            ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->where('nombre', 'like', '%' . $this->keyWord . '%')
            ->select("cliente.nombre", "ejemplares.*", "domicilio.*")
            ->get($this->diaS);
    } */

    public function remision() 
    {
        /* return Redirect()->to('/tiro/vistaPrevia'); */
        return Redirect()->to('/tiro/vistaPrevia');
    }

    public function showModal()
    {
        $this->isGenerateTiro = true;

        $this->resultados = Cliente
            ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->where('nombre', 'like', '%' . $this->keyWord . '%')
            ->select("cliente.nombre", "ejemplares.*", "domicilio.*")
            ->get($this->diaS);

        $pdfContent = PDF::loadView('livewire.tiros.pdf', [
            'resultado' => $this->resultados,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
        ])
        ->setPaper('A5', 'landscape')
        ->output(); 

        /* return Redirect::to('download-pdf'); */

        return response()
            ->streamDownload(fn () => print($pdfContent),
            "tiros.pdf");
        
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }
}

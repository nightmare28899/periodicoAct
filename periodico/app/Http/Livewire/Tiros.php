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
    public $Domicilios, $status = 'error';
    public $updateMode = false;
    public $from;
    public $to, $isGenerateTiro = 0, $clienteSeleccionado = [];

    public $showingModal = false, $modalRemision = false;

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
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where('nombre', 'like', '%' . $this->keyWord . '%')
                ->select("cliente.id", "cliente.nombre", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            if ($this->clienteSeleccionado) {
                /* dd($this->clienteSeleccionado); */
            }
        }

        $maxWidth = [
            'sm' => 'sm:max-w-sm', 'md' => 'sm:max-w-md', 'lg' => 'sm:max-w-lg', 'xl' => 'sm:max-w-xl', '2xl' => 'sm:max-w-2xl', '3xl' => 'sm:max-w-3xl', '4xl' => 'sm:max-w-4xl', '5xl' => 'sm:max-w-5xl', '6xl' => 'sm:max-w-6xl', '7xl' => 'sm:max-w-7xl', 'full' => 'sm:max-w-full',
        ];

        /* dd($maxWidth['md']); */

        /* return view('livewire.tiros.tiro-modal'); */

        return view('livewire.tiros.tiro', [
            'resultado' => $this->resultados,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
            'maxWidth' => $maxWidth,
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
        /* dd($this->dateF);
        /* $this->isGenerateTiro = true; */
        /* return Redirect()->to('/tiro/vistaPrevia'); */
        return redirect()->to('livewire.tiros.tiro', ['dateF' => $this->dateF]);
    }

    public function descarga()
    {
        $this->isGenerateTiro = true;
        $this->modalRemision = false;
        $this->resultados = Cliente
            ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->where('nombre', 'like', '%' . $this->keyWord . '%')
            ->select("cliente.id", "cliente.nombre", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*")
            ->get($this->diaS);

        $pdfContent = PDF::loadView('livewire.tiros.pdf', [
            'resultado' => $this->resultados,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
        ])
            /* ->setPaper('A5', 'landscape') */
            ->output();

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Tiro generado exitosamente!' : ''
        ]);

        return response()
            ->streamDownload(
                fn () => print($pdfContent),
                "tiros.pdf"
            );
    }

    public function descargaRemision()
    {
        if ($this->clienteSeleccionado) {
            $this->status = 'created';
            // dd($this->clienteSeleccionado);
            $this->resultados = Cliente
                ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
                ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where('cliente.id', '=', $this->clienteSeleccionado)
                ->select("cliente.*", "ejemplares.lunes", "ejemplares.martes", "ejemplares.miércoles", "ejemplares.jueves", "ejemplares.viernes", "ejemplares.sábado", "ejemplares.domingo", "domicilio.*", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->get($this->diaS);

            // dd($this->resultados);

            $pdfContent = PDF::loadView('livewire.tiros.remisionPDF', [
                'resultado' => $this->resultados,
                'diaS' => $this->diaS,
                'dateF' => $this->dateF,
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->toast();

            return response()
                ->streamDownload(
                    fn () => print($pdfContent),
                    "remisiones.pdf"
                );
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes seleccionar un elemento primero!' : ''
            ]);
        }
    }

    public function generarRemision()
    {
        /* $cliente = Cliente::find(1)->user; */
        $this->modalRemision = true;
        $this->showingModal = false;
        /* $this->resultados = Cliente
            ::join("ejemplares", "ejemplares.cliente_id", "=", "cliente.id")
            ->join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->where('nombre', 'like', '%' . $this->keyWord . '%')
            ->select("cliente.nombre", "ejemplares.*", "domicilio.*")
            ->get($this->diaS);

        $pdfContent = PDF::loadView('livewire.tiros.generarRemision', [
            'resultado' => $this->resultados,
            'diaS' => $this->diaS,
            'dateF' => $this->dateF,
        ])
            ->setPaper('A5', 'landscape')
            ->output();

        return response()
            ->streamDownload(
                fn () => print($pdfContent),
                "tiros.pdf"
            ); */

        /* return redirect()->to('/tiros/remision', ['dateF' => $this->dateF]); */
    }

    public function showModal()
    {
        if ($this->from) {
            $this->showingModal = true;
        } else {
            $this->status = 'error';
            return $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes escoger una fecha primero!' : ''
            ]);
        }
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }
    public function hideModalRemision()
    {
        $this->modalRemision = false;
        $this->showingModal = true;
    }
    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisión generada exitosamente!' : ''
        ]);
    }
}

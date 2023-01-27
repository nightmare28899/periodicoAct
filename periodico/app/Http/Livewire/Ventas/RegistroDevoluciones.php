<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;
use App\Models\devolucionVenta;
use App\Models\Ruta;
use App\Models\Domicilio;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class RegistroDevoluciones extends Component
{
    use WithPagination;

    public $desde, $hasta, $status = 'created', $to, $from, $domicilio, $ruta, $folioDev, $devfound, $all = [];

    public function verPDF($id, $idRemision, $idDomicilio)
    {
        if ($this->desde && $this->hasta && $this->folioDev) {

            $this->domicilio = Domicilio::find($idDomicilio);
            $this->ruta = Ruta::find($this->domicilio->ruta_id);
            $this->devfound = devolucionVenta::find($id);
            /* array_push($this->dates, explode(',',$this->devfound->fechas)); */
            $this->all = devolucionVenta::where('id', $id)->get();
            $pdf = Pdf::loadView('livewire.ventas.devoluciones-pdf', [
                'devolucionVenta' => devolucionVenta::where('id', $id)->first(),
                'desde' => $this->from = Carbon::parse($this->desde)->format('d/m/Y'),
                'hasta' => $this->to = Carbon::parse($this->hasta)->format('d/m/Y'),
                'ruta' => $this->ruta,
                'folio' => $this->folioDev,
                'idRemision' => $idRemision,
                'fechas' => $dates = explode(',', $this->devfound->fechas),
                'devoluciones' => $devoluciones = explode(',', $this->devfound->devoluciones),
                'importe' => $this->devfound->importe,
                'cantidad' => count($this->all),
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            Storage::disk('public')->put('verDevolucion.pdf', $pdf);

            return Redirect::to('/PDFDevolucionView');
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Coloca los periodos primero!' : ''
            ]);
        }
    }

    public function render()
    {
        $devolucionVenta = devolucionVenta::paginate(10);


        return view('livewire.ventas.registro-devoluciones', [
            'devolucionVenta' => $devolucionVenta
        ]);
    }
}

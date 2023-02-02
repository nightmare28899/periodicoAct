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

    public $desde, $hasta, $status = 'created', $to, $from, $domicilio = [], $ruta = [], $folioDev, $devfound, $all = [], $seleccionados = [], $idRemisions = [], $rutas = [], $array1 = [], $finalData, $date1, $date2, $rutaSeleccionada;

    public function seleccionado()
    {
        if ($this->seleccionados && $this->desde && $this->hasta && $this->folioDev) {
            for ($i = 0; $i < count($this->seleccionados); $i++) {

                $this->devfound = devolucionVenta::whereIn('id', $this->seleccionados)->get();

                for ($i = 0; $i < count($this->devfound); $i++) {
                    array_push($this->domicilio,  Domicilio::find($this->devfound[$i]->idDomicilio));
                    array_push($this->ruta, Ruta::find($this->domicilio[$i]->ruta_id));
                }
            }

            for ($i = 0; $i < count($this->devfound); $i++) {
                array_push($this->array1, explode(',', $this->devfound[$i]->devoluciones));

                $this->finalData = array_map(function (...$arrays) {
                    return array_sum($arrays);
                }, ...$this->array1);
            }

            $pdf = Pdf::loadView('livewire.ventas.devoluciones-pdf', [
                'desde' => $this->from = Carbon::parse($this->desde)->format('d/m/Y'),
                'hasta' => $this->to = Carbon::parse($this->hasta)->format('d/m/Y'),
                'folio' => $this->folioDev,
                'devolucionVenta' => $this->devfound,
                'ruta' => $this->ruta,
                'fechas' => $dates = explode(',', $this->devfound[0]->fechas),
                'finalData' => $this->finalData,
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            Storage::disk('public')->put('verDevolucion.pdf', $pdf);

            return Redirect::to('/PDFDevolucionView');
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Coloca los periodos, folio y selecciona los clientes!' : ''
            ]);
        }
    }

    public function render()
    {
        $this->rutas = Ruta::all();
        if ($this->desde && $this->hasta && $this->rutaSeleccionada) {

            $this->date1 = Carbon::parse($this->desde)->format('d/m/Y');
            $this->date2 = Carbon::parse($this->hasta)->format('d/m/Y');

            $devolucionVenta = devolucionVenta::where(function ($query) {
                $query->where('fechaInicio', '=', $this->date1)
                    ->where('fechaFin', '=', $this->date2)
                    ->where('ruta', '=', $this->rutaSeleccionada);
            })->paginate(10);
        }

        return view('livewire.ventas.registro-devoluciones', [
            'devolucionVenta' => $devolucionVenta ?? [],
            'rutas' => $this->rutas,
        ]);
    }
}

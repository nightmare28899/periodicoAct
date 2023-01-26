<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Remisionid;
use App\Models\Tiro;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use App\Models\Ruta;

class RemisionesRangoPorFecha extends Component
{
    use WithPagination;

    public $remisionesId, $entreFechas, $remisionFound = [], $de, $hasta, $status = 'created', $ruta = "seleccion", $rutas;

    public function render()
    {
        $this->rutas = Ruta::all();

        if ($this->de && $this->hasta) {
            $remisionesData = Remisionid::where(function ($query) {
                $query->where('fechaInicio', $this->de)
                    ->where('fechaFin', $this->hasta);
            })
                ->paginate(10);
        } else {
            $remisionesData = Remisionid::paginate(10);
        }

        if ($this->ruta != 'seleccion') {
            $remisionesData = Remisionid::where(function ($query) {
                $query->where('ruta', $this->ruta);
            })
                ->paginate(10);
        }

        return view('livewire.remisiones-rango-por-fecha', [
            'rutas' => $this->rutas,
        ], compact('remisionesData'));
    }

    public function verPDF($id)
    {
        $remision = Remisionid::find($id);

        $this->remisionesId = $remision->remisiones_id;

        $idFound = explode(',', $this->remisionesId);
        for ($i = 0; $i < count($idFound); $i++) {
            array_push($this->remisionFound, Tiro::join("cliente", "cliente.id", "=", "tiro.cliente_id")
                ->join("ventas", "ventas.idVenta", "=", "tiro.idTipo")
                ->join("domicilio", "domicilio.id", "=", "tiro.domicilio_id")
                ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
                ->join("tarifa", "tarifa.id", "=", "domicilio.tarifa_id")
                ->where('tiro.id', (int)$idFound[$i])
                ->select("tiro.*", "ventas.desde", "ventas.hasta", "ventas.total", "ventas.lunes", "ventas.martes", "ventas.miércoles", "ventas.jueves", "ventas.viernes", "ventas.sábado", "ventas.domingo", "cliente.nombre", "cliente.razon_social", "cliente.rfc_input", "cliente.pais", "domicilio.cliente_id", "domicilio.calle", "domicilio.noint", "domicilio.noext", "domicilio.colonia", "domicilio.cp", "domicilio.localidad", "domicilio.municipio", "domicilio.ruta_id", "domicilio.tarifa_id", "domicilio.referencia", "ruta.nombreruta", "ruta.tiporuta", "tarifa.tipo", "tarifa.ordinario", "tarifa.dominical")
                ->first());
        }

        $entreFechas = explode(',', $remision->fechas);
        $diasEntreFechas = explode(',', $remision->dias);

        $pdf = PDF::loadView('livewire.remisiones-rango-pdf', [
            'ventas' => $this->remisionFound,
            'entreFechas' => $entreFechas,
            'diasEntreFechas' => $diasEntreFechas
        ])
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('remisionRangos.pdf', $pdf);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisiones cargadas!' : ''
        ]);

        return Redirect::to('/remisionesRangoPdfview');
    }
}

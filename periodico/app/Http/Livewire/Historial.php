<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tiro;
use App\Models\ventas;
use App\Models\Cliente;
use App\Models\Domicilio;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use App\Models\Ruta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class Historial extends Component
{
    public $tiros, $id_cliente, $status, $ventas, $tiro, $cliente, $date, $domicilio, $ruta, $modalEditar = 0, $devuelto = 0, $faltante = 0, $entregar;
    public function render()
    {
        $this->date = Carbon::now()->format('d-m-Y');
        $this->tiros = Tiro::all();
        return view('livewire.remisiones.historial');
    }

    public function pagar($id_cliente, $idTipo)
    {
        $this->id_cliente = $id_cliente;
        if (substr($idTipo, 0, 6) == 'suscri') {
            $this->cliente = Cliente
            ::join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'cliente.id')
            ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta_id')
            ->where('cliente.id', '=',  $this->id_cliente)
            ->get();
        } else if (substr($idTipo, 0, 5) == 'venta') {
            $this->cliente = Cliente
            ::join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
            ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
            ->where('cliente.id', '=',  $this->id_cliente)
            ->get();
        }
        $this->tiro = Tiro::Where('cliente_id', $this->id_cliente)->update(['status' => 'Pagado']);

        $this->ventas = ventas::Where('cliente_id', $this->id_cliente)->get();
        $this->cliente = Cliente::Where('id', $this->id_cliente)->get();
        $this->domicilio = Domicilio::Where('cliente_id', $this->id_cliente)->get();
        $this->ruta = Ruta::Where('id', $this->domicilio[0]['ruta_id'])->get();

        $pdf = Pdf::loadView('livewire.pagado', [
            'total' => $this->ventas[0]['total'],
            'cliente' => $this->cliente[0],
            'desde' => $this->ventas[0]['desde'],
            'hasta' => $this->ventas[0]['hasta'],
            'lunes' => $this->ventas[0]['lunes'],
            'martes' => $this->ventas[0]['martes'],
            'miercoles' => $this->ventas[0]['miercoles'],
            'jueves' => $this->ventas[0]['jueves'],
            'viernes' => $this->ventas[0]['viernes'],
            'sabado' => $this->ventas[0]['sabado'],
            'domingo' => $this->ventas[0]['domingo'],
            'fecha' => $this->date,
        ])
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('pagado.pdf', $pdf);

        $this->status = 'created';

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Se realizo el pago!' : ''
        ]);


        Return Redirect::to('/PDFPago');
    }

    public function editarRemision($id)
    {
        $this->modalEditar = true;
        $this->modalHistorial = false;
        $this->modalRemision = false;
        $this->showingModal = false;
        $tiros = Tiro::find($id);
        $this->tiros_id = $id;
        $this->devuelto = $tiros->devuelto;
    }

    public function cerrarEditar()
    {
        $this->modalEditar = false;
    }

    public function pausarRemision($id)
    {
        $tiro = Tiro
            ::join('suscripciones', 'suscripciones.cliente_id', '=', 'tiro.cliente_id')
            ->where('suscripciones.cliente_id', '=', $id)
            ->select('suscripciones.*')
            ->get();

        if ($tiro[0]->estado == 'Pausado') {
            Tiro::where('cliente_id', $id)->update([
                'estado' => 'Activo'
            ]);
            Suscripcion::where('cliente_id', $id)->update([
                'estado' => 'Activo'
            ]);
        } else {
            Tiro::where('cliente_id', $id)->update([
                'estado' => 'Pausado'
            ]);
            Suscripcion::where('cliente_id', $id)->update([
                'estado' => 'Pausado'
            ]);
        }
        $this->modalHistorial = false;
    }

    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Remisión generada exitosamente!' : ''
        ]);
    }

    public function updateDevueltos()
    {
        $tiros = Tiro::find($this->tiros_id);
        if ($this->devuelto) {
            if ($tiros->entregar >= $this->devuelto) {
                $tiros->update([
                    'devuelto' => $tiros->devuelto + $this->devuelto,
                    'entregar' => $tiros->entregar - $this->devuelto,
                    'venta' => $tiros->venta - $this->devuelto,
                    'importe' => $tiros->importe = ($tiros->entregar - $this->devuelto) * $tiros->precio,
                ]);
                $this->status = 'updated';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'updated') ? '¡Se generó exitosamente la devolución!' : ''
                ]);
                $this->entregar = $tiros->entregar;
                $this->modalEditar = false;
                $this->modalHistorial = false;
                $this->showingModal = true;
                $this->devuelto = 0;
            } else if (($tiros->entregar + $this->devuelto) <= $tiros->devuelto) {
                $tiros->update([
                    'devuelto' => $tiros->devuelto - $this->devuelto,
                    'entregar' => $tiros->entregar + $this->devuelto,
                    'venta' => $tiros->venta + $this->devuelto,
                    'importe' => $tiros->importe = ($tiros->entregar + $this->devuelto) * $tiros->precio,
                ]);
                $this->status = 'adjust';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'adjust') ? '¡Ajuste realizado!' : ''
                ]);
                $this->entregar = $tiros->entregar;
                $this->modalEditar = false;
                $this->modalHistorial = false;
                $this->showingModal = true;
                $this->devuelto = 0;
            } else {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡No puedes devolver más cantidad de la que hay!' : ''
                ]);
            }
        }
    }
}

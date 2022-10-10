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
use Illuminate\Support\Facades\DB;

class Historial extends Component
{
    public $tiros, $id_cliente, $status, $ventas = [], $tiro, $cliente, $date, $domicilio, $ruta, $modalEditar = 0, $devuelto = 0, $faltante = 0, $entregar, $suscri = [], $clienteSeleccionado, $clientesBuscados, $modalDomicilio = 0, $rutas, $calle, $noint, $noext, $colonia, $cp, $localidad, $referencia, $ciudad, $fechaRemision, $state = false, $datos = [], $type = [], $id_domicilio;

    public function mount($editar)
    {
        if ($editar != 'normal') {
            $this->state = true;
        }
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->clientesBuscados) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->clientesBuscados) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectContact($pos)
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            $this->domicilioSeleccionado = [];
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('id', '=', $this->query . '%')
            ->orWhere('nombre', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->rutas = Ruta::pluck('nombreruta', 'id');
        $this->date = Carbon::now()->format('d-m-Y');

        if ($this->state != true) {
            if ($this->clienteSeleccionado && $this->fechaRemision) {
                $this->tiros = Tiro::where(function ($query) {
                    $query->where('cliente_id', $this->clienteSeleccionado['id'])
                        ->where('fecha', $this->fechaRemision);
                })->get();
            } else if ($this->clienteSeleccionado) {
                $this->tiros = Tiro::where('cliente_id', $this->clienteSeleccionado['id'])->get();
            } else if ($this->fechaRemision) {
                $this->tiros = Tiro::where('fecha', $this->fechaRemision)->get();
            } else {
                $this->tiros = Tiro::all();
            }
        } else {
            if ($this->clienteSeleccionado && $this->fechaRemision) {
                $this->datos = Tiro::where(function ($query) {
                    $query->where('cliente_id', $this->clienteSeleccionado['id'])
                        ->where('fecha', $this->fechaRemision);
                })->get();
                for ($i = 0; $i < count($this->datos); $i++) {
                    if (substr($this->datos[$i]->idTipo, 0, 6) == 'suscri') {
                        $this->type = $this->datos[$i]->idTipo;

                        $this->tiros = Tiro::where(function ($query) {
                            $query->where('cliente_id', $this->clienteSeleccionado['id'])
                                ->where('fecha', $this->fechaRemision)
                                ->where('idTipo', $this->type);
                        })->get();
                    }
                }
            } else if ($this->clienteSeleccionado) {
                $this->datos = Tiro::all();
                for ($i = 0; $i < count($this->datos); $i++) {
                    if (substr($this->datos[$i]->idTipo, 0, 6) == 'suscri') {
                        array_push($this->type, $this->datos[$i]->idTipo);

                        $this->tiros = Tiro::where(function ($query) {
                            $query->whereIn('idTipo', $this->type)
                                ->where('cliente_id', $this->clienteSeleccionado['id']);
                        })->get();
                    }
                }
            } else if ($this->fechaRemision) {
                $this->datos = Tiro::all();
                for ($i = 0; $i < count($this->datos); $i++) {
                    if (substr($this->datos[$i]->idTipo, 0, 6) == 'suscri') {
                        array_push($this->type, $this->datos[$i]->idTipo);

                        $this->tiros = Tiro::where(function ($query) {
                            $query->whereIn('idTipo', $this->type)
                                ->where('fecha', $this->fechaRemision);
                        })->get();
                    }
                }
            } else {
                $this->datos = Tiro::all();
                for ($i = 0; $i < count($this->datos); $i++) {
                    if (substr($this->datos[$i]->idTipo, 0, 6) == 'suscri') {
                        array_push($this->type, $this->datos[$i]->idTipo);
                        $this->tiros = Tiro::where(function ($query) {
                            $query->whereIn('idTipo', $this->type);
                        })->get();
                    }
                }
            }
        }
        return view('livewire.remisiones.historial');
    }

    public function pagar($id_cliente, $idTipo)
    {
        $this->id_cliente = $id_cliente;
        if (substr($idTipo, 0, 6) == 'suscri') {
            $this->cliente = Cliente
                ::join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'cliente.id')
                ->where('cliente.id', '=', $this->id_cliente)
                ->get();
            $this->suscripcion = Suscripcion::Where('cliente_id', $this->id_cliente)->get();
            $this->domicilioSubs = DomicilioSubs::Where('cliente_id', $this->id_cliente)->get();
            $this->Ruta = Ruta::Where('id', $this->domicilioSubs[0]->ruta)->get();
            $pdf = Pdf::loadView('livewire.pagado', [
                'ruta' => $this->Ruta[0],
                'suscripcion' => $this->suscripcion[0],
                'total' => $this->suscripcion[0]['total'],
                'cliente' => $this->cliente[0],
                'desde' => $this->suscripcion[0]['desde'],
                'hasta' => $this->suscripcion[0]['hasta'],
                'fecha' => $this->date,
                'tipo' => 'suscri',
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->tiro = Tiro
                ::where('cliente_id', $this->id_cliente)
                ->where('idTipo', '=', $idTipo)
                ->update(['status' => 'Pagado']);
        } else if (substr($idTipo, 0, 5) == 'venta') {
            $this->cliente = Cliente
                ::join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                ->where('cliente.id', '=', $this->id_cliente)
                ->get();

            $this->ventas = ventas::Where('cliente_id', $this->id_cliente)->get();
            $this->domicilio = Domicilio::Where('cliente_id', $this->id_cliente)->first();
            $this->Ruta = Ruta::Where('id', $this->domicilio->ruta_id)->get();
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
                'tipo' => 'venta',
                'ruta' => $this->Ruta[0],
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            $this->tiro = Tiro
                ::where('cliente_id', $this->id_cliente)
                ->where('idTipo', '=', $idTipo)
                ->update(['status' => 'Pagado']);
        }

        Storage::disk('public')->put('pagado.pdf', $pdf);

        $this->status = 'created';

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Se realizo el pago!' : ''
        ]);

        return Redirect::to('/PDFPago');
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

    public function generarPDF($id, $idTipo)
    {
        if (substr($idTipo, 0, 6) == 'suscri') {
            $this->cliente = Cliente
                ::join('domicilio_subs', 'domicilio_subs.cliente_id', '=', 'cliente.id')
                ->where('cliente.id', '=', $id)
                ->get();
            $this->suscri = Suscripcion::where('cliente_id', '=', $id)->get();
            $this->domicilioSubs = DomicilioSubs::Where('cliente_id', $id)->get();
            $this->Ruta = Ruta::Where('id', $this->domicilioSubs[0]->ruta)->get();
            $pdf = Pdf::loadView('livewire.pdfRemisionVer', [
                'ruta' => $this->Ruta[0],
                'suscripcion' => $this->suscri[0],
                'total' => $this->suscri[0]['total'],
                'cliente' => $this->cliente[0],
                'desde' => $this->suscri[0]['desde'],
                'hasta' => $this->suscri[0]['hasta'],
                'fecha' => $this->date,
                'tipo' => 'suscri',
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            Storage::disk('public')->put('verRemision.pdf', $pdf);

            return Redirect::to('/PDFRemisionesP');

        } else if (substr($idTipo, 0, 5) == 'venta') {
            $this->cliente = Cliente
                ::join('domicilio', 'domicilio.cliente_id', '=', 'cliente.id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->join('tarifa', 'tarifa.id', '=', 'domicilio.tarifa_id')
                ->where('cliente.id', '=', $id)
                ->get();

            $this->ventas = ventas::Where('cliente_id', $id)->get();
            $this->domicilio = Domicilio::Where('cliente_id', $id)->first();
            $this->Ruta = Ruta::Where('id', $this->domicilio->ruta_id)->get();

            $pdf = Pdf::loadView('livewire.pdfRemisionVer', [
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
                'tipo' => 'venta',
                'ruta' => $this->Ruta[0],
            ])
                ->setPaper('A5', 'landscape')
                ->output();

            Storage::disk('public')->put('verRemision.pdf', $pdf);

            return Redirect::to('/PDFRemisionesP');
        }
    }

    public function editarDomicilio($id)
    {
        $this->modalDomicilio = true;
        $this->domicilio = domicilioSubs::where('id', $id)->get();
        $this->id_domicilio = $id;
        $this->calle = $this->domicilio[0]->calle;
        $this->noint = $this->domicilio[0]->noint;
        $this->noext = $this->domicilio[0]->noext;
        $this->colonia = $this->domicilio[0]->colonia;
        $this->cp = $this->domicilio[0]->cp;
        $this->localidad = $this->domicilio[0]->localidad;
        $this->ciudad = $this->domicilio[0]->ciudad;
        $this->referencia = $this->domicilio[0]->referencia;
        $this->ruta = $this->domicilio[0]->ruta;

    }

    public function actualizarDomicilioSubs()
    {

        $this->domicilio = domicilioSubs::where('id', $this->id_domicilio)->first();
        $this->domicilio->update([
            'calle' => $this->calle,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'noint' => $this->noint,
            'noext' => $this->noext,
            'referencia' => $this->referencia,
            'ciudad' => $this->ciudad,
            'ruta' => $this->ruta,
        ]);
        $this->modalDomicilio = false;

        $this->status = 'created';

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio actualizado correctamente!' : ''
        ]);
    }
}

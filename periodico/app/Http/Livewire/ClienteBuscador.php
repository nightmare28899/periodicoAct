<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Domicilio;
use App\Models\ventas;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ClienteBuscador extends Component
{
    public $query, $clientesBuscados, $highlightIndex, $dataClient = [], $clienteSeleccionado;
    public $lunesVentas, $martesVentas, $miercolesVentas, $juevesVentas, $viernesVentas, $sabadoVentas, $domingoVentas;
    public $editEnabled = false, $status = 'created', $modalV = 0;
    public $desde, $hasta, $date, $converHasta, $total = 0;

    public function limpiarVentaModal()
    {
        $this->editEnabled = false;
        $this->clienteSeleccionado = null;
        $this->desde = null;
        $this->hasta = null;
        $this->lunesVentas = null;
        $this->martesVentas = null;
        $this->miercolesVentas = null;
        $this->juevesVentas = null;
        $this->viernesVentas = null;
        $this->sabadoVentas = null;
        $this->domingoVentas = null;
        $this->modalV = false;
    }

    public function returnClienteView()
    {
        $this->limpiarVentaModal();
        return redirect()->route('cliente');
    }

    public function actualizarVenta()
    {
        /* $this->validate([
            'lunesVentas' => 'required',
            'martesVentas' => 'required',
            'miercolesVentas' => 'required',
            'juevesVentas' => 'required',
            'viernesVentas' => 'required',
            'sabadoVentas' => 'required',
            'domingoVentas' => 'required',
        ]); */

        $this->ventas = ventas::where('cliente_id', $this->clienteSeleccionado)->first();
        $this->ventas->update([
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'lunes' => $this->lunesVentas,
            'martes' => $this->martesVentas,
            'miércoles' => $this->miercolesVentas,
            'jueves' => $this->juevesVentas,
            'viernes' => $this->viernesVentas,
            'sábado' => $this->sabadoVentas,
            'domingo' => $this->domingoVentas,
        ]);
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'updated') ? '¡Venta actualizada exitosamente!' : ''
        ]);
        $this->status = 'created';
        $this->limpiarVentaModal();
        $this->modalV = false;

        $this->returnClienteView();
    }

    public function editarVenta()
    {
        if ($this->clienteSeleccionado) {
            $this->ventas = ventas::where('cliente_id', $this->clienteSeleccionado['id'])->get();
            if (count($this->ventas) > 0) {
                $this->editEnabled = true;
                $this->desde = $this->ventas[0]['desde'];
                $this->hasta = $this->ventas[0]['hasta'];
                $this->lunesVentas = $this->ventas[0]['lunes'];
                $this->martesVentas = $this->ventas[0]['martes'];
                $this->miercolesVentas = $this->ventas[0]['miércoles'];
                $this->juevesVentas = $this->ventas[0]['jueves'];
                $this->viernesVentas = $this->ventas[0]['viernes'];
                $this->sabadoVentas = $this->ventas[0]['sábado'];
                $this->domingoVentas = $this->ventas[0]['domingo'];
                $this->modalV = true;
                $this->status = 'updated';
            } else {
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡El cliente no tiene ningúna venta registrada!' : ''
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Selecciona un cliente!' : ''
            ]);
        }
    }

    public function crearVenta()
    {
        $this->idSuscrip = Str::random(6); {
            $this->lunesVentas ? $this->lunesVentas : 0;
        } {
            $this->martesVentas ? $this->martesVentas : 0;
        } {
            $this->miercolesVentas ? $this->miercolesVentas : 0;
        } {
            $this->juevesVentas ? $this->juevesVentas : 0;
        } {
            $this->viernesVentas ? $this->viernesVentas : 0;
        } {
            $this->sabadoVentas ? $this->sabadoVentas : 0;
        } {
            $this->domingoVentas ? $this->domingoVentas : 0;
        }
        if ($this->clienteSeleccionado) {
            if ($this->lunesVentas || $this->martesVentas || $this->miercolesVentas || $this->juevesVentas || $this->viernesVentas || $this->sabadoVentas || $this->domingoVentas) {
                if ($this->hasta) {
                    $lunesTotal = (int)$this->lunesVentas * $this->clienteSeleccionado['ordinario'];
                    $martesTotal = (int)$this->martesVentas * $this->clienteSeleccionado['ordinario'];
                    $miercolesTotal = (int)$this->miercolesVentas * $this->clienteSeleccionado['ordinario'];
                    $juevesTotal = (int)$this->juevesVentas * $this->clienteSeleccionado['ordinario'];
                    $viernesTotal = (int)$this->viernesVentas * $this->clienteSeleccionado['ordinario'];
                    $sabadoTotal = (int)$this->sabadoVentas * $this->clienteSeleccionado['ordinario'];
                    $domingoTotal = (int)$this->domingoVentas * $this->clienteSeleccionado['dominical'];

                    $this->total = $lunesTotal + $martesTotal + $miercolesTotal + $juevesTotal + $viernesTotal + $sabadoTotal + $domingoTotal;

                    ventas::Create([
                        'idVenta' => 'venta' . $this->idSuscrip,
                        'tipo' => 'venta',
                        'cliente_id' => $this->cliente_id = Cliente::where('id', $this->clienteSeleccionado['id'])->first()->id,
                        'domicilio_id' => $this->domicilio_id = Domicilio::where('cliente_id', $this->clienteSeleccionado['cliente_id'])->first()->id,
                        'desde' => $this->desde,
                        'hasta' => $this->hasta,
                        'lunes' => $this->lunesVentas,
                        'martes' => $this->martesVentas,
                        'miércoles' => $this->miercolesVentas,
                        'jueves' => $this->juevesVentas,
                        'viernes' => $this->viernesVentas,
                        'sábado' => $this->sabadoVentas,
                        'domingo' => $this->domingoVentas,
                        'total' => $this->total
                    ]);

                    $pdfContent = PDF::loadView('livewire.remisionVentaGenerada', [
                        'total' => $this->total,
                        'cliente' => $this->clienteSeleccionado,
                        'desde' => $this->desde,
                        'hasta' => $this->hasta,
                        'lunes' => $this->lunesVentas,
                        'martes' => $this->martesVentas,
                        'miercoles' => $this->miercolesVentas,
                        'jueves' => $this->juevesVentas,
                        'viernes' => $this->viernesVentas,
                        'sabado' => $this->sabadoVentas,
                        'domingo' => $this->domingoVentas,
                        'fecha' => $this->date,
                    ])
                        ->setPaper('A5', 'landscape')
                        ->output();

                    $this->status = 'created';
                    $this->modalV = false;

                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Venta generada exitosamente!' : ''
                    ]);

                    $this->returnClienteView();

                    return response()
                        ->streamDownload(
                            fn () => print($pdfContent),
                            "tiros.pdf"
                        );

                } else {
                    $this->dispatchBrowserEvent('alert', [
                        'message' => '¡Falta ingresar la fecha hasta!'
                    ]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡Debes escoger por lo menos un día!' : ''
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Selecciona un cliente!' : ''
            ]);
        }
    }

    public function mount()
    {
        /* $this->modalV = $status; */
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->highlightIndex = 0;
    }

    public function selectContact($pos)
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;

            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::join('domicilio', 'cliente.id', '=', 'domicilio.cliente_id')
            ->join('ruta', 'domicilio.ruta_id', '=', 'ruta.id')
            ->join('tarifa', 'domicilio.tarifa_id', '=', 'tarifa.id')
            ->where('razon_social', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->select('cliente.*', 'domicilio.cp', 'domicilio.calle', 'domicilio.localidad', 'domicilio.noint', 'domicilio.noext', 'domicilio.colonia', 'domicilio.municipio', 'domicilio.referencia', 'domicilio.ruta_id', 'domicilio.tarifa_id', 'domicilio.cliente_id', 'ruta.nombreruta', 'tarifa.ordinario', 'tarifa.dominical', 'tarifa.tipo')
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->date = new Carbon();
        Carbon::setLocale('es');
        $this->converHasta = new Carbon($this->desde);
        $this->desde = $this->converHasta->format('Y-m-d');

        return view('livewire.cliente-buscador', [
            'clientes' => $this->clientesBuscados,
            'desde' => $this->desde,
            'hasta' => $this->hasta
        ]);
    }
}

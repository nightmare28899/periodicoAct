<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use App\Models\Domicilio;
use App\Models\Ejemplar;
use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use Carbon\Carbon;
use App\Models\ventas;

class Clientes extends Component
{
    use WithPagination;

    public $Clientes, $keyWord, $clasificacion, $rfc = 'Física', $rfc_input, $nombre, $estado, $pais, $email, $email_cobranza, $telefono, $regimen_fiscal, $cliente_id, $Domicilios, $calle, $noint = null, $localidad, $municipio, $ruta_id, $tarifa_id, $ciudad, $referencia, $domicilio_id, $Ejemplares, $lunes, $martes, $miércoles, $jueves, $viernes, $sábado, $domingo,  $ejemplar_id, $isModalOpen = 0, $clienteModalOpen = 0, $ejemplarModalOpen = 0, $detallesModalOpen = 0, $updateMode = false, $status = 'created', $suscripciones = 0, $date, $clienteSeleccionado, $dataClient = [], $cp, $colonia, $noext, $ruta;

    public $oferta = false, $tipoSubscripcion = 'Normal', $subscripcionEs = 'Apertura', $precio = 'Normal', $contrato = 'Suscripción', $cantEjem = 0, $diasSuscripcionSeleccionada = '', $observacion, $descuento = 0, $totalDesc = 0, $tipoSuscripcionSeleccionada, $allow = true, $tarifaSeleccionada, $formaPagoSeleccionada, $periodoSuscripcionSeleccionada = '', $modificarFecha = false, $from, $to, $total = 0, $iva = 0, $modalDomSubs = 0, $modalFormDom = 0, $domiciliosSubs, $datoSeleccionado, $domicilioSeleccionado = [], $parametro = [], $domicilioSubsId, $arregloDatos = [], $modalV = 0, $desde, $hasta, $converHasta, $domicilioId = [], $editEnabled = false, $ventas, $cantDom = 0, $cantArray = [], $inputCantidad, $posicion, $posicionDomSubs;

    public $lunesVentas, $martesVentas, $miercolesVentas, $juevesVentas, $viernesVentas, $sabadoVentas, $domingoVentas;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        $this->date = new Carbon();
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        $this->converHasta = new Carbon($this->desde);
        $this->dateFiltro = new Carbon($this->to);
        $this->desde = $this->converHasta->format('Y-m-d');
        $this->from = $this->dateF->format('Y-m-d');
        $keyWord = '%' . $this->keyWord . '%';
        $data = [
            'Genérico' => 'GENÉRICO',
            'Gobierno' => 'GOBIERNO',
            'T/O' => 'T/O',
            'Libre' => 'LIBRE',
            'Municipio' => 'MUNICIPIO',
            'S-A' => 'S-A',
            'T-E' => 'T-E',
            'Sanborn' => 'SANBORN',
        ];

        $formaPago = [
            'Efectivo' => 'Efectivo',
            'Cheque Nominativo' => 'Cheque Nominativo',
            'Tarjetas de Crédito' => 'Tarjetas de Crédito',
            'Por definir' => 'Por definir',
            'Transferencia Electrónica' => 'Transferencia Electrónica',
            'Monedero Electrónico' => 'Monedero Electrónico',
            'Dinero electrónico' => 'Dinero electrónico',
            'Vales de despensa' => 'Vales de despensa',
            'Dación en pago' => 'Dación en pago',
            'Pago por subrogación' => 'Pago por subrogación',
            'Pago por consignación' => 'Pago por consignación',
            'Condonación' => 'Condonación',
            'Compensación' => 'Compensación',
            'Novación' => 'Novación',
            'Confusión' => 'Confusión',
            'Remisión de deuda' => 'Remisión de deuda',
            'Prescripción o caducidad' => 'Prescripción o caducidad',
            'A satisfacción del acreedor' => 'A satisfacción del acreedor',
            'Tarjeta de débito' => 'Tarjeta de débito',
            'Tarjeta de servicios' => 'Tarjeta de servicios',
        ];

        $days = $this->periodoSuscripcionSeleccionada === 'Mensual'
            ? 1
            : ($this->periodoSuscripcionSeleccionada === 'Trimestral'
                ? 3
                : ($this->periodoSuscripcionSeleccionada === 'Semestral'
                    ? 6
                    : ($this->periodoSuscripcionSeleccionada === 'Anual'
                        ? 12
                        : 0)));

        $this->to = $this->dateF->addMonth($days)->format('Y-m-d');

        $days > 0 ? $this->modificarFecha = false : $this->modificarFecha = true;

        $rutas = Ruta::pluck('nombreruta', 'id');
        $tarifas = Tarifa::pluck('tipo', 'id');

        $this->dataClient = Cliente
            ::join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->where('cliente.id', '=', $this->clienteSeleccionado)
            ->select('cliente.*', 'domicilio.*', 'ruta.nombreruta')
            ->get();

        switch ($this->diasSuscripcionSeleccionada) {
            case 'l_v':
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = false;
                $this->domingo = false;
                $this->allow = false;
                break;
            case 'l_d':
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = true;
                $this->domingo = true;
                $this->allow = false;
                break;

            default:
                $this->lunes = false;
                $this->martes = false;
                $this->miércoles = false;
                $this->jueves = false;
                $this->viernes = false;
                $this->sábado = false;
                $this->domingo = false;
                $this->allow = true;
                break;
        }

        if ($this->tarifaSeleccionada) {
            $costo = 0;
            if ($this->cantEjem >= 1) {
                $costo = $this->tarifaSeleccionada === 'Base' ? 330 : ($this->tarifaSeleccionada === 'Ejecutiva' ? 300 : 0);
                $this->total = $this->cantEjem * $costo;
                $this->totalDesc = $this->cantEjem * $costo;
            } else {
                $this->total = 0;
                $this->totalDesc = 0;
            }
            if ($this->descuento) { {
                    $this->descuento <= $this->total ? $this->totalDesc = ($this->total - $this->descuento) : $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡No puedes aplicar un descuento mayora la cantidad!' : ''
                    ]);
                }
            }
        }

        $this->domiciliosSubs = DomicilioSubs
            ::join("cliente", "cliente.id", "=", "domicilio_subs.cliente_id")
            ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
            ->select('domicilio_subs.*', 'ruta.nombreruta')
            ->get();

        if ($this->clienteSeleccionado && $this->subscripcionEs == 'Renovación') {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();

            $this->domicilioId = $this->suscripciones[0]->domicilio_id;
            $this->cantEjem = $this->suscripciones[0]->cantEjemplares;
            $this->tipoSubscripcion = $this->suscripciones[0]->suscripcion;
            /* $this->subscripcionEs = $this->suscripciones[0]->esUnaSuscripcion; */
            $this->tarifaSeleccionada = $this->suscripciones[0]->tarifa;
            $this->tipoSuscripcionSeleccionada = $this->suscripciones[0]->tipoSuscripcion;
            /* $this->periodoSuscripcionSeleccionada = $this->suscripciones[0]->periodo; */
            $this->diasSuscripcionSeleccionada = $this->suscripciones[0]->dias;
            /* $this->from = $this->suscripciones[0]->fechaInicio;
            $this->to = $this->suscripciones[0]->fechaFin; */
            $this->contrato = $this->suscripciones[0]->contrato;
            $this->lunes = $this->suscripciones[0]->lunes;
            $this->martes = $this->suscripciones[0]->martes;
            $this->miércoles = $this->suscripciones[0]->miércoles;
            $this->jueves = $this->suscripciones[0]->jueves;
            $this->viernes = $this->suscripciones[0]->viernes;
            $this->sábado = $this->suscripciones[0]->sábado;
            $this->domingo = $this->suscripciones[0]->domingo;
            $this->descuento = $this->suscripciones[0]->descuento;
            $this->observacion = $this->suscripciones[0]->observaciones;
            $this->total = $this->suscripciones[0]->importe;
            $this->totalDesc = $this->suscripciones[0]->total;
            $this->formaPagoSeleccionada = $this->suscripciones[0]->formaPago;
            /* $this->domicilioS = domicilioSubs
                ::join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('cliente_id', $this->clienteSeleccionado)
                ->select('domicilio_subs.*', 'ruta.nombreruta')
                ->get();
            $this->domicilioSeleccionado = $this->domicilioS;

            $this->inputCantidad = $this->domicilioS[0]->ejemplares;
            $this->cantDom = $this->inputCantidad; */
        }

        if ($this->clienteSeleccionado && $this->contrato == 'Cortesía') {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();
            $this->total = 0;
            $this->totalDesc = 0;
        }

        return view('livewire.clientes.view', [
            'clientes' => Cliente::latest()
                ->orWhere('clasificacion', 'LIKE', $keyWord)
                ->orWhere('rfc', 'LIKE', $keyWord)
                ->orWhere('rfc_input', 'LIKE', $keyWord)
                ->orWhere('nombre', 'LIKE', $keyWord)
                ->orWhere('estado', 'LIKE', $keyWord)
                ->orWhere('pais', 'LIKE', $keyWord)
                ->orWhere('email', 'LIKE', $keyWord)
                ->orWhere('email_cobranza', 'LIKE', $keyWord)
                ->orWhere('telefono', 'LIKE', $keyWord)
                ->orWhere('regimen_fiscal', 'LIKE', $keyWord)
                ->paginate(15),
            'rfc' => $this->rfc,
        ], compact('data', 'rutas', 'tarifas', 'formaPago'));
    }
    public function create()
    {
        $this->resetInput();
        $this->openModalPopover();
        /* $this->status = 'created'; */
    }
    public function primerModal()
    {
        $this->openModalPopover();
    }
    public function estadoRFC()
    {
        $this->rfc_input = '';
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
        $this->clienteModalOpen = false;
        $this->ejemplarModalOpen = false;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
        $this->clienteModalOpen = false;
        $this->ejemplarModalOpen = false;
        $this->resetInput();
    }
    public function openClientModal()
    {
        $this->validate([
            'clasificacion' => 'required',
            'rfc' => 'required',
            'nombre' => 'required',
            'estado' => 'required',
            'pais' => 'required',
            'regimen_fiscal' => 'required',
            'telefono' => 'required|max:10',
            'rfc_input' => 'required',
        ]);

        $this->isModalOpen = false;
        $this->ejemplarModalOpen = false;
        $this->clienteModalOpen = true;
    }
    public function closeClientModal()
    {
        $this->clienteModalOpen = false;
    }
    public function openEjemplarModal()
    {
        $this->isModalOpen = false;
        $this->clienteModalOpen = false;
        $this->ejemplarModalOpen = true;
    }
    public function closeEjemplarModal()
    {
        $this->ejemplarModalOpen = false;
    }
    public function openModalAnterior()
    {
        $this->isModalOpen = false;
        $this->clienteModalOpen = true;
        $this->ejemplarModalOpen = false;
    }
    public function modalSuscripciones()
    {
        $this->suscripciones = true;
    }
    public function modalCrearDomSubs()
    {
        {
            $this->clienteSeleccionado ? $this->modalDomSubs = true : $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Seleccione un cliente!' : ''
            ]);
        }
    }
    public function modalCrearDom()
    {
        $this->modalFormDom = true;
    }
    public function modalVentas()
    {
        $this->modalV = true;
    }
    public function detalles($id)
    {
        $Cliente = Cliente::find($id);
        $this->cliente_id = $id;
        $this->clasificacion = $Cliente->clasificacion;
        $this->rfc = $Cliente->rfc;
        $this->rfc_input = $Cliente->rfc_input;
        $this->nombre = $Cliente->nombre;
        $this->estado = $Cliente->estado;
        $this->pais = $Cliente->pais;
        $this->email = $Cliente->email;
        $this->email_cobranza = $Cliente->email_cobranza;
        $this->telefono = $Cliente->telefono;
        $this->regimen_fiscal = $Cliente->regimen_fiscal;

        $Domicilio = Domicilio::find($id);
        $this->domicilio_id = $Domicilio->id;
        $this->calle = $Domicilio->calle;
        $this->noint = $Domicilio->noint;
        $this->noext = $Domicilio->noext;
        $this->colonia = $Domicilio->colonia;
        $this->cp = $Domicilio->cp;
        $this->localidad = $Domicilio->localidad;
        $this->municipio = $Domicilio->municipio;
        $this->referencia = $Domicilio->referencia;
        $this->ruta_id = $Domicilio->ruta_id;
        $this->tarifa_id = $Domicilio->tarifa_id;

        $this->detallesModalOpen = true;
    }
    public function closeDetallesModal()
    {
        $this->detallesModalOpen = false;
    }
    private function resetInput()
    {
        $this->clasificacion = '';
        /* $this->rfc = ''; */
        $this->rfc_input = '';
        $this->nombre = '';
        $this->estado = '';
        $this->pais = '';
        $this->email = '';
        $this->email_cobranza = '';
        $this->telefono = '';
        $this->regimen_fiscal = '';

        $this->calle = '';
        $this->noint = '';
        $this->noext = '';
        $this->colonia = '';
        $this->cp = '';
        $this->localidad = '';
        $this->municipio = '';
        $this->referencia = '';
        $this->ruta_id = '';
        $this->tarifa_id = '';
    }
    public function store()
    {
        {
            $this->noint ? $this->noint : null;
        }

        $this->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'pais' => 'required',
            'regimen_fiscal' => 'required',
            'telefono' => 'required|max:10',
            'email' => 'required|string|unique:users',
            'email_cobranza' => 'required|string',

            'calle' => 'required',
            'noext' => 'required',
            'colonia' => 'required',
            'cp' => 'required',
            'localidad' => 'required',
            'municipio' => 'required',
            'referencia' => 'required',
            'ruta_id' => 'required',
            'tarifa_id' => 'required',
            'clasificacion' => 'required',
            'rfc' => 'required',
            'rfc_input' => 'required',
        ]);

        Cliente::Create([
            'clasificacion' => $this->clasificacion,
            'rfc' => $this->rfc,
            'rfc_input' => $this->rfc_input,
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'pais' => $this->pais,
            'email' => $this->email,
            'email_cobranza' => $this->email_cobranza,
            'telefono' => $this->telefono,
            'regimen_fiscal' => $this->regimen_fiscal
        ]);

        Domicilio::Create([
            'cliente_id' => $this->cliente_id = Cliente::latest('id')->first()->id,
            'calle' => $this->calle,
            'noint' => $this?->noint,
            'noext' => $this->noext,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'ruta_id' => $this->ruta_id,
            'tarifa_id' => $this->tarifa_id,
            'referencia' => $this->referencia,
        ]);

        /* $this->resetInput(); */
        $this->emit('closeModal');
        $this->updateMode = false;
        $this->closeModalPopover();
        $this->clienteModalOpen = false;
        $this->toast();
    }
    public function edit($id)
    {
        $Cliente = Cliente::find($id);
        $this->cliente_id = $id;
        $this->clasificacion = $Cliente->clasificacion;
        $this->rfc = $Cliente->rfc;
        $this->rfc_input = $Cliente->rfc_input;
        $this->nombre = $Cliente->nombre;
        $this->estado = $Cliente->estado;
        $this->pais = $Cliente->pais;
        $this->email = $Cliente->email;
        $this->email_cobranza = $Cliente->email_cobranza;
        $this->telefono = $Cliente->telefono;
        $this->regimen_fiscal = $Cliente->regimen_fiscal;

        $Domicilio = Domicilio::find($id);
        $this->domicilio_id = $id;
        $this->calle = $Domicilio->calle;
        $this->noint = $Domicilio->noint;
        $this->noext = $Domicilio->noext;
        $this->colonia = $Domicilio->colonia;
        $this->cp = $Domicilio->cp;
        $this->localidad = $Domicilio->localidad;
        $this->municipio = $Domicilio->municipio;
        $this->referencia = $Domicilio->referencia;
        $this->ruta_id = $Domicilio->ruta_id;
        $this->tarifa_id = $Domicilio->tarifa_id;

        $this->openModalPopover();

        $this->status = 'updated';
    }
    public function update()
    {
        $this->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'pais' => 'required',
            'regimen_fiscal' => 'required',
            'telefono' => 'required|max:10',

            'calle' => 'required',
            'noext' => 'required',
            'colonia' => 'required',
            'cp' => 'required',
            'localidad' => 'required',
            'municipio' => 'required',
            'referencia' => 'required',
            'ruta_id' => 'required',
            'tarifa_id' => 'required',
            'clasificacion' => 'required',
            'rfc' => 'required',
            'rfc_input' => 'required',
        ]);

        $cliente = Cliente::find($this->cliente_id);
        $cliente->update([
            'clasificacion' => $this->clasificacion,
            'rfc' => $this->rfc,
            'rfc_input' => $this->rfc_input,
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'pais' => $this->pais,
            'email' => $this->email,
            'email_cobranza' => $this->email_cobranza,
            'telefono' => $this->telefono,
            'regimen_fiscal' => $this->regimen_fiscal,
        ]);

        $domicilio = Domicilio::find($this->domicilio_id);
        $domicilio->update([
            'calle' => $this->calle,
            'noint' => $this->noint,
            'noext' => $this->noext,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'ruta_id' => $this->ruta_id,
            'tarifa_id' => $this->tarifa_id,
            'referencia' => $this->referencia,
        ]);

        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->closeModalPopover();
    }
    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Cliente creado correctamente!' : '¡Cliente actualizado correctamente!'
        ]);
    }
    public function delete($id)
    {

        $domD = Domicilio::where('cliente_id', $id)->first();
        $this->status = 'delete';

        if ($id != null) {
            Cliente::find($id)->delete();
            $domD->delete();
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'delete') ? '¡Cliente eliminado correctamente!' : ''
            ]);
        } else {
            dd('No existe');
        }
    }
    /* Aqui comienzan las suscripciones */
    public function createSubs()
    {
        {
            $this->noint ? $this->noint : $this->noint = null;
        }

        $this->status = 'created';

        $this->validate([
            'calle' => 'required',
            'noext' => 'required',
            'colonia' => 'required',
            'cp' => 'required',
            'localidad' => 'required',
            'ciudad' => 'required',
            'referencia' => 'required',
            'ruta' => 'required',
        ]);

        domicilioSubs::Create([
            'cliente_id' => $this->cliente_id = Cliente::where('id', $this->clienteSeleccionado)->first()->id,
            'calle' => $this->calle,
            'noint' => $this?->noint,
            'noext' => $this->noext,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'ciudad' => $this->ciudad,
            'referencia' => $this->referencia,
            'ruta' => $this->ruta,
            'ejemplares' => 0,
        ]);

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio creado exitosamente!' : ''
        ]);

        $this->resetInputSubs();

        $this->modalFormDom = false;
        $this->modalDomSubs = false;
    }
    public function crearVenta()
    {
        {
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
                    ventas::Create([
                        'cliente_id' => $this->cliente_id = Cliente::where('id', $this->clienteSeleccionado)->first()->id,
                        'domicilio_id' => $this->domicilio_id = Domicilio::where('cliente_id', $this->cliente_id)->first()->id,
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

                    $this->limpiarVentaModal();

                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Venta generada exitosamente!' : ''
                    ]);
                    $this->modalV = false;
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
    public function actualizarVenta()
    {
        $this->validate([
            'lunesVentas' => 'required',
            'martesVentas' => 'required',
            'miercolesVentas' => 'required',
            'juevesVentas' => 'required',
            'viernesVentas' => 'required',
            'sabadoVentas' => 'required',
            'domingoVentas' => 'required',
        ]);
        $this->status = 'updated';
        $this->ventas = ventas::where('id', $this->clienteSeleccionado)->first();
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
        $this->limpiarVentaModal();
        $this->modalV = false;
    }
    public function editarVenta()
    {
        if ($this->clienteSeleccionado) {
            $this->ventas = ventas::where('cliente_id', $this->clienteSeleccionado)->get();
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
    public function limpiarClienteSeleccionado()
    {
        $this->editEnabled = false;
        /* $this->clienteSeleccionado = null; */
        $this->desde = null;
        $this->hasta = null;
        $this->lunesVentas = null;
        $this->martesVentas = null;
        $this->miercolesVentas = null;
        $this->juevesVentas = null;
        $this->viernesVentas = null;
        $this->sabadoVentas = null;
        $this->domingoVentas = null;
    }
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
    public function updatedCantDom($field, $value)
    {
        $this->inputCantidad = $field;
        $this->posicion = $value;

        if ($field) {
            if ($this->cantEjem) {
                if ($field <= $this->cantEjem) {
                    $DomicilioSubs = DomicilioSubs::find($this->posicion);
                    $DomicilioSubs->update([
                        'ejemplares' => $this->inputCantidad,
                    ]);
                } else {
                    $this->dispatchBrowserEvent('alert', [
                        'message' => '¡La cantidad de ejemplares no puede ser mayor a la cantidad de ejemplares existentes!'
                    ]);
                }
            } else {
                $this->dispatchBrowserEvent('alert', [
                    'message' => '¡Debes ingresar la cantidad de ejemplares primero!'
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Debes colocar la cantidad en los domicilios!' : ''
            ]);
        }
    }
    public function suscripciones()
    {
        if ($this->clienteSeleccionado) {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();
            /* dd($this->suscripciones); */
            if ($this->suscripciones->isEmpty() && $this->subscripcionEs == 'Apertura') {
                if ($this->domicilioSeleccionado) {
                    if ($this->cantEjem == '0') {
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'created') ? '¡No puedes poner cero!' : ''
                        ]);
                    }

                    foreach ($this->domicilioSeleccionado as $key => $value) {
                        if ($value['id'] == $this->domicilioSeleccionado[$key]['id']) {
                            array_push($this->domicilioId, $value['id']);
                        }
                    }

                    $this->validate([
                        'formaPagoSeleccionada' => 'required',
                        'tarifaSeleccionada' => 'required',
                        'cantEjem' => 'required',
                        'tipoSuscripcionSeleccionada' => 'required',
                        'periodoSuscripcionSeleccionada' => 'required',
                        'diasSuscripcionSeleccionada' => 'required',
                    ]);

                    if ($this->inputCantidad) {
                        if ($this->inputCantidad <= $this->cantEjem) {
                            Suscripcion::Create([
                                'cliente_id' => $this->clienteSeleccionado,
                                'suscripcion' => $this->tipoSubscripcion,
                                'esUnaSuscripcion' => $this->subscripcionEs,
                                'tarifa' => $this->tarifaSeleccionada,
                                'cantEjemplares' => $this->cantEjem,
                                'precio' => $this->precio,
                                'contrato' => $this->contrato,
                                'tipoSuscripcion' => $this->tipoSuscripcionSeleccionada,
                                'periodo' => $this->periodoSuscripcionSeleccionada,
                                'fechaInicio' => $this->from,
                                'fechaFin' => $this->to,
                                'dias' => $this->diasSuscripcionSeleccionada,
                                'estado' => 'Activo',
                                'lunes' => $this->lunes,
                                'martes' => $this->martes,
                                'miércoles' => $this->miércoles,
                                'jueves' => $this->jueves,
                                'viernes' => $this->viernes,
                                'sábado' => $this->sábado,
                                'domingo' => $this->domingo,
                                'descuento' => $this->descuento,
                                'observaciones' => $this->observacion,
                                'importe' => $this->total,
                                'total' => $this->totalDesc,
                                'formaPago' => $this->formaPagoSeleccionada,
                                'domicilio_id' =>  json_encode($this->domicilioId),
                            ]);

                            $this->status = 'created';

                            /* $this->status = 'updated'; */

                            $this->dispatchBrowserEvent('alert', [
                                'message' => ($this->status == 'created') ? '¡Suscripción generada correctamente!' : ''
                            ]);

                            $this->suscripciones = false;

                            $this->borrar();
                        } else {
                            $this->dispatchBrowserEvent('alert', [
                                'message' => ($this->status == 'created') ? '¡No puedes poner una cantidad mayor a los ejemplares!' : ''
                            ]);
                        }
                    } else {
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'created') ? '¡Debes colocar la cantidad en los domicilios!' : ''
                        ]);
                    }
                } else {
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Seleccione un domicilio!' : ''
                    ]);
                }
            } else {

                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡El cliente ya tiene una suscripción!' : ''
                ]);
            }

            if ($this->subscripcionEs == 'Renovación') {
                $suscrip = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();

                $suscrip = Suscripcion::find($suscrip[0]->id);
                /* dd($suscrip); */
                $suscrip->update([
                    'periodo' => $this->periodoSuscripcionSeleccionada,
                    'fechaInicio' => $this->from,
                    'fechaFin' => $this->to,
                ]);

                $this->status = 'created';

                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡Renovación generada!' : ''
                ]);

                $this->suscripciones = false;

                $this->borrar();
            }
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Seleccione un cliente!' : ''
            ]);
        }
    }
    public function eliminarSubs($id)
    {
        $this->status = 'delete';
        domicilioSubs::find($id)->delete();
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'delete') ? 'Domicilio eliminado correctamente!' : ''
        ]);

        $this->modalDomSubs = false;
    }
    public function borrar()
    {
        $this->clienteSeleccionado = '';
        $this->tipoSubscripcion = 'Normal';
        $this->subscripcionEs = 'Apertura';
        $this->precio = 'Normal';
        $this->contrato = 'Suscripción';
        $this->oferta = false;
        $this->tarifaSeleccionada = '';
        $this->cantEjem = 0;
        $this->tipoSuscripcionSeleccionada = '';
        $this->periodoSuscripcionSeleccionada = 'esco';
        $this->diasSuscripcionSeleccionada = 'esc_man';
        $this->descuento = 0;
        $this->observacion = '';
        $this->total = 0;
        $this->descuento = 0;
        $this->totalDesc = 0;
        $this->formaPagoSeleccionada = '';
        $this->domicilioSeleccionado = [];
    }
    public function datoSeleccionado($id)
    {
        if ($this->domicilioSeleccionado) {
            foreach ($this->domicilioSeleccionado as $key => $value) {
                if ($value['id'] == $id) {
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡No puedes escoger el mismo domicilio!' : ''
                    ]);
                    break;
                }
            }
            if ($value['id'] != $id) {
                array_push($this->domicilioSeleccionado, DomicilioSubs
                    ::join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                    ->select('domicilio_subs.*', 'ruta.nombreruta')
                    ->where('domicilio_subs.id', '=', $id)
                    ->first()
                    ->toArray());

                $this->modalDomSubs = false;
            }
        } else {
            array_push($this->domicilioSeleccionado, DomicilioSubs
                ::join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->select('domicilio_subs.*', 'ruta.nombreruta')
                ->where('domicilio_subs.id', '=', $id)
                ->first()
                ->toArray());

            $this->modalDomSubs = false;
        }
    }
    public function eliminarDatoSeleccionado($id)
    {
        foreach ($this->domicilioSeleccionado as $key => $value) {
            if ($value['id'] == $id) {
                unset($this->domicilioSeleccionado[$key]);
                domicilioSubs::where('id', $id)->update([
                    'ejemplares' => 0,
                ]);
            }
        }
    }
    public function editarDomicilioSubs($id)
    {
        $this->status = 'updated';

        $DomicilioSubs = DomicilioSubs::find($id);
        $this->domicilioSubsId = $DomicilioSubs->id;
        $this->calle = $DomicilioSubs->calle;
        $this->noint = $DomicilioSubs->noint;
        $this->noext = $DomicilioSubs->noext;
        $this->colonia = $DomicilioSubs->colonia;
        $this->cp = $DomicilioSubs->cp;
        $this->localidad = $DomicilioSubs->localidad;
        $this->ciudad = $DomicilioSubs->ciudad;
        $this->referencia = $DomicilioSubs->referencia;
        $this->ruta = $DomicilioSubs->ruta;

        $this->modalDomSubs = true;
        $this->modalCrearDom();
    }
    public function actualizarDomicilioSubs()
    {
        $DomicilioSubs = DomicilioSubs::find($this->domicilioSubsId);
        $DomicilioSubs->update([
            'calle' => $this->calle,
            'noint' => $this->noint,
            'noext' => $this->noext,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'ciudad' => $this->ciudad,
            'referencia' => $this->referencia,
            'ruta_id' => $this->ruta
        ]);

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio actualizado exitosamente!' : ''
        ]);

        $this->modalFormDom = false;
    }
    public function resetInputSubs()
    {
        $this->calle = '';
        $this->noint = '';
        $this->noext = '';
        $this->colonia = '';
        $this->cp = '';
        $this->localidad = '';
        $this->ciudad = '';
        $this->referencia = '';
        $this->ruta = '';
    }
}

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
use Carbon\Carbon;

class Clientes extends Component
{
    use WithPagination;

    public $Clientes, $keyWord, $clasificacion, $rfc = 'Física', $rfc_input, $nombre, $estado, $pais, $email, $email_cobranza, $telefono, $regimen_fiscal, $cliente_id, $Domicilios, $calle, $noint = null, $localidad, $municipio, $ruta_id, $tarifa_id, $ciudad, $referencia, $domicilio_id, $Ejemplares, $lunes, $martes, $miércoles, $jueves, $viernes, $sábado, $domingo,  $ejemplar_id, $isModalOpen = 0, $clienteModalOpen = 0, $ejemplarModalOpen = 0, $detallesModalOpen = 0, $updateMode = false, $status = 'created', $suscripciones = 0, $date, $clienteSeleccionado, $dataClient = [], $cp, $colonia, $noext, $ruta;

    public $oferta = false, $tipoSubscripcion = 'Normal', $subscripcionEs = 'Apertura', $precio = 'Normal', $contrato = 'Suscripción', $cantEjem = 0, $diasSuscripcionSeleccionada = '', $observacion, $descuento = 0, $totalDesc = 0, $tipoSuscripcionSeleccionada, $allow = true, $tarifaSeleccionada, $formaPagoSeleccionada, $periodoSuscripcionSeleccionada, $modificarFecha = false, $from, $to, $total = 0, $iva = 0, $modalDomSubs = 0, $modalFormDom = 0, $domiciliosSubs, $datoSeleccionado, $domicilioSeleccionado = [], $parametro = [], $domicilioSubsId, $arregloDatos = [];

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        $this->date = new Carbon();
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        $this->dateFiltro = new Carbon($this->to);
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

        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
            $this->to = $this->dateF->addMonth(1)->format('Y-m-d');
            $this->modificarFecha = false;
        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
            $this->to = $this->dateF->addMonths(3)->format('Y-m-d');
            $this->modificarFecha = false;
        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
            $this->to = $this->dateF->addMonths(6)->format('Y-m-d');
            $this->modificarFecha = false;
        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
            $this->to = $this->dateF->addYear(1)->format('Y-m-d');
            $this->modificarFecha = false;
        } else if ($this->periodoSuscripcionSeleccionada == 'esco') {
            $this->modificarFecha = true;
        }

        $rutas = Ruta::pluck('nombreruta', 'id');
        $tarifas = Tarifa::pluck('id', 'id');

        $this->dataClient = Cliente
            ::join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->where('cliente.id', '=', $this->clienteSeleccionado)
            ->select('cliente.*', 'domicilio.*', 'ruta.nombreruta')
            ->get();

        /* dd($this->dataClient); */

        if ($this->diasSuscripcionSeleccionada != null) {
            if ($this->diasSuscripcionSeleccionada == 'l_v') {
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = false;
                $this->domingo = false;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'l_d') {
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = true;
                $this->domingo = true;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'esc_man') {
                $this->lunes = false;
                $this->martes = false;
                $this->miércoles = false;
                $this->jueves = false;
                $this->viernes = false;
                $this->sábado = false;
                $this->domingo = false;
                $this->allow = true;
            }
        } else {
            $this->lunes = false;
            $this->martes = false;
            $this->miércoles = false;
            $this->jueves = false;
            $this->viernes = false;
            $this->sábado = false;
            $this->domingo = false;
        }

        if ($this->tarifaSeleccionada == 'Base') {
            if ($this->cantEjem == 0) {
                $this->total = $this->total = 0;
                $this->totalDesc = $this->totalDesc = 0;
            } else if ($this->cantEjem >= 1) {
                $this->total = $this->cantEjem * 330;
                $this->totalDesc = $this->cantEjem * 330;
                if ($this->descuento) {
                    $this->totalDesc = ($this->total - $this->descuento);
                }
            }
        } else if ($this->tarifaSeleccionada == 'Ejecutiva') {
            if ($this->cantEjem == 0) {
                $this->total = $this->total = 0;
                $this->totalDesc = $this->totalDesc = 0;
            } else if ($this->cantEjem >= 1) {
                $this->total = $this->cantEjem * 300;
                $this->totalDesc = $this->cantEjem * 300;
            }
        }

        /* if($this->datoSeleccionado) {
            dd($this->datoSeleccionado);
        } */

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
        $this->status = 'created';
    }
    public function primerModal()
    {
        $this->openModalPopover();
        $this->status = 'created';
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
        $this->isModalOpen = false;
        /* $this->resetInput(); */
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
        if ($this->clienteSeleccionado) {
            $this->modalDomSubs = true;
            $this->domiciliosSubs = DomicilioSubs::All();
            /* dd($this->domiciliosSubs); */
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Seleccione un cliente!' : ''
            ]);
        }
    }
    public function modalCrearDom()
    {
        $this->modalFormDom = true;
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

        $Ejemplar = Ejemplar::find($id);
        $this->ejemplar_id = $Ejemplar->id;
        $this->lunes = $Ejemplar->lunes;
        $this->martes = $Ejemplar->martes;
        $this->miércoles = $Ejemplar->miércoles;
        $this->jueves = $Ejemplar->jueves;
        $this->viernes = $Ejemplar->viernes;
        $this->sábado = $Ejemplar->sábado;
        $this->domingo = $Ejemplar->domingo;

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

        $this->lunes = '';
        $this->martes = '';
        $this->miércoles = '';
        $this->jueves = '';
        $this->viernes = '';
        $this->sábado = '';
        $this->domingo = '';
    }

    public function store()
    {
        if ($this->noint) {
            $this->noint;
        } else {
            $this->noint = null;
        }

        if ($this->lunes) {
            $this->lunes;
        } else {
            $this->lunes = 0;
        }

        if ($this->martes) {
            $this->martes;
        } else {
            $this->martes = 0;
        }

        if ($this->miércoles) {
            $this->miércoles;
        } else {
            $this->miércoles = 0;
        }

        if ($this->jueves) {
            $this->jueves;
        } else {
            $this->jueves = 0;
        }

        if ($this->viernes) {
            $this->viernes;
        } else {
            $this->viernes = 0;
        }

        if ($this->sábado) {
            $this->sábado;
        } else {
            $this->sábado = 0;
        }

        if ($this->domingo) {
            $this->domingo;
        } else {
            $this->domingo = 0;
        }

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
            'cliente_id' => $this->cliente_id = Cliente::where('nombre', $this->nombre)->first()->id,
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

        Ejemplar::Create([
            'cliente_id' => $this->cliente_id = Cliente::where('nombre', $this->nombre)->first()->id,
            'lunes' => $this->lunes,
            'martes' => $this->martes,
            'miércoles' => $this->miércoles,
            'jueves' => $this->jueves,
            'viernes' => $this->viernes,
            'sábado' => $this->sábado,
            'domingo' => $this->domingo,
        ]);

        /* $this->resetInput(); */
        $this->emit('closeModal');
        $this->updateMode = false;
        $this->closeModalPopover();
        $this->clienteModalOpen = false;
        /* session()->flash('message', $this->cliente_id | $this->domicilio_id | $this->ejemplar_id ? '¡Cliente Actualizado!.' : '¡Cliente Creado!.'); */
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

        $Ejemplar = Ejemplar::find($id);
        $this->ejemplar_id = $Ejemplar->id;
        $this->lunes = $Ejemplar->lunes;
        $this->martes = $Ejemplar->martes;
        $this->miércoles = $Ejemplar->miércoles;
        $this->jueves = $Ejemplar->jueves;
        $this->viernes = $Ejemplar->viernes;
        $this->sábado = $Ejemplar->sábado;
        $this->domingo = $Ejemplar->domingo;

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

            'lunes' => 'required',
            'martes' => 'required',
            'miércoles' => 'required',
            'jueves' => 'required',
            'viernes' => 'required',
            'sábado' => 'required',
            'domingo' => 'required',
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

        $ejemplar = Ejemplar::find($this->ejemplar_id);
        $ejemplar->update([
            'lunes' => $this->lunes,
            'martes' => $this->martes,
            'miércoles' => $this->miércoles,
            'jueves' => $this->jueves,
            'viernes' => $this->viernes,
            'sábado' => $this->sábado,
            'domingo' => $this->domingo,
        ]);

        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->closeModalPopover();
    }

    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Cliente Creado Correctamente!' : '¡Cliente Actualizado Correctamente!'
        ]);
    }

    public function delete($id)
    {
        $this->status = 'delete';
        Cliente::find($id)->delete();
        /* session()->flash('message', 'Cliente Eliminado!.'); */
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'delete') ? '¡Cliente Eliminado Correctamente!' : ''
        ]);
    }

    /* Aqui comienzan las suscripciones */

    public function createSubs()
    {
        if ($this->noint != null) {
            $this->noint;
        } else {
            $this->noint = null;
        }

        $this->status = 'created';

        $this->validate([
            'calle' => 'required',
            'noext' => 'required',
            'colonia' => 'required',
            'cp' => 'required',
            'localidad' => 'required',
            'ciudad' => 'required',
            'referencia' => 'required'
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
            'ruta' => $this->ruta
        ]);

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio creado exitosamente!' : ''
        ]);

        $this->modalFormDom = false;

        $this->resetInputSubs();
    }

    public function suscripciones()
    {
        if ($this->clienteSeleccionado) {

            if ($this->cantEjem == '0') {
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡No puedes poner cero!' : ''
                ]);
            }
            /* dd($this->date, $this->tipoSubscripcion, $this->subscripcionEs, $this->dataClient, $this->precio, $this->contrato, "este",$this->cantEjem, $this->diasSuscripcionSeleccionada, $this->lunes, $this->martes, $this->miércoles, $this->jueves, $this->viernes, $this->sábado, $this->domingo, $this->observacion, $this->tipoSuscripcionSeleccionada, $this->tarifaSeleccionada, $this->formaPagoSeleccionada, $this->dateF, $this->dateFiltro,$this->descuento); */
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Seleccione un cliente!' : ''
            ]);
        }
    }

    public function datoSeleccionado($id)
    {
        if ($this->domicilioSeleccionado != null) {
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
                    ::where('id', '=', $id)
                    ->first()
                    ->toArray());

                $this->modalDomSubs = false;
            }
        } else {
            array_push($this->domicilioSeleccionado, DomicilioSubs
                ::where('id', '=', $id)
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

        $this->modalCrearDom();
        $this->modalDomSubs = true;
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
            'ruta' => $this->ruta
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

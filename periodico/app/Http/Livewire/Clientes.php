<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use App\Models\Domicilio;
use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use Carbon\Carbon;
use App\Models\ventas;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class Clientes extends Component
{
    use WithPagination;

    public $Clientes, $keyWord, $clasificacion, $rfc = 'Física', $rfc_input, $nombre, $estado, $pais, $email, $email_cobranza, $telefono, $regimen_fiscal, $cliente_id, $Domicilios, $calle, $noint, $localidad, $municipio, $ruta_id, $tarifa_id, $ciudad, $referencia, $domicilio_id, $Ejemplares, $lunes, $martes, $miércoles, $jueves, $viernes, $sábado, $domingo, $ejemplar_id, $isModalOpen = 0, $clienteModalOpen = 0, $ejemplarModalOpen = 0, $detallesModalOpen = 0, $updateMode = false, $status = 'created', $suscripciones = [], $date, $clienteSeleccionado, $dataClient = [], $cp, $colonia, $noext, $ruta, $razon_social, $d, $modalErrors = 0;

    public $oferta = false, $tipoSubscripcion = 'Normal', $subscripcionEs = 'Apertura', $precio = 'Normal', $contrato = 'Suscripción', $cantEjem = 0, $diasSuscripcionSeleccionada = '', $observacion, $descuento = 0, $totalDesc = 0, $tipoSuscripcionSeleccionada, $allow = true, $tarifaSeleccionada, $formaPagoSeleccionada, $periodoSuscripcionSeleccionada = '', $modificarFecha = false, $from, $to, $total = 0, $iva = 0, $modalDomSubs = 0, $modalFormDom = 0, $domiciliosSubs, $datoSeleccionado, $domicilioSeleccionado = [], $parametro = [], $domicilioSubsId, $arregloDatos = [], $modalV = 0, $desde, $hasta, $converHasta, $domicilioId, $editEnabled = false, $ventas = [], $cantDom = 0, $cantArray = [], $inputCantidad, $posicion, $posicionDomSubs, $idSuscrip, $clients, $personalizado = 0, $costoPerson = 0, $buscarPrincipal = [], $siTieneSus = false, $links, $idSuscripcionSig = [], $clientesQuery = '';

    public $lunesVentas, $martesVentas, $miercolesVentas, $juevesVentas, $viernesVentas, $sabadoVentas, $domingoVentas, $query, $clientesBuscados = [], $dateF, $dateFiltro, $ventaEncontrada = null, $idRenovacionSuscripcion;

    public $lunesTotal = 0, $martesTotal = 0, $miercolesTotal = 0, $juevesTotal = 0, $viernesTotal = 0, $sabadoTotal = 0, $domingoTotal = 0;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
    }

    public function showSuscripcionRenovacion()
    {
        if ($this->clienteSeleccionado && $this->subscripcionEs == 'Renovación') {
            if (count($this->suscripciones) > 0) {
                for ($i = 0; $i < count($this->suscripciones); $i++) {
                    if ($this->suscripciones[$i]['estado'] != 'Cancelada') {
                        try {
                            $suscripcionSearch = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->where('suscripciones.id', (int)$this->idRenovacionSuscripcion)->get();

                            if ($suscripcionSearch != null) {
                                $this->domicilioId = $suscripcionSearch[0]->domicilio_id;
                                $this->cantEjem = $suscripcionSearch[0]->cantEjemplares;
                                $this->tipoSubscripcion = $suscripcionSearch[0]->suscripcion;
                                $this->tarifaSeleccionada = $suscripcionSearch[0]->tarifa;
                                $this->tipoSuscripcionSeleccionada = $suscripcionSearch[0]->tipoSuscripcion;
                                $this->diasSuscripcionSeleccionada = $suscripcionSearch[0]->dias;
                                $this->precio = $suscripcionSearch[0]->precio;
                                $this->contrato = $suscripcionSearch[0]->contrato;
                                $this->lunes = $suscripcionSearch[0]->lunes;
                                $this->martes = $suscripcionSearch[0]->martes;
                                $this->miércoles = $suscripcionSearch[0]->miércoles;
                                $this->jueves = $suscripcionSearch[0]->jueves;
                                $this->viernes = $suscripcionSearch[0]->viernes;
                                $this->sábado = $suscripcionSearch[0]->sábado;
                                $this->domingo = $suscripcionSearch[0]->domingo;
                                $this->descuento = $suscripcionSearch[0]->descuento;
                                $this->observacion = $suscripcionSearch[0]->observaciones;
                                $this->total = $suscripcionSearch[0]->importe;
                                $this->totalDesc = $suscripcionSearch[0]->total;
                                $this->formaPagoSeleccionada = $suscripcionSearch[0]->formaPago;
                                $this->periodoSuscripcionSeleccionada = $suscripcionSearch[0]->periodo;
                                $this->siTieneSus = true;
                                $this->total = 0;
                            }
                        } catch (\Exception $e) {
                            $this->status = 'error';
                            $this->dispatchBrowserEvent('alert', [
                                'message' => ($this->status == 'error') ? '¡No existe suscripcion con ese id!' : ' '
                            ]);
                        }
                    }
                }
            } else {
                $this->siTieneSus = false;
                $this->status = 'created';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡El cliente no tiene suscripciones!' : ''
                ]);
            }
        }
    }

    public function selectContact($pos)
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;
            if ($this->modalV) {
                $this->ventas = ventas::where('cliente_id', $this->clienteSeleccionado)->where('estado', '!=', "Cancelada")->get();
            } else {
                $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();
            }
            $this->domicilioSeleccionado = [];
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        if ($this->modalV == true && $this->query != '') {
            $this->clientesBuscados = Cliente
                ::where('id', '=', $this->query)
                ->orWhere('nombre', 'like', '%' . $this->query . '%')
                ->limit(6)
                ->get()
                ->toArray();
        } else if ($this->suscripciones == true && $this->query != '') {
            $this->clientesBuscados = Cliente
                ::where('id', '=', $this->query)
                ->orWhere('nombre', 'like', '%' . $this->query . '%')
                ->limit(6)
                ->get()
                ->toArray();
        } else if ($this->query == '') {
            $this->buscarPrincipal = [];
            $this->clientesBuscados = [];
        }
    }

    public function render()
    {
        $this->date = new Carbon();
        Carbon::setLocale('es');
        $this->dateF = new Carbon($this->from);
        $this->converHasta = new Carbon($this->desde);
        $this->dateFiltro = new Carbon($this->to);
        $this->desde = $this->converHasta->format('Y-m-d');
        $this->idSuscripcionSig = Suscripcion::latest('id')->first();
        $keyWord = '%' . $this->keyWord . '%';
        $data = [
            'Genérico' => 'GENÉRICO',
            'Gobierno' => 'GOBIERNO',
            /* 'T/O' => 'T/O', */
            'Credito' => 'CRÉDITO',
            'Libre' => 'LIBRE',
            'Municipio' => 'MUNICIPIO',
            /* 'S-A' => 'S-A',
            'T-E' => 'T-E', */
            /* 'Sanborn' => 'SANBORN', */
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

        if ($this->periodoSuscripcionSeleccionada == 'Mensual' || $this->periodoSuscripcionSeleccionada == 'Trimestral' || $this->periodoSuscripcionSeleccionada == 'Semestral' || $this->periodoSuscripcionSeleccionada == 'Anual') {

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
        }

        if ($this->periodoSuscripcionSeleccionada === 'Semanal') {
            $this->modificarFecha = true;
        }

        $rutas = Ruta::pluck('nombreruta', 'id');
        $tarifas = Tarifa::pluck('tipo', 'id');

        $this->dataClient = Cliente
            ::join("domicilio", "domicilio.cliente_id", "=", "cliente.id")
            ->join("ruta", "ruta.id", "=", "domicilio.ruta_id")
            ->where('cliente.id', '=', $this->clienteSeleccionado)
            ->select('cliente.*', 'domicilio.*', 'ruta.nombreruta')
            ->get();

        if ($this->diasSuscripcionSeleccionada != '') {
            if ($this->diasSuscripcionSeleccionada == 'l_v') {
                if ($this->tipoSuscripcionSeleccionada == 'Impresa') {
                    if ($this->cantEjem >= 1) {
                        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
                            $costo = $this->precio === 'Normal' ? 270 : 230;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
                            $costo = $this->precio === 'Normal' ? 750 : 630;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
                            $costo = $this->precio === 'Normal' ? 1480 : 1250;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
                            $costo = $this->precio === 'Normal' ? 2720 : 2450;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semanal') {
                            $costo = 0;
                            $this->tarifaSeleccionada = 'Person';
                            $this->personalizado = true;
                        }
                        $this->personalizado = false;
                        $this->total = (int)$this->cantEjem * (int)$costo;
                        $this->totalDesc = (int)$this->cantEjem * (int)$costo;
                    } else {
                        $this->total = 0;
                        $this->totalDesc = 0;
                    }
                } else if ($this->tipoSuscripcionSeleccionada == 'Digital') {
                    if ($this->cantEjem >= 1) {
                        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
                            $costo = 150;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
                            $costo = 435;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
                            $costo = 800;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
                            $costo = 1550;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semanal') {
                            $costo = 0;
                            $this->tarifaSeleccionada = 'Person';
                            $this->personalizado = true;
                        }
                        $this->personalizado = false;
                        $this->total = (int)$this->cantEjem * (int)$costo;
                        $this->totalDesc = (int)$this->cantEjem * (int)$costo;
                    } else {
                        $this->total = 0;
                        $this->totalDesc = 0;
                    }
                }
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = false;
                $this->domingo = false;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'l_d') {
                if ($this->tipoSuscripcionSeleccionada == 'Impresa') {
                    if ($this->cantEjem >= 1) {
                        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
                            $costo = $this->precio === 'Normal' ? 370 : 330;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
                            $costo = $this->precio === 'Normal' ? 1060 : 920;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
                            $costo = $this->precio === 'Normal' ? 2000 : 1790;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
                            $costo = $this->precio === 'Normal' ? 3920 : 3500;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semanal') {
                            $costo = 0;
                            $this->tarifaSeleccionada = 'Person';
                            $this->personalizado = true;
                        }
                        $this->personalizado = false;
                        $this->total = (int)$this->cantEjem * (int)$costo;
                        $this->totalDesc = (int)$this->cantEjem * (int)$costo;
                    } else {
                        $this->total = 0;
                        $this->totalDesc = 0;
                    }
                } else if ($this->tipoSuscripcionSeleccionada == 'Digital') {
                    if ($this->cantEjem >= 1) {
                        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
                            $costo = 150;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
                            $costo = 435;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
                            $costo = 800;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
                            $costo = 1550;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semanal') {
                            $costo = 0;
                            $this->tarifaSeleccionada = 'Person';
                            $this->personalizado = true;
                        }
                        $this->personalizado = false;
                        $this->total = (int)$this->cantEjem * (int)$costo;
                        $this->totalDesc = (int)$this->cantEjem * (int)$costo;
                    } else {
                        $this->total = 0;
                        $this->totalDesc = 0;
                    }
                }
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = true;
                $this->domingo = true;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'l_s') {
                if ($this->tipoSuscripcionSeleccionada == 'Impresa') {

                    if ($this->cantEjem >= 1) {
                        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
                            $costo = $this->precio === 'Normal' ? 300 : 300;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
                            $costo = $this->precio === 'Normal' ? 770 : 770;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
                            $costo = $this->precio === 'Normal' ? 1400 : 1400;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
                            $costo = $this->precio === 'Normal' ? 2900 : 2900;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semanal') {
                            $costo = 0;
                            $this->tarifaSeleccionada = 'Person';
                            $this->personalizado = true;
                        }
                        $this->personalizado = false;
                        $this->total = (int)$this->cantEjem * (int)$costo;
                        $this->totalDesc = (int)$this->cantEjem * (int)$costo;
                    } else {
                        $this->total = 0;
                        $this->totalDesc = 0;
                    }
                } else if ($this->tipoSuscripcionSeleccionada == 'Digital') {
                    if ($this->cantEjem >= 1) {
                        if ($this->periodoSuscripcionSeleccionada == 'Mensual') {
                            $costo = 150;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Trimestral') {
                            $costo = 435;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semestral') {
                            $costo = 800;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Anual') {
                            $costo = 1550;
                            $this->personalizado = false;
                        } else if ($this->periodoSuscripcionSeleccionada == 'Semanal') {
                            $costo = 0;
                            $this->tarifaSeleccionada = 'Person';
                            $this->personalizado = true;
                        }
                        $this->total = (int)$this->cantEjem * (int)$costo;
                        $this->totalDesc = (int)$this->cantEjem * (int)$costo;
                    } else {
                        $this->total = 0;
                        $this->totalDesc = 0;
                    }
                }
                $this->lunes = true;
                $this->martes = true;
                $this->miércoles = true;
                $this->jueves = true;
                $this->viernes = true;
                $this->sábado = true;
                $this->domingo = false;
                $this->allow = false;
            } else if ($this->diasSuscripcionSeleccionada == 'esc_man') {
                $this->allow = true;
            }
        }

        if ($this->tarifaSeleccionada == 'Person') {
            $costo = 0;

            $this->personalizado = true;

            if ($this->cantEjem >= 1) {
                /* $costo = $this->tarifaSeleccionada === 'Base' ? 330 : ($this->tarifaSeleccionada === 'Ejecutiva' ? 300 : 0); */
                if ($this->tarifaSeleccionada === 'Person') {
                    $costo = $this->costoPerson;
                }
                $this->total = (int)$this->cantEjem * (int)$costo;
                $this->totalDesc = (int)$this->cantEjem * (int)$costo;
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
        } else {
            $this->personalizado = false;
        }

        $this->domiciliosSubs = DomicilioSubs
            ::join("cliente", "cliente.id", "=", "domicilio_subs.cliente_id")
            ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
            ->select('domicilio_subs.*', 'ruta.nombreruta')
            ->get();

        if ($this->clienteSeleccionado && $this->contrato == 'Cortesía') {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();
            $this->total = 0;
            $this->totalDesc = 0;
        }

        if ($this->clasificacion) {
            if ($this->clasificacion == 'GENÉRICO') {
                $this->rfc_input = 'XAXX010101000';
                $this->regimen_fiscal = 616;
                $this->razon_social = 'PUBLICO EN GENERAL';
                $this->cp = '58190';
                $this->rfc = 'Física';
            }
        }

        if ($this->lunesVentas || $this->martesVentas || $this->miercolesVentas || $this->juevesVentas || $this->viernesVentas || $this->sabadoVentas || $this->domingoVentas) {
            $domicilio = Domicilio::where('cliente_id', $this->clienteSeleccionado)->first();
            if ($domicilio) {
                $tarifa = Tarifa::where('id', $domicilio->tarifa_id)->first();
                $this->lunesTotal = (int)$this->lunesVentas * $tarifa['ordinario'];
                $this->martesTotal = (int)$this->martesVentas * $tarifa['ordinario'];
                $this->miercolesTotal = (int)$this->miercolesVentas * $tarifa['ordinario'];
                $this->juevesTotal = (int)$this->juevesVentas * $tarifa['ordinario'];
                $this->viernesTotal = (int)$this->viernesVentas * $tarifa['ordinario'];
                $this->sabadoTotal = (int)$this->sabadoVentas * $tarifa['ordinario'];
                $this->domingoTotal = (int)$this->domingoVentas * $tarifa['dominical'];

                $this->total = $this->lunesTotal + $this->martesTotal + $this->miercolesTotal + $this->juevesTotal + $this->viernesTotal + $this->sabadoTotal + $this->domingoTotal;
            }
        }

        return view('livewire.clientes.view', [
            'clientes' => Cliente::where('id', '=', $this->clientesQuery)
                ->orWhere('nombre', 'like', '%' . $this->clientesQuery . '%')->paginate(10),
            'rfc' => $this->rfc,
            'total' => $this->total,
        ], compact('data', 'rutas', 'tarifas', 'formaPago'));
    }

    public function cerrarModalSuscripciones()
    {
        $this->suscripciones = false;
        $this->borrar();
    }

    public function create()
    {
        $this->resetInput();
        $this->openModalPopover();
        $this->editEnabled = false;
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
        $this->clienteSeleccionado = [];
    }

    public function modalCrearDomSubs()
    { {
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
        $this->clienteSeleccionado = [];
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
        $this->validate([
            'estado' => 'required',
            'pais' => 'required',
            'regimen_fiscal' => 'required',
            'telefono' => 'required|max:10',
            'email' => 'required|string|unique:users',
            'email_cobranza' => 'required|string',
            'rfc' => 'required',
            'rfc_input' => 'required',
            'clasificacion' => 'required',
        ]);

        Cliente::Create([
            'clasificacion' => strtoupper($this->clasificacion),
            'rfc' => strtoupper($this->rfc),
            'rfc_input' => strtoupper($this->rfc_input),
            'nombre' => strtoupper($this->nombre) ? strtoupper($this->nombre) : null,
            'estado' => strtoupper($this->estado),
            'pais' => strtoupper($this->pais),
            'email' => strtoupper($this->email),
            'email_cobranza' => strtoupper($this->email_cobranza),
            'telefono' => strtoupper($this->telefono),
            'regimen_fiscal' => strtoupper($this->regimen_fiscal),
            'razon_social' => strtoupper($this->razon_social) ? strtoupper($this->razon_social) : null,
        ]);

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
        $this->razon_social = $Cliente->razon_social;

        $this->openModalPopover();

        $this->status = 'updated';
    }

    public function update()
    {
        $this->validate([
            'estado' => 'required',
            'pais' => 'required',
            'regimen_fiscal' => 'required',
            'telefono' => 'required|max:10',
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
            'razon_social' => $this->razon_social,
        ]);

        $this->status = 'updated';
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
        }
    }

    /* Aqui comienzan las suscripciones */
    public function createSubs()
    { {
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
            'calle' => strtoupper($this->calle),
            'noint' => $this?->noint,
            'noext' => $this->noext,
            'colonia' => strtoupper($this->colonia),
            'cp' => $this->cp,
            'localidad' => strtoupper($this->localidad),
            'ciudad' => strtoupper($this->ciudad),
            'referencia' => strtoupper($this->referencia),
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

    public function abrirModalDomicilio()
    { {
            $this->clienteSeleccionado ? $this->clienteModalOpen = true : $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Seleccione un cliente!' : ''
            ]);
            $domicilio = Domicilio::where('cliente_id', $this->clienteSeleccionado)->first();

            if ($domicilio) {
                $this->domicilio_id = $this->clienteSeleccionado['id'];
                $this->calle = $domicilio->calle;
                $this->noint = $domicilio->noint;
                $this->noext = $domicilio->noext;
                $this->colonia = $domicilio->colonia;
                $this->cp = $domicilio->cp;
                $this->localidad = $domicilio->localidad;
                $this->municipio = $domicilio->municipio;
                $this->referencia = $domicilio->referencia;
                $this->ruta_id = $domicilio->ruta_id;
                $this->tarifa_id = $domicilio->tarifa_id;

                $this->status = 'updated';
            }
        }
    }

    public function crearDomicilio()
    {
        $this->validate(
            [
                'calle' => 'required',
                'noext' => 'required',
                'colonia' => 'required',
                'cp' => 'required',
                'localidad' => 'required',
                'municipio' => 'required',
                'ruta_id' => 'required',
                'tarifa_id' => 'required',
                'referencia' => 'required',
            ]
        );

        Domicilio::Create([
            'cliente_id' => $this->cliente_id = Cliente::where('id', $this->clienteSeleccionado['id'])->first()->id,
            'calle' => strtoupper($this->calle),
            'noint' => $this->noint ? $this->noint : 0,
            'noext' => $this->noext,
            'colonia' => strtoupper($this->colonia),
            'cp' => $this->cp,
            'localidad' => strtoupper($this->localidad),
            'municipio' => strtoupper($this->municipio),
            'ruta_id' => $this->ruta_id,
            'tarifa_id' => $this->tarifa_id,
            'referencia' => strtoupper($this->referencia),
        ]);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio creado correctamente!' : ''
        ]);

        $this->clienteModalOpen = false;
    }

    public function actualizarDomicilio()
    {
        $domicilio = Domicilio::where('cliente_id', $this->clienteSeleccionado)->first();

        $domicilio->update([
            'calle' => strtoupper($this->calle),
            'noint' => $this->noint,
            'noext' => $this->noext,
            'colonia' => strtoupper($this->colonia),
            'cp' => $this->cp,
            'localidad' => strtoupper($this->localidad),
            'municipio' => strtoupper($this->municipio),
            'ruta_id' => $this->ruta_id,
            'tarifa_id' => $this->tarifa_id,
            'referencia' => strtoupper($this->referencia),
        ]);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio actualizado correctamente!' : ''
        ]);
        $this->resetInput();
        $this->emit('closeModal');
        $this->clienteModalOpen = false;
    }

    public function crearVenta()
    {
        $this->status = 'created';
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

                    $domicilio = Domicilio::where('cliente_id', $this->clienteSeleccionado)->first();
                    if ($domicilio) {
                        $tarifa = Tarifa::where('id', $domicilio->tarifa_id)->first();
                        $this->lunesTotal = (int)$this->lunesVentas * $tarifa['ordinario'];
                        $this->martesTotal = (int)$this->martesVentas * $tarifa['ordinario'];
                        $this->miercolesTotal = (int)$this->miercolesVentas * $tarifa['ordinario'];
                        $this->juevesTotal = (int)$this->juevesVentas * $tarifa['ordinario'];
                        $this->viernesTotal = (int)$this->viernesVentas * $tarifa['ordinario'];
                        $this->sabadoTotal = (int)$this->sabadoVentas * $tarifa['ordinario'];
                        $this->domingoTotal = (int)$this->domingoVentas * $tarifa['dominical'];

                        $this->total = $this->lunesTotal + $this->martesTotal + $this->miercolesTotal + $this->juevesTotal + $this->viernesTotal + $this->sabadoTotal + $this->domingoTotal;

                        $this->validate([
                            'lunesVentas' => 'required|numeric|min:0',
                            'martesVentas' => 'required|numeric|min:0',
                            'miercolesVentas' => 'required|numeric|min:0',
                            'juevesVentas' => 'required|numeric|min:0',
                            'viernesVentas' => 'required|numeric|min:0',
                            'sabadoVentas' => 'required|numeric|min:0',
                            'domingoVentas' => 'required|numeric|min:0',
                            'hasta' => 'required',
                        ]);

                        ventas::Create([
                            'idVenta' => 'venta' . $this->idSuscrip,
                            'tipo' => 'venta',
                            'cliente_id' => $this->cliente_id = Cliente::where('id', $this->clienteSeleccionado['id'])->first()->id,
                            'domicilio_id' => $domicilio->id,
                            'desde' => $this->desde,
                            'hasta' => $this->hasta,
                            'lunes' => $this->lunesVentas,
                            'martes' => $this->martesVentas,
                            'miércoles' => $this->miercolesVentas,
                            'jueves' => $this->juevesVentas,
                            'viernes' => $this->viernesVentas,
                            'sábado' => $this->sabadoVentas,
                            'domingo' => $this->domingoVentas,
                            'total' => $this->total,
                            'estado' => 'Activo',
                            'remisionStatus' => 'Pendiente',
                            'tiroStatus' => 'Activo',
                        ]);

                        $this->status = 'created';
                        $this->modalV = false;
                        $this->ventaEncontrada = null;


                        $this->limpiarVentaModal();

                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'created') ? '¡Venta generada exitosamente!' : ''
                        ]);
                    } else {
                        $this->status = 'error';
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'error') ? '¡El cliente no tiene domicilio!' : ''
                        ]);
                    }
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
        $this->ventas = ventas::find($this->ventaEncontrada);
        $domicilio = Domicilio::find($this->ventas['domicilio_id']);

        if ($domicilio) {
            $tarifa = Tarifa::find($domicilio['tarifa_id']);
            $lunesTotal = (int)$this->lunesVentas * $tarifa['ordinario'];
            $martesTotal = (int)$this->martesVentas * $tarifa['ordinario'];
            $miercolesTotal = (int)$this->miercolesVentas * $tarifa['ordinario'];
            $juevesTotal = (int)$this->juevesVentas * $tarifa['ordinario'];
            $viernesTotal = (int)$this->viernesVentas * $tarifa['ordinario'];
            $sabadoTotal = (int)$this->sabadoVentas * $tarifa['ordinario'];
            $domingoTotal = (int)$this->domingoVentas * $tarifa['dominical'];

            $this->total = $lunesTotal + $martesTotal + $miercolesTotal + $juevesTotal + $viernesTotal + $sabadoTotal + $domingoTotal;

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
                'total' => $this->total
            ]);

            $this->status = 'updated';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'updated') ? '¡Venta actualizada exitosamente!' : ''
            ]);
            $this->status = 'created';
            $this->limpiarVentaModal();
            $this->modalV = false;

            /* return Redirect::to('/PDFVenta'); */
        }
    }

    public function editarVenta()
    {
        if ($this->ventaEncontrada && $this->clienteSeleccionado) {
            if (count($this->ventas) > 0) {
                for ($i = 0; $i < count($this->ventas); $i++) {
                    if ($this->ventas[$i]['estado'] != 'Cancelada') {

                        try {
                            $ventaSearch = ventas::where('cliente_id', $this->clienteSeleccionado)->where('ventas.id', (int)$this->ventaEncontrada)->get();
                            if ($ventaSearch != null) {
                                $this->desde = $ventaSearch[0]['desde'];
                                $this->hasta = $ventaSearch[0]['hasta'];
                                $this->lunesVentas = $ventaSearch[0]['lunes'];
                                $this->martesVentas = $ventaSearch[0]['martes'];
                                $this->miercolesVentas = $ventaSearch[0]['miércoles'];
                                $this->juevesVentas = $ventaSearch[0]['jueves'];
                                $this->viernesVentas = $ventaSearch[0]['viernes'];
                                $this->sabadoVentas = $ventaSearch[0]['sábado'];
                                $this->domingoVentas = $ventaSearch[0]['domingo'];
                                $this->editEnabled = true;
                            }
                        } catch (\Exception $e) {
                            $this->status = 'error';
                            $this->dispatchBrowserEvent('alert', [
                                'message' => ($this->status == 'error') ? '¡No existe venta con ese id!' : ' '
                            ]);
                        }
                    } else {
                        $this->hasta = null;
                        $this->lunesVentas = null;
                        $this->martesVentas = null;
                        $this->miercolesVentas = null;
                        $this->juevesVentas = null;
                        $this->viernesVentas = null;
                        $this->sabadoVentas = null;
                        $this->domingoVentas = null;
                        $this->editEnabled = false;
                    }
                }
            }
        } else {
            $this->hasta = null;
            $this->lunesVentas = null;
            $this->martesVentas = null;
            $this->miercolesVentas = null;
            $this->juevesVentas = null;
            $this->viernesVentas = null;
            $this->sabadoVentas = null;
            $this->domingoVentas = null;
            $this->editEnabled = false;
        }
        /* if ($this->clienteSeleccionado) {
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
        } */
    }

    public function limpiarClienteSeleccionado()
    {
        $this->editEnabled = false;
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
        $this->ventaEncontrada = null;
        $this->total = null;
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
        $this->idSuscrip = Str::random(6);
        if ($this->clienteSeleccionado) {
            $this->suscripciones = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();

            if (/*$this->suscripciones->isEmpty() &&*/$this->subscripcionEs == 'Apertura') {
                if ($this->cantEjem != 0) {
                    if ($this->domicilioSeleccionado) {
                        if ($this->from && $this->to) {
                            $this->validate([
                                'tarifaSeleccionada' => 'required',
                                'cantEjem' => 'required',
                                'tipoSuscripcionSeleccionada.*' => 'required',
                                'periodoSuscripcionSeleccionada.*' => 'required',
                                'diasSuscripcionSeleccionada.*' => 'required',
                                'from' => 'required',
                                'to' => 'required',
                            ]);

                            Suscripcion::Create([
                                'idSuscripcion' => 'suscri' . $this->idSuscrip,
                                'tipo' => 'suscripcion',
                                'cliente_id' => $this->clienteSeleccionado['id'],
                                'suscripcion' => $this->tipoSubscripcion,
                                'esUnaSuscripcion' => $this->subscripcionEs,
                                'tarifa' => $this->tarifaSeleccionada,
                                'cantEjemplares' => (int)$this->cantEjem,
                                'precio' => $this->precio,
                                'contrato' => $this->contrato,
                                'tipoSuscripcion' => $this->tipoSuscripcionSeleccionada,
                                'periodo' => $this->periodoSuscripcionSeleccionada,
                                'fechaInicio' => $this->from,
                                'fechaFin' => $this->to,
                                'dias' => $this->diasSuscripcionSeleccionada,
                                'estado' => 'sin pagar',
                                'lunes' => $this->lunes,
                                'martes' => $this->martes,
                                'miércoles' => $this->miércoles,
                                'jueves' => $this->jueves,
                                'viernes' => $this->viernes,
                                'sábado' => $this->sábado,
                                'domingo' => $this->domingo,
                                'descuento' => $this->descuento,
                                'observaciones' => $this->observacion,
                                'importe' => (int)$this->total,
                                'total' => $this->totalDesc,
                                'domicilio_id' => $this->domicilioSeleccionado[0]['id'],
                                'remisionStatus' => 'Pendiente',
                                'tiroStatus' => 'Activo',
                            ]);

                            $datosCliente = domicilioSubs::where('cliente_id', $this->clienteSeleccionado['id'])->get();
                            $ruta = Ruta::where('id', $this->domicilioSeleccionado[0]['ruta'])->get();

                            $pdf = PDF::loadView('livewire.comprobantePDF', [
                                'esUnaSuscripcion' => $this->subscripcionEs,
                                'periodo' => $this->periodoSuscripcionSeleccionada,
                                'cantEjemplares' => (int)$this->cantEjem,
                                'observaciones' => $this->observacion,
                                'total' => $this->total,
                                'ruta' => $ruta,
                                'cliente' => $this->clienteSeleccionado,
                                'domicilio' => $datosCliente,
                                'desde' => $this->from,
                                'hasta' => $this->to,
                                'fecha' => $this->date,
                                'idSuscripcionSig' => $this->idSuscripcionSig != null ? $this->idSuscripcionSig['id'] + 1 : 1,
                            ])
                                ->setPaper('A5', 'landscape')
                                ->output();

                            Storage::disk('public')->put('suscripcion.pdf', $pdf);

                            $this->status = 'created';

                            /* $this->status = 'updated'; */

                            $this->dispatchBrowserEvent('alert', [
                                'message' => ($this->status == 'created') ? '¡Suscripción generada correctamente!' : ''
                            ]);

                            $this->suscripciones = false;

                            $this->borrar();

                            return Redirect::to('/PDFSuscripcion');
                        } else {
                            $this->dispatchBrowserEvent('alert', [
                                'message' => '¡Debes seleccionar la fecha!'
                            ]);
                        }
                    } else {
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'created') ? '¡Seleccione un domicilio!' : ''
                        ]);
                    }
                } else {
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡No puedes poner cero!' : ''
                    ]);
                }
            }

            if ($this->subscripcionEs == 'Renovación' && $this->siTieneSus == true) {
                if ($this->from && $this->to) {
                    $suscrip = Suscripcion::where('cliente_id', $this->clienteSeleccionado)->get();


                    $suscrip = Suscripcion::find($suscrip[0]->id);

                    $suscrip->update([
                        'periodo' => $this->periodoSuscripcionSeleccionada,
                        'fechaInicio' => $this->from,
                        'fechaFin' => $this->to,
                        'dias' => $this->diasSuscripcionSeleccionada,
                        'lunes' => $this->lunes,
                        'martes' => $this->martes,
                        'miércoles' => $this->miércoles,
                        'jueves' => $this->jueves,
                        'viernes' => $this->viernes,
                        'sábado' => $this->sábado,
                        'domingo' => $this->domingo,
                        'importe' => (int)$this->total,
                        'total' => $this->totalDesc,
                    ]);

                    $this->status = 'created';

                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Renovación generada!' : ''
                    ]);

                    $this->suscripciones = false;

                    $this->borrar();
                }
            }
        } else {
            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Selecciona un cliente!' : ''
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
        $this->periodoSuscripcionSeleccionada = '...';
        $this->diasSuscripcionSeleccionada = '...';
        $this->descuento = 0;
        $this->observacion = '';
        $this->total = 0;
        $this->descuento = 0;
        $this->totalDesc = 0;
        $this->formaPagoSeleccionada = '';
        $this->domicilioSeleccionado = [];
        $this->lunes = false;
        $this->martes = false;
        $this->miércoles = false;
        $this->jueves = false;
        $this->viernes = false;
        $this->sábado = false;
        $this->domingo = false;
        $this->allow = true;
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
            'ruta' => $this->ruta
        ]);

        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio actualizado exitosamente!' : ''
        ]);
        $this->status = 'created';
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

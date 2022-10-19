<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use App\Models\Tiro;
use App\Models\ventas;
use App\Models\Domicilio;
use App\Models\Invoice;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;
use Symfony\Component\HttpKernel\Exception\HttpException;


class Factura extends Component
{
    public $clienteid, $idTipo, $cliente, $suscripcion, $domicilio, $tipoFactura = '', $PaymentForm, $cfdiUse, $activarCG = false, $status = '', $venta, $tiro, $globalInformation, $items, $rfcGenerico, $nombreGenerico, $cpGenerico, $regimenFisGenerico, $modalAgregar = 0, $rfcInput, $cpInput, $colInput, $estadoInput, $noextInput, $regimenfisInput, $razonsInput, $calleInput, $paisInput, $nointInput, $d, $modalErrors = 0;

    public function render()
    {
        if ($this->activarCG) {
            $this->cliente['nombre'] = 'PUBLICO EN GENERAL';
            $this->cliente['rfc_input'] = 'XAXX010101000';
            /* $this->cfdiUse = 'S01'; */
            $this->cliente['regimen_fiscal'] = '616';
            /* $this->PaymentForm = '03'; */
            $this->domicilio['cp'] = '58190';
            $this->globalInformation = [
                "Periodicity" => "04",
                "Months" => "08",
                "Year" => "2022",
            ];
            $this->rfcGenerico = 'XAXX010101000';
            $this->nombreGenerico = 'PUBLICO EN GENERAL';
            $this->cpGenerico = '58190';
            $this->regimenFisGenerico = '616';
        }
        return view('livewire.factura.view', ['d' => $this->d]);
    }

    public function mount($cliente_id, $idTipo)
    {
        if (substr($idTipo, 0, 6) == 'suscri') {
            $this->clienteid = $cliente_id;
            $this->idTipo = $idTipo;

            $this->cliente = Cliente::find($cliente_id);
            /* $this->historial = Tiro::where('idTipo', $idTipo)->get(); */
            $this->suscripcion = Suscripcion::where('idSuscripcion', $idTipo)->first();
            $this->domicilio = domicilioSubs::where('id', $this->suscripcion['domicilio_id'])->first();

            $this->tipoFactura = 'PUE';
        } else if (substr($idTipo, 0, 5) == 'venta') {
            $this->clienteid = $cliente_id;
            $this->idTipo = $idTipo;

            $this->cliente = Cliente::find($cliente_id);
            $this->suscripcion = ventas::where('idVenta', $idTipo)->first();
            $this->domicilio = Domicilio::where('id', $this->suscripcion['domicilio_id'])->first();
            $this->tipoFactura = 'PUE';
            $this->tiro = Tiro::where('cliente_id', $cliente_id)->first();
            /* $this->globalInformation[] = []; */
        }
    }

    public function modalEdit()
    {
        $this->modalAgregar = true;

        if (substr($this->idTipo, 0, 6) == 'suscri') {
            $domicilioEdit = domicilioSubs::find($this->suscripcion['domicilio_id']);
            $this->cpInput = $domicilioEdit->cp;
            $this->calleInput = $domicilioEdit->calle;
            $this->noextInput = $domicilioEdit->noext;
            $this->nointInput = $domicilioEdit->noint;
            $this->colInput = $domicilioEdit->colonia;
        } else {
            $domicilioEdit = Domicilio::find($this->suscripcion['domicilio_id']);
            $this->cpInput = $domicilioEdit->cp;
            $this->calleInput = $domicilioEdit->calle;
            $this->noextInput = $domicilioEdit->noext;
            $this->nointInput = $domicilioEdit->noint;
            $this->colInput = $domicilioEdit->colonia;
        }

        $clienteEdit = Cliente::find($this->clienteid);
        $this->rfcInput = $clienteEdit->rfc_input;
        $this->estadoInput = $clienteEdit->estado;
        $this->paisInput = $clienteEdit->pais;
        $this->regimenfisInput = $clienteEdit->regimen_fiscal;
        $this->razonsInput = $clienteEdit->razon_social;
    }

    public function editar()
    {
        $this->validate([
            'rfcInput' => 'required',
            'cpInput' => 'required',
            /* 'calleInput' => 'required', */
            /* 'noextInput' => 'required', */
            /* 'coloniaInput' => 'required', */
            'estadoInput' => 'required',
            'paisInput' => 'required',
            /* 'nointInput' => 'required', */
            'regimenfisInput' => 'required',
            'razonsInput' => 'required',
        ]);

        if (substr($this->idTipo, 0, 6) == 'suscri') {
            $domicilioEdit = domicilioSubs::find($this->suscripcion['domicilio_id']);
            $domicilioEdit->update([
                'cp' => $this->cpInput,
                'calle' => $this->calleInput,
                'noext' => $this->noextInput,
                'noint' => $this->nointInput,
                'colonia' => $this->colInput,
            ]);
        } else {
            $domicilioEdit = Domicilio::find($this->suscripcion['domicilio_id']);
            $domicilioEdit->update([
                'cp' => $this->cpInput,
                'calle' => $this->calleInput,
                'noext' => $this->noextInput,
                'noint' => $this->nointInput,
                'colonia' => $this->colInput,
            ]);
        }

        $clienteEdit = Cliente::find($this->clienteid);
        $clienteEdit->update([
            'rfc_input' => $this->rfcInput,
            'estado' => $this->estadoInput,
            'pais' => $this->paisInput,
            'regimen_fiscal' => $this->regimenfisInput,
            'razon_social' => $this->razonsInput,
        ]);


        $this->modalAgregar = false;
    }

    public function facturar()
    {
        if (substr($this->idTipo, 0, 6) == 'suscri') {
            $items = [
                [
                    "Serie" => "SUSPUE",
                    "ProductCode" => "55101504",
                    "IdentificationNumber" => "EDL",
                    "Description" => $this->activarCG ? "VENTA PERIODICO FACTURA GLOBAL" : "VENTA PERIODICO FACTURA",
                    "Unit" => "Pieza",
                    "UnitCode" => "H87",
                    "UnitPrice" => $this->suscripcion->tarifa == 'Base' ? "330" : "300",
                    "Discount" => $this->suscripcion->descuento,
                    "Quantity" => $this->suscripcion->cantEjemplares,
                    "Subtotal" => $this->suscripcion->importe,
                    "ObjetoImp" => "02",
                    "TaxObject" => "02",
                    "Taxes" => [
                        [
                            "Total" => 0.0,
                            "Name" => "IVA",
                            "Base" => $this->suscripcion->importe,
                            "Rate" => 0,
                            "IsRetention" => false
                        ]
                    ],
                    "Total" => $this->suscripcion->total,
                ]
            ];
        } else {
            $items = [
                [
                    "Serie" => "VPPUE",
                    "ProductCode" => "55101504",
                    "IdentificationNumber" => "EDL",
                    "Description" => $this->activarCG ? "VENTA PERIODICO FACTURA GLOBAL" : "VENTA PERIODICO FACTURA",
                    "Unit" => "Pieza",
                    "UnitCode" => "H87",
                    "UnitPrice" => $this->tiro->precio,
                    "Discount" => 0,
                    "Quantity" => $this->tiro->entregar,
                    "Subtotal" => $this->tiro->importe,
                    "ObjetoImp" => "02",
                    "TaxObject" => "02",
                    "Taxes" => [
                        [
                            "Total" => 0.0,
                            "Name" => "IVA",
                            "Base" => $this->tiro->importe,
                            "Rate" => 0,
                            "IsRetention" => false
                        ]
                    ],
                    "Total" => $this->tiro->importe
                ]
            ];
        }

        if ($this->cliente['nombre'] != '') {
            $nombre = $this->cliente['nombre'];
        } else if ($this->cliente['razon_social'] != '') {
            $nombre = $this->cliente['razon_social'];
        }

        $this->globalInformation = [
            "Periodicity" => "04",
            "Months" => "08",
            "Year" => "2022",
        ];

        if ($this->PaymentForm && $this->cfdiUse) {
            $facturama =  \Crisvegadev\Facturama\Invoice::create([
                "Serie" => substr($this->idTipo, 0, 6) == 'suscri' ? "SUSPUE" : "VPPUE",
                "Currency" => "MXN",
                "ExpeditionPlace" => "58190",
                /* "PaymentConditions" => "CREDITO A SIETE DIAS", */
                "Folio" => substr($this->idTipo, 0, 6) == 'suscri' ? "2" : "1",
                "CfdiType" => "I",
                "PaymentForm" => $this->PaymentForm,
                "PaymentMethod" => $this->tipoFactura,
                "GlobalInformation" => $this->globalInformation ? $this->globalInformation : [],
                "Decimals" => "2",
                "Receiver" => [
                    "Rfc" => $this->activarCG ? $this->rfcGenerico : $this->cliente['rfc_input'],
                    "Name" => $this->activarCG ? $this->nombreGenerico : $nombre,
                    "CfdiUse" => $this->cfdiUse,
                    "TaxZipCode" => $this->activarCG ? $this->cpGenerico : $this->domicilio['cp'],
                    "FiscalRegime" => $this->activarCG ? $this->regimenFisGenerico : $this->cliente['regimen_fiscal'],
                    "email" => $this->cliente['email'],
                    "Address" => [
                        "Street" => $this->domicilio['calle'],
                        "ExteriorNumber" => (string) $this->domicilio['noext'],
                        "InteriorNumber" => (string) $this->domicilio['noint'],
                        "Neighborhood" => $this->domicilio['colonia'],
                        "Locality" => $this->domicilio['localidad'],
                        "State" => $this->cliente['estado'],
                        "Country" => $this->cliente['pais'],
                        "ZipCode" => (string) $this->domicilio['cp'],
                    ]
                ],
                'Items' => $items,
            ]);

        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Rellena todos los campos!' : ''
            ]);
        }

        try {
            if ($facturama->statusCode == 201) {

                $facturama->data->Date = Carbon::parse($facturama->data->Date)->format('Y-m-d');
                Invoice::create([
                    'invoice_id' => $facturama->data->Id,
                    'invoice_date' => $facturama->data->Date,
                    'cliente_id' => $this->clienteid,
                    'cliente' => $nombre,
                    'idTipo' => $this->idTipo,
                    'status' => 'Vigente',
                    'serie' => $facturama->data->Serie,
                    'folio' => $facturama->data->Folio,
                    'paymentTerms' => $facturama->data->PaymentTerms,
                    'paymentMethod' => $facturama->data->PaymentMethod,
                    'expeditionPlace' => $facturama->data->ExpeditionPlace,
                    'currency' => $facturama->data->Currency,
                    'fiscalRegime' => $facturama->data->Issuer->FiscalRegime,
                    'rfc' => $facturama->data->Issuer->Rfc,
                    'productCode' => $facturama->data->Items[0]->ProductCode,
                    'unitCode' => $facturama->data->Items[0]->UnitCode,
                    'quantity' => $facturama->data->Items[0]->Quantity,
                    'unit' => $facturama->data->Items[0]->Unit,
                    'description' => $facturama->data->Items[0]->Description,
                    'unitValue' => $facturama->data->Items[0]->UnitValue,
                    'subtotal' => $facturama->data->Subtotal,
                    'discount' => $facturama->data->Discount,
                    'total' => $facturama->data->Total,
                ]);


                $this->tiro = Tiro::where('cliente_id', $this->clienteid)->update([
                    'status' => 'facturado',
                ]);

                $this->status = 'created';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡Se creo exitosamente la factura!' : ''
                ]);

                return redirect('/vistaPrevia/' . $facturama->data->Id);
            } else {
                $this->d = "";

                foreach ($facturama->errors as $key => $error) {
                    $this->d .= "- $error \n";
                }

                $this->modalErrors = true;
                /* $this->alert('error', $this->d, [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'onConfirmed' => '',
                ]); */
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Rellena todos los campos!' : ''
            ]);
        }
    }
}

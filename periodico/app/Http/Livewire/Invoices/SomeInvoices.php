<?php

namespace App\Http\Livewire\Invoices;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Tiro;
use App\Models\Domicilio;
use App\Models\Invoice;
use App\Models\Ruta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SomeInvoices extends Component
{
    public $query = '', $clientesBuscados = [], $clienteBarraBuscadora = null, $address = [], $modalAgregar = false, $rfcInput, $cpInput, $colInput, $estadoInput, $noextInput, $nointInput, $regimenfisInput, $razonsInput, $calleInput, $paisInput, $d, $payType = 'contado', $orders, $PaymentForm, $cfdi, $productCode;

    public $ordenFound, $customerFound, $invoice_data, $activarCG = false, $invoice, $globalInformation, $cfdiUse, $tipoFactura, $serie, $status, $modalErrors, $odersSelected = [], $data = [], $dataOrdersFound = [];

    public $ventas = [], $suscripciones = [], $selected = [], $rutas, $rutaSeleccionada = '', $rfcGenerico, $nombreGenerico, $cpGenerico, $regimenFisGenerico, $cfdipe = "(issued | received)", $concepto = '';

    public function mount($type)
    {
        $this->tipoFactura = $type;
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
    }

    public function selectContact($pos)
    {
        $this->clienteBarraBuscadora = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteBarraBuscadora) {
            $this->clienteBarraBuscadora;

            $this->address = Domicilio::where('cliente_id', $this->clienteBarraBuscadora['id'])
                ->first();

            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        if ($this->query != '') {
            $this->clientesBuscados = Cliente::where('nombre', 'like', '%' . $this->query . '%')
                ->limit(8)
                ->get()
                ->toArray();
        }
    }

    public function modalEdit()
    {
        $this->modalAgregar = true;

        if ($this->clienteBarraBuscadora != null) {
            $this->rfcInput = $this->clienteBarraBuscadora['rfc_input'];
            $this->cpInput = $this->address['cp'];
            $this->colInput = $this->address['colonia'];
            $this->estadoInput = $this->clienteBarraBuscadora['estado'];
            $this->noextInput = $this->address['noext'];
            $this->nointInput = $this->address['noint'];
            $this->regimenfisInput = $this->clienteBarraBuscadora['regimen_fiscal'];
            $this->razonsInput = $this->clienteBarraBuscadora['razon_social'];
            $this->calleInput = $this->address['calle'];
            $this->paisInput = $this->clienteBarraBuscadora['pais'];

            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Cliente actualizado correctamente!' : ''
            ]);
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes seleccionar y buscar un cliente primero!' : ''
            ]);
        }
    }

    public function editar()
    {
        $cliente = Cliente::where('id', $this->clienteBarraBuscadora['id'])->first();
        $cliente->update([
            'rfc_input' => $this->rfcInput,
            'estado' => $this->estadoInput,
            'pais' => $this->paisInput,
            'razon_social' => $this->razonsInput,
        ]);

        $domicilio = Domicilio::where('cliente_id', $this->clienteBarraBuscadora['id'])->first();
        $domicilio->update([
            'cp' => $this->cpInput,
            'colonia' => $this->colInput,
            'noext' => $this->noextInput,
            'noint' => $this->nointInput,
            'regimen_fiscal' => $this->regimenfisInput,
            'calle' => $this->calleInput,
        ]);

        $this->modalAgregar = false;
    }

    public function facturar()
    {
        if ($this->activarCG) {
            $this->clienteBarraBuscadora['nombre'] = 'PUBLICO EN GENERAL';
            $this->clienteBarraBuscadora['rfc_input'] = 'XAXX010101000';
            /* $this->cfdiUse = 'S01'; */
            $this->clienteBarraBuscadora['regimen_fiscal'] = '616';
            /* $this->PaymentForm = '03'; */
            $this->address['cp'] = '58190';
        }

        for ($i = 0; $i < count($this->odersSelected); $i++) {
            array_push($this->dataOrdersFound, Tiro::where('id', $this->odersSelected[$i])->first());

            array_push(
                $this->data,
                [
                    "Serie" => (substr($this->dataOrdersFound[$i]['idTipo'], 0, 6) == 'suscri' && $this->tipoFactura == 'PUE' ? 'SUSPUE' : (substr($this->dataOrdersFound[$i]['idTipo'], 0, 6) == 'suscri' && $this->tipoFactura == 'PPD' ? 'SUSPPD' : ($this->tipoFactura == 'PUE' ? 'VPPUE' : 'VPPPD'))),
                    "ProductCode" => '55101504',
                    "IdentificationNumber" => "EDL",
                    "Description" => $this->concepto,
                    "Unit" => "Pieza",
                    "UnitCode" => "H87",
                    "UnitPrice" => (float)number_format($this->dataOrdersFound[$i]['importe'] / $this->dataOrdersFound[$i]['entregar'], 2),
                    /* "Discount" => $this->ordenFound->descuentoFinal, */
                    "Quantity" => $this->dataOrdersFound[$i]['entregar'],
                    "Subtotal" => $this->dataOrdersFound[$i]['importe'],
                    "ObjetoImp" => "02",
                    "TaxObject" => "02",
                    "Taxes" => [
                        [
                            "Total" => 0.0,
                            "Name" => "IVA",
                            "Base" => $this->dataOrdersFound[$i]['importe'],
                            "Rate" => 0,
                            "IsRetention" => false
                        ]
                    ],
                    "Total" => $this->dataOrdersFound[$i]['importe'],
                ]
            );
        }

        $this->globalInformation = [
            "Periodicity" => "01",
            "Months" => Carbon::now()->format('m'),
            "Year" => Carbon::now()->format('Y'),
        ];

        $this->invoice = Invoice::all();

        if ($this->PaymentForm && $this->cfdiUse) {
            $facturama =  \Crisvegadev\Facturama\Invoice::create([
                "Serie" =>  $this->tipoFactura == "PUE" ? 'VPPUESUPUE' : 'VPPPDSUPPD',
                "Currency" => "MXN",
                "ExpeditionPlace" => "58190",
                /* "PaymentConditions" => "CREDITO A SIETE DIAS", */
                "Folio" => count($this->invoice) == 0 ? 1 : count($this->invoice) + 1,
                "CfdiType" => "I",
                "PaymentForm" => $this->PaymentForm,
                "PaymentMethod" => $this->tipoFactura == "PUE" ? "PUE" : "PPD",
                "GlobalInformation" => $this->globalInformation,
                "Date" => Carbon::now()->format('Y-m-d\TH:i:s'),
                "Decimals" => "2",
                "Receiver" => [
                    "Rfc" => $this->activarCG ? $this->rfcGenerico : $this->clienteBarraBuscadora['rfc_input'],
                    "Name" => $this->activarCG ? $this->nombreGenerico : $this->clienteBarraBuscadora['nombre'],
                    "CfdiUse" => $this->cfdiUse,
                    "TaxZipCode" => $this->activarCG ? $this->cpGenerico : $this->address['cp'],
                    "FiscalRegime" => $this->activarCG ? $this->regimenFisGenerico : $this->address['regimen_fiscal'],
                    "email" => $this->clienteBarraBuscadora['email'],
                    "Address" => [
                        "Street" => $this->address['calle'],
                        "ExteriorNumber" => (string) $this->address['noext'],
                        "InteriorNumber" => (string) $this->address['noint'],
                        "Neighborhood" => $this->address['colonia'],
                        "Locality" => $this->address['localidad'],
                        "State" => $this->clienteBarraBuscadora['estado'],
                        "Country" => $this->clienteBarraBuscadora['pais'],
                        "ZipCode" => (string) $this->address['cp'],
                    ]
                ],
                'Items' => $this->data,
            ]);
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Rellena todos los campos!' : ''
            ]);
        }

        try {
            if ($facturama->statusCode === 201) {
                $facturama->data->Date = Carbon::parse($facturama->data->Date)->format('Y-m-d');
                $invoice = new Invoice();
                $invoice->invoice_id = $facturama->data->Id;
                $invoice->invoice_date = $facturama->data->Date;
                $invoice->cliente_id = $this->clienteBarraBuscadora['id'];
                $invoice->cliente = $this->clienteBarraBuscadora['nombre'];
                $invoice->idTipo = $this->tipoFactura == "PUE" ? 'VPPUESUPUE' : 'VPPPDSUPPD';
                $invoice->status = 'Vigente';
                $invoice->serie = $facturama->data->Serie;
                $invoice->folio = $facturama->data->Folio;
                $invoice->paymentTerms = $facturama->data->PaymentTerms;
                $invoice->paymentMethod = $facturama->data->PaymentMethod;
                $invoice->expeditionPlace = $facturama->data->ExpeditionPlace;
                $invoice->currency = $facturama->data->Currency;
                $invoice->fiscalRegime = $facturama->data->Issuer->FiscalRegime;
                $invoice->rfc = $facturama->data->Issuer->Rfc;
                $invoice->productCode = $facturama->data->Items[0]->ProductCode;
                $invoice->unitCode = $facturama->data->Items[0]->UnitCode;
                $invoice->quantity = $facturama->data->Items[0]->Quantity;
                $invoice->unit = $facturama->data->Items[0]->Unit;
                $invoice->description = $facturama->data->Items[0]->Description;
                $invoice->unitValue = $facturama->data->Items[0]->UnitValue;
                $invoice->subtotal = $facturama->data->Subtotal;
                $invoice->discount = $facturama->data->Discount;
                $invoice->total = $facturama->data->Total;
                $invoice->uuid = $facturama->data->Complement->TaxStamp->Uuid;
                $invoice->save();

                $url = 'https://api.facturama.mx/cfdi?cfdiType=issued&cfdiId=';

                $email = '&email=';

                Http::withBasicAuth('LaVozDeMich', 'LAVOZ1270')->post($url . $facturama->data->Id . $email . $this->clienteBarraBuscadora['email']);

                Tiro::whereIn("id", $this->odersSelected)->update([
                    'status' => 'facturado',
                ]);

                $this->status = 'created';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'created') ? '¡Se creo exitosamente la factura!' : ''
                ]);

                return redirect('/vistaPrevia/' . $facturama->data->Id);
            } else {
                $this->d = "";
                $this->odersSelected = [];

                foreach ($facturama->errors as $key => $error) {
                    $this->d .= "- $error \n";
                }

                $this->modalErrors = true;
            }
        } catch (\Exception $e) {
            /* $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Rellena todos los campos!' : ''
            ]); */
        }
    }

    public function render()
    {
        $this->rutas = Ruta::all();

        if ($this->rutaSeleccionada != '') {
            if ($this->tipoFactura == "PUE") {
                $this->ventas = Tiro::join('domicilio', 'domicilio.id', '=', 'tiro.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '!=', 'CREDITO')
                ->where('tiro.status', '!=', 'cancelado')
                ->where('domicilio.ruta_id', $this->rutaSeleccionada)
                ->select('tiro.*', 'ruta.nombreruta')
                ->get();

            $this->suscripciones = Tiro::join('domicilio_subs', 'domicilio_subs.id', '=', 'tiro.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '!=', 'CREDITO')
                ->where('tiro.status', '!=', 'cancelado')
                ->where('domicilio_subs.ruta', $this->rutaSeleccionada)
                ->select('tiro.*', 'ruta.nombreruta')
                ->get();
            } else {
                $this->ventas = Tiro::join('domicilio', 'domicilio.id', '=', 'tiro.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio.ruta_id')
                ->where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '=', 'CREDITO')
                ->where('tiro.status', '!=', 'cancelado')
                ->where('domicilio.ruta_id', $this->rutaSeleccionada)
                ->select('tiro.*', 'ruta.nombreruta')
                ->get();

            $this->suscripciones = Tiro::join('domicilio_subs', 'domicilio_subs.id', '=', 'tiro.domicilio_id')
                ->join('ruta', 'ruta.id', '=', 'domicilio_subs.ruta')
                ->where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '=', 'CREDITO')
                ->where('tiro.status', '!=', 'cancelado')
                ->where('domicilio_subs.ruta', $this->rutaSeleccionada)
                ->select('tiro.*', 'ruta.nombreruta')
                ->get();
            }
        } else {
            if ($this->tipoFactura == "PUE") {
                $this->ventas = Tiro::where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '!=', 'cancelado')
                ->where('tiro.status', '!=', 'CREDITO')
                ->get();
            } else {
                $this->ventas = Tiro::where('tiro.status', '!=', 'facturado')
                ->where('tiro.status', '!=', 'cancelado')
                ->where('tiro.status', '=', 'CREDITO')
                ->get();
            }
        }

        if ($this->activarCG && $this->clienteBarraBuscadora != null) {
            $this->clienteBarraBuscadora['nombre'] = 'PUBLICO EN GENERAL';
            $this->clienteBarraBuscadora['rfc_input'] = 'XAXX010101000';
            /* $this->cfdiUse = 'S01'; */
            $this->clienteBarraBuscadora['regimen_fiscal'] = '616';
            /* $this->PaymentForm = '03'; */
            $this->address['cp'] = '58190';
            $this->rfcGenerico = 'XAXX010101000';
            $this->nombreGenerico = 'PUBLICO EN GENERAL';
            $this->cpGenerico = '58190';
            $this->regimenFisGenerico = '616';
        }

        return view(
            'livewire.invoices.some-invoices',
            [
                'address' => $this->address,
                'orders' => $this->orders,
            ]
        );
    }
}

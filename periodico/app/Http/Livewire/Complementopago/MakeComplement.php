<?php

namespace App\Http\Livewire\Complementopago;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Cliente;
use App\Models\domicilioSubs;
use App\Models\Domicilio;
use App\Models\complemento_pago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MakeComplement extends Component
{
    public $invoice_id, $client, $d, $activarCG, $tipoFactura, $PaymentForm, $invoice, $domicilio, $amountPay, $modalErrors, $complement;

    public $modalAgregar = false, $rfcInput, $cpInput, $colInput, $estadoInput, $noextInput, $nointInput, $regimenfisInput, $razonsInput, $calleInput, $paisInput, $status = 'created';

    public $tipoVenta = '';

    public function mount($id)
    {
        $this->invoice_id = $id;
    }

    public function modalEdit()
    {
        $this->modalAgregar = true;

        $this->rfcInput = $this->client->rfc;
        $this->cpInput = $this->domicilio->cp;
        $this->colInput = $this->domicilio->colonia;
        $this->estadoInput = $this->client->estado;
        $this->noextInput = $this->domicilio->noext;
        $this->nointInput = $this->domicilio->noint;
        $this->regimenfisInput = $this->client->regimen_fiscal;
        $this->razonsInput = $this->client->razon_social;
        $this->calleInput = $this->domicilio->calle;
        $this->paisInput = $this->client->pais;
    }

    public function update()
    {
        $this->client->rfc = $this->rfcInput;
        $this->client->estado = $this->estadoInput;
        $this->client->regimen_fiscal = $this->regimenfisInput;
        $this->client->razon_social = $this->razonsInput;
        $this->client->pais = $this->paisInput;
        $this->client->save();

        $this->domicilio->cp = $this->cpInput;
        $this->domicilio->colonia = $this->colInput;
        $this->domicilio->noext = $this->noextInput;
        $this->domicilio->noint = $this->nointInput;
        $this->domicilio->calle = $this->calleInput;
        $this->domicilio->save();

        $this->modalAgregar = false;

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Datos fiscales actualizados!' : ''
        ]);
    }

    public function complementoDePago()
    {
        if ($this->activarCG) {
            $this->invoice->razon_social = 'PUBLICO EN GENERAL';
            $this->client->rfc_input = 'XAXX010101000';
            $this->client->regimen_fiscal = '616';
            $this->domicilio->cp = '58190';
        }

        $this->complement = complemento_pago::all();

        if ($this->PaymentForm && $this->amountPay && $this->tipoFactura) {
            if ($this->amountPay <= $this->invoice->total) {
                $facturama = \Crisvegadev\Facturama\Invoice::create([
                    "CfdiType" => "P",
                    "NameId" => count($this->complement) == 0 ? 1 : count($this->complement) + 1,
                    "Folio" => count($this->complement) == 0 ? 1 : count($this->complement) + 1,
                    "ExpeditionPlace" => "58190",
                    "Receiver" => [
                        "Rfc" => $this->client->rfc_input,
                        "CfdiUse" => "CP01",
                        "Name" => $this->client->razon_social,
                        "FiscalRegime" => $this->client->regimen_fiscal,
                        "TaxZipCode"  => $this->domicilio->cp,
                    ],
                    "Complemento" => [
                        "Payments" =>  [
                            [
                                "Date" => Carbon::now()->format('Y-m-d'),
                                "PaymentForm" => $this->PaymentForm,
                                "Amount" => $this->amountPay,
                                "RelatedDocuments" => [
                                    [
                                        "TaxObject" => "01",
                                        "Uuid" => $this->invoice->uuid,
                                        "Serie" => substr($this->invoice->idTipo, 0, 5) == 'venta' ? "VPREP" : "SUSREP",
                                        "Folio" => $this->invoice->folio,
                                        "PaymentMethod" => $this->tipoFactura,
                                        "PartialityNumber" => "1",
                                        "PreviousBalanceAmount" => $this->invoice->total,
                                        "AmountPaid" => (float)$this->amountPay,
                                        "ImpSaldoInsoluto" => (float)$this->invoice->total - (float)$this->amountPay,
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

                if ($facturama->statusCode == 201) {
                    $facturama->data->Date = Carbon::parse($facturama->data->Date)->format('Y-m-d');

                    complemento_pago::Create([
                        'invoice_id' => $facturama->data->Id,
                        'invoice_date' => $facturama->data->Date,
                        'cliente_id' => $this->client->id,
                        'paymentForm' => $this->PaymentForm,
                        'fecha_pago' => now()->format('Y-m-d'),
                        'uuid' => $facturama->data->Complement->TaxStamp->Uuid,
                        'status' => 'Activo',
                    ]);

                    $url = 'https://api.facturama.mx/cfdi?cfdiType=issued&cfdiId=';

                    $email = '&email=';

                    Http::withBasicAuth('LaVozDeMich', 'LAVOZ1270')->post($url . $facturama->data->Id . $email . $this->client->email);

                    Invoice::find($this->invoice_id)->update([
                        'total' => (float)$this->invoice->total - (float)$this->amountPay,
                    ]);

                    $this->status = 'created';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Se creo exitosamente la factura!' : ''
                    ]);

                    return redirect('/vistaPreviaComplemento/' . $facturama->data->Id);
                } else {
                    $this->d = "";

                    foreach ($facturama->errors as $key => $error) {
                        $this->d .= "- $error \n";
                    }

                    $this->modalErrors = true;
                }
            } else {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡No puedes colocar una cantidad mayor al monto!' : ''
                ]);
            }
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Debes llenar todos los campos!' : ''
            ]);
        }
    }

    public function render()
    {
        $this->invoice = Invoice::find($this->invoice_id);
        $this->client = Cliente::find($this->invoice->cliente_id);
        if (substr($this->invoice->idTipo, 0, 6) == 'suscri') {
            $this->tipoVenta = 'suscripcion';
            $this->domicilio = domicilioSubs::where('cliente_id', $this->invoice->cliente_id)->first();
        } else {
            $this->tipoVenta = 'venta';
            $this->domicilio = Domicilio::where('cliente_id', $this->invoice->cliente_id)->first();
        }

        if ($this->activarCG) {
            $this->invoice->razon_social = 'PUBLICO EN GENERAL';
            $this->client->rfc_input = 'XAXX010101000';
            $this->client->regimen_fiscal = '616';
            $this->domicilio->cp = '58190';
        }

        return view('livewire.complementopago.make-complement', [
            'invoice' => $this->invoice,
            'domicilio' => $this->domicilio,
            'client' => $this->client
        ]);
    }
}

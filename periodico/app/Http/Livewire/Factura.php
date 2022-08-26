<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\domicilioSubs;
use App\Models\Suscripcion;
use App\Models\Tiro;

class Factura extends Component
{
    public $clienteid, $idTipo, $cliente, $suscripcion, $domicilio, $tipoFactura = '', $paymentMethod, $cfdiUse;

    public function render()
    {
        return view('livewire.factura.view');
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
            /* dd($this->domicilio); */
        } else if (substr($idTipo, 0, 5) == 'venta') {
            dd('venta');
        }
    }

    public function facturar()
    {
        $facturama =  \Crisvegadev\Facturama\Invoice::create([
            "Serie" => "SUSPUE",
            "Currency" => "MXN",
            "ExpeditionPlace" => "78116",
            "PaymentConditions" => "CREDITO A SIETE DIAS",
            "Folio" => "1",
            "CfdiType" => "I",
            "PaymentForm" => "03",
            "PaymentMethod" => "PUE",
            "Receiver" => [
                "Rfc" => "RSS2202108U5",
                "Name" => "RADIAL SOFTWARE SOLUTIONS",
                "CfdiUse" => "P01"
            ],
            "Items" => [
                [
                    "ProductCode" => "10101504",
                    "IdentificationNumber" => "EDL",
                    "Description" => "Estudios de viabilidad",
                    "Unit" => "NO APLICA",
                    "UnitCode" => "MTS",
                    "UnitPrice" => 50.0,
                    "Quantity" => 2.0,
                    "Subtotal" => 100.0,
                    "Taxes" => [
                        [
                            "Total" => 16.0,
                            "Name" => "IVA",
                            "Base" => 100.0,
                            "Rate" => 0.16,
                            "IsRetention" => false
                        ]
                    ],
                    "Total" => 116.0
                ]
            ]
        ]);

    }
}

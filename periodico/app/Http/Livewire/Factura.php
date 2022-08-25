<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use Illuminate\Http\Request;

class Factura extends Component
{
    public $clienteid;
    public $idTipo;
    public $cliente;

    public function render()
    {
        return view('livewire.factura.view');
    }

    public function mount($cliente_id, $idTipo)
    {
        $this->clienteid = $cliente_id;
        $this->idTipo = $idTipo;  

        $this->cliente = Cliente::find($cliente_id);

        /* dd($this->cliente); */
    }

    public function facturar()
    {
        $facturama =  \Crisvegadev\Facturama\Invoice::create([
            "Serie" => "R",
            "Currency" => "MXN",
            "ExpeditionPlace" => "78116",
            "PaymentConditions" => "CREDITO A SIETE DIAS",
            "Folio" => "100",
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
                ],
                [
                    "ProductCode" => "10101504",
                    "IdentificationNumber" => "001",
                    "Description" => "SERVICIO DE COLOCACION",
                    "Unit" => "NO APLICA",
                    "UnitCode" => "E49",
                    "UnitPrice" => 100.0,
                    "Quantity" => 15.0,
                    "Subtotal" => 1500.0,
                    "Discount" => 0.0,
                    "Taxes" => [
                        [
                            "Total" => 240.0,
                            "Name" => "IVA",
                            "Base" => 1500.0,
                            "Rate" => 0.16,
                            "IsRetention" => false
                        ]
                    ],
                    "Total" => 1740.0
                ]
            ]
        ]);
    }
}

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
            "Serie" => "VPPUE",
            "Currency" => "MXN",
            "ExpeditionPlace" => "58190",
            "PaymentConditions" => "CREDITO A SIETE DIAS",
            "Folio" => "1",
            "CfdiType" => "I",
            "PaymentForm" => "03",
            "PaymentMethod" => "PUE",
            "GlobalInformation" => [
                "Periodicity" => "04",
                "Months" => "08",
                "Year" => "2022",
            ],
            "Decimals" => "2",
            "Receiver" => [
                "Rfc" => "XAXX010101000",
                "Name" => "PUBLICO EN GENERAL",
                "CfdiUse" => "S01",
                "TaxZipCode" => "58190",
                "FiscalRegime" => "616",
                "Address" => [
                    "Street" => "CALLE",
                    "ExteriorNumber" => "1",
                    "InteriorNumber" => "",
                    "Neighborhood" => "OBRERA",
                    "Locality" => "MORELIA",
                    "State" => "MICHOACAN",
                    "Country" => "MEXICO",
                    "ZipCode" => "58190"
                ]
            ],
            "Items" => [
                [
                    "Serie" => "VPPUE",
                    "ProductCode" => "55101504",
                    "IdentificationNumber" => "EDL",
                    "Description" => "VENTA PERIÓDICO FACTURA GLOBAL",
                    "Unit" => "Pieza",
                    "UnitCode" => "H87",
                    "UnitPrice" => 12.0,
                    "Quantity" => 1,
                    "Subtotal" => 12.0,
                    "ObjetoImp" => "02",
                    "TaxObject" => "02",
                    "Taxes" => [
                        [
                            "Total" => 0.0,
                            "Name" => "IVA",
                            "Base" => 12.0,
                            "Rate" => 0,
                            "IsRetention" => false
                        ]
                    ],
                    "Total" => 12.0
                ]
            ],
        ]);
        dd($facturama);
    }
}

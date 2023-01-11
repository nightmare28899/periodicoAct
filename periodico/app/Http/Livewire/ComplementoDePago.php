<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Invoice;
use App\Models\Domicilio;
use App\Models\complemento_pago;
use Carbon\Carbon;

class ComplementoDePago extends Component
{
    public $uuid, $folio, $paymentMethod, $PreviousBalanceAmount, $AmountPaid, $ImpSaldoInsoluto, $moneda = '(MXN) Peso Mexicano', $clienteSeleccionado, $invoices = [], $rfcCliente, $nameCliente, $fiscalRegime, $codigoPostalFiscal, $d, $modalErrors = 0, $activarCG = false, $facturaSeleccionada, $invoicesId = [], $montoIngresado, $montosIngresados = [], $forma_pago, $invoicesAdds = [], $status = 'created', $relatedDocuments = [], $date, $fecha, $clientesBuscados, $rfcGenerico, $nombreGenerico, $cpGenerico, $regimenFisGenerico, $query;

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
    }

    public function selectContact($pos)
    {
        $this->clienteSeleccionado = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteSeleccionado) {
            $this->clienteSeleccionado;

            $idCliente = $this->clienteSeleccionado['id'];
            $this->invoices = Invoice::where('cliente_id', '=', $idCliente)->get();
            $this->rfcCliente = $this->clienteSeleccionado['rfc'];
            $this->nameCliente = $this->clienteSeleccionado['nombre'];
            $this->fiscalRegime = $this->clienteSeleccionado['regimen_fiscal'];
            $domicilio = Domicilio::where('cliente_id', '=', $idCliente)->get();
            if (count($domicilio) > 0) {
                $this->codigoPostalFiscal = $domicilio[0]['cp'];

                if (count($this->invoices) > 0) {
                    $this->status = 'created';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Si tiene facturas!' : ''
                    ]);
                } else {
                    $this->status = 'error';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'error') ? '¡No tiene facturas!' : ''
                    ]);
                }
            } else {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡No tiene domicilio!' : ''
                ]);
            }
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        $this->clientesBuscados = Cliente
            ::where('id', '=',  $this->query)
            ->orWhere('nombre', 'like', '%' . $this->query . '%')
            ->limit(6)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->date = Carbon::now()->format('Y-m-d\TH:i:s');
        if ($this->activarCG) {
            /* $this->cfdiUse = 'S01'; */
            /* $this->PaymentForm = '03'; */
            $this->rfcGenerico = 'XAXX010101000';
            $this->nombreGenerico = 'PUBLICO EN GENERAL';
            $this->cpGenerico = '58190';
            $this->regimenFisGenerico = '616';
        }

        return view('livewire.complemento-de-pago', [
            'invoices' => $this->invoices,
        ]);
    }

    public function addFactura()
    {
        if ($this->montoIngresado) {
            if ($this->facturaSeleccionada && count($this->invoicesId) > 0) {
                foreach ($this->invoicesId as $key => $value) {
                    if ($value['id'] == $this->facturaSeleccionada) {
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'created') ? '¡No puedes escoger la misma factura!' : ''
                        ]);
                        break;
                    }
                }
                if ($value['id'] != $this->facturaSeleccionada) {
                    array_push($this->invoicesId, Invoice::where('id', '=', $this->facturaSeleccionada)
                        ->first()
                        ->toArray());
                    array_push($this->montosIngresados, $this->montoIngresado);
                    $this->facturaSeleccionada = '';
                    $this->montoIngresado = '';
                }
            } else {
                array_push($this->invoicesId, Invoice::where('id', '=', $this->facturaSeleccionada)
                    ->first()
                    ->toArray());

                array_push($this->montosIngresados, $this->montoIngresado);
                /* for ($i = 0; $i < count($this->invoicesId); $i++) {

                    if ($this->montoIngresado <= $this->invoicesId[$i]['total']) {
                        array_push($this->montosIngresados, $this->montoIngresado);
                    } else {
                        $this->status = 'error';
                        $this->dispatchBrowserEvent('alert', [
                            'message' => ($this->status == 'created') ? '¡El monto ingresado es mayor al total de la factura!' : ''
                        ]);
                    }
                } */

                $this->fecha = '';
                /* $this->montosIngresados = []; */
                $this->facturaSeleccionada = '';
                $this->montoIngresado = '';
                $this->forma_pago = '';
            }
        } else {
            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡No dejes los campos vacios!' : ''
            ]);
        }
    }

    public function remover($id)
    {
        $this->montoIngresado = '';

        foreach ($this->invoicesId as $key => $value) {
            if ($value['id'] == $id) {
                unset($this->invoicesId[$key]);
                unset($this->montosIngresados[$key]);
            }
        }
    }

    public function complementoDePago()
    {
        if (/* $this->invoicesId && */ $this->forma_pago && $this->fecha) {
            $sum = 0;
            $sumPrevious = 0;
            for ($i = 0; $i < count($this->invoicesId); $i++) {
                $sum += $this->montosIngresados[$i];
                $sumPrevious += $this->invoicesId[$i]['total'];
                $insoluto = ($this->invoicesId[$i]['total'] - $this->montosIngresados[$i]);
                array_push(
                    $this->relatedDocuments,
                    [
                        "TaxObject" => "01",
                        "Uuid" => $this->invoicesId[$i]['uuid'],
                        "Serie" => $this->invoicesId[$i]['serie'],
                        "Currency" => "MXN",
                        "Folio" => $i + 1,
                        "PaymentMethod" => "PPD",
                        "PartialityNumber" => "1",
                        "PreviousBalanceAmount" => $this->invoicesId[$i]['total'], //25.00,
                        "AmountPaid" => $this->montosIngresados[$i], //50
                        "ImpSaldoInsoluto" => ($this->invoicesId[$i]['total'] - $this->montosIngresados[$i]),
                    ]
                );
            }

            $facturama =  \Crisvegadev\Facturama\Invoice::create([
                "CfdiType" => "P", // normal //abono
                "NameId" => "14",
                "Folio" => "93",
                "ExpeditionPlace" => "58190",
                "Receiver" => [
                    "Rfc" => $this->activarCG ? $this->rfcGenerico : $this->rfcCliente,
                    "CfdiUse" => "CP01",
                    "Name" => $this->activarCG ? $this->nombreGenerico : $this->nameCliente,
                    "FiscalRegime" => $this->activarCG ? $this->regimenFisGenerico : $this->fiscalRegime,
                    "TaxZipCode" => $this->activarCG ? $this->cpGenerico : $this->codigoPostalFiscal,
                ],
                "Complemento" => [
                    "Payments" =>  [
                        [
                            "Date" => $this->date,
                            "PaymentForm" => $this->forma_pago,
                            "Amount" => $sum, //25.00,
                            "Currency" => "MXN",
                            "RelatedDocuments" => $this->relatedDocuments //PPD original
                        ]
                    ]
                ]
            ]);

            /* dd($facturama); */


            /* try { */
            if ($facturama->statusCode == 201) {
                $facturama->data->Date = Carbon::parse($facturama->data->Date)->format('Y-m-d');

                complemento_pago::Create([
                    'invoice_id' => $facturama->data->Id,
                    'invoice_date' => $facturama->data->Date,
                    'cliente_id' => $this->clienteSeleccionado['id'],
                    'paymentForm' => $this->forma_pago,
                    'fecha_pago' => $this->fecha,
                    'uuid' => $facturama->data->Complement->TaxStamp->Uuid,
                    'status' => 'Activo',
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
            /* } catch (\Exception $e) {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡Rellena todos los campos!' : ''
                ]);
            } */
        } else {
            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡No dejes los campos vacios!' : ''
            ]);
        }
    }
}

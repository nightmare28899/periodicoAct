<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Invoice;
use App\Models\Cliente;

class VistaFacturaPPD extends Component
{
    public $facturama, $idFactura, $motivo, $tiro, $invoice, $status;

    public function render()
    {
        $this->invoice = Invoice::all();
        return view('livewire.vista-factura-p-p-d', ['facturama' => $this->facturama]);
    }

    public function reenviar()
    {
        $invoiceFound = Invoice::where('invoice_id', $this->idFactura)->first();
        $clienteFound = Cliente::where('id', $invoiceFound->cliente_id)->first();
        if ($clienteFound) {
            $url = 'https://api.facturama.mx/cfdi?cfdiType=issued&cfdiId=';

            $email = '&email=';

            Http::withBasicAuth('LaVozDeMich', 'LAVOZ1270')->post($url . $this->idFactura . $email . $clienteFound->email);

            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Factura reenviada!' : ''
            ]);
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Hubo un error!' : ''
            ]);
        }
    }

    public function mount($id)
    {
        $this->idFactura = $id;
        $this->facturama = \Crisvegadev\Facturama\Invoice::streamFile('pdf', 'issued', $id);
        Storage::disk('public')->put('complemento.pdf', base64_decode($this->facturama->data->Content));
        $this->facturama = Storage::url('complemento.pdf');
    }
}

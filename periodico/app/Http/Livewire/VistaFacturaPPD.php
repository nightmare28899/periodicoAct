<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Invoice;

class VistaFacturaPPD extends Component
{
    public $facturama, $idFactura, $motivo, $tiro, $invoice;

    public function render()
    {
        $this->invoice = Invoice::all();
        return view('livewire.vista-factura-p-p-d', ['facturama' => $this->facturama]);
    }

    public function mount($id)
    {
        $this->idFactura = $id;
        $this->facturama = \Crisvegadev\Facturama\Invoice::streamFile('pdf', 'issued', $id);
        Storage::disk('public')->put('complemento.pdf', base64_decode($this->facturama->data->Content));
        $this->facturama = Storage::url('complemento.pdf');
    }
}

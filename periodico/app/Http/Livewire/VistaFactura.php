<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class VistaFactura extends Component
{
    public $facturama, $idFactura, $motivo, $tiro, $invoice;

    public function render()
    {
        return view('livewire.factura.vista-factura', ['facturama' => $this->facturama]);
    }

    public function mount($id)
    {
        $this->idFactura = $id;
        $this->facturama = \Crisvegadev\Facturama\Invoice::streamFile('pdf', 'issued', $id);
        Storage::disk('public')->put('file.pdf', base64_decode($this->facturama->data->Content));
        $this->facturama = Storage::url('file.pdf');
    }
}

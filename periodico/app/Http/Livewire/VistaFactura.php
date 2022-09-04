<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Tiro;
use App\Models\Invoice;

class VistaFactura extends Component
{
    public $facturama, $idFactura, $motivo, $tiro, $invoice;

    public function render()
    {
        $this->invoice = Invoice::all();
        return view('livewire.factura.vista-factura', ['facturama' => $this->facturama]);
    }

    public function mount($id)
    {
        $this->idFactura = $id;
        $this->facturama = \Crisvegadev\Facturama\Invoice::streamFile('pdf', 'issued', $id);
        Storage::disk('public')->put('file.pdf', base64_decode($this->facturama->data->Content));
        $this->facturama = Storage::url('file.pdf');

    }

    public function cancelar()
    {
        $this->facturama =  \Crisvegadev\Facturama\Invoice::cancel($this->idFactura, 'issued', $this->motivo);
        $this->tiro = Tiro::where('cliente_id', $this->invoice[0]['cliente_id'])->update([
            'status' => 'cancelado',
        ]);

        return redirect('/tiro/');
    }
}

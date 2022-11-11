<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\complemento_pago;

class CancelarFacturaComplemento extends Component
{
    public $motivo = '', $complemento, $invoice, $idFactura = '', $status = 'created', $idCliente;
    private $facturama;

    public function render()
    {
        return view('livewire.cancelar-factura-complemento', ['facturama' => $this->facturama]);
    }

    public function mount($id, $idCliente)
    {
        $this->idCliente = $idCliente;
        $this->idFactura = $id;
        $this->facturama = \Crisvegadev\Facturama\Invoice::streamFile('pdf', 'issued', $id);
        Storage::disk('public')->put('complemento.pdf', base64_decode($this->facturama->data->Content));
        $this->facturama = Storage::url('complemento.pdf');

    }

    public function cancelar()
    {
        if ($this->motivo) {
            $this->facturama =  \Crisvegadev\Facturama\Invoice::cancel($this->idFactura, 'issued', $this->motivo);
            $this->complemento = complemento_pago::where('cliente_id', $this->idCliente)->update([
                'status' => 'cancelado',
            ]);

            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Se cancelo la factura!' : ''
            ]);

            return redirect('/historialComplementoPago');
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Primero escoge el motivo!' : ''
            ]);
        }
    }
}

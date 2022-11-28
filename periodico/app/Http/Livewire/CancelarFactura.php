<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use App\Models\Tiro;
use App\Models\Invoice;
use Carbon\Carbon;
use Livewire\Component;

class CancelarFactura extends Component
{
    public $motivo = '', $tiro, $invoice, $idFactura = '', $status = 'created', $date;
    private $facturama;

    public function render()
    {
        $this->date = new Carbon();

        $this->idFactura;
        $this->invoice = Invoice::all();
        return view('livewire.factura.cancelar-factura', ['facturama' => $this->facturama]);
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
        if ($this->motivo) {
            $this->facturama =  \Crisvegadev\Facturama\Invoice::cancel($this->idFactura, 'issued', $this->motivo);
            $this->tiro = Tiro::where('cliente_id', $this->invoice[0]['cliente_id'])->update([
                'status' => 'cancelado',
            ]);
            $this->invoice = Invoice::where('invoice_id', $this->idFactura)->update([
                'status' => 'cancelada',
                'invoice_date' => $this->date->format('Y-m-d'),
            ]);

            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Se cancelo la factura!' : ''
            ]);

            return redirect('/historialF');
        } else {
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Primero escoge el motivo!' : ''
            ]);
        }
    }
}

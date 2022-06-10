<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ruta;

class Rutas extends Component
{
    use WithPagination;

    public $Rutas, $keyWord, $nombre, $tipo, $repartidor, $cobrador, $ctaespecial, $ruta_id, $status = 'created';
    public $isModalOpen = 0;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        /* $this->Rutas = Rutas::all(); */
        return view('livewire.rutas.view', [
            'rutas' => Ruta::latest()
                ->orWhere('nombre', 'LIKE', $keyWord)
                ->orWhere('tipo', 'LIKE', $keyWord)
                ->orWhere('repartidor', 'LIKE', $keyWord)
                ->orWhere('cobrador', 'LIKE', $keyWord)
                ->orWhere('ctaespecial', 'LIKE', $keyWord)
                ->paginate(10),
        ]);
    }
    public function create()
    {
        $this->resetInput();
        $this->openModalPopover();
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }
    private function resetInput()
    {
        $this->nombre = '';
        $this->tipo = '';
        $this->repartidor = '';
        $this->cobrador = '';
        $this->ctaespecial = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'repartidor' => 'required',
            'cobrador' => 'required',
        ]);

        Ruta::updateOrCreate(['id' => $this->ruta_id], [
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'repartidor' => $this->repartidor,
            'cobrador' => $this->cobrador,
            'ctaespecial' => $this->ctaespecial,
        ]);
        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->updateMode = false;
        $this->closeModalPopover();
    }
    public function edit($id)
    {
        $Ruta = Ruta::findOrFail($id);
        $this->ruta_id = $id;
        $this->nombre = $Ruta->nombre;
        $this->tipo = $Ruta->tipo;
        $this->repartidor = $Ruta->repartidor;
        $this->cobrador = $Ruta->cobrador;
        $this->ctaespecial = $Ruta->ctaespecial;
        $this->updateMode = true;
        $this->openModalPopover();

        $this->status = 'updated';
    }
    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Ruta Creada Correctamente!' : '¡Ruta Actualizada Correctamente!'
        ]);
    }
    public function delete($id)
    {
        Ruta::find($id)->delete();
        session()->flash('message', '¡Ruta Eliminada!.');
    }
}

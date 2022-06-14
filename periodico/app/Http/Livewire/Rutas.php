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

    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

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
        $this->showModal();
        $this->status = 'created';
    }
    /* public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    } */
    public function showModal()
    {
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
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

        Ruta::Create([
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'repartidor' => $this->repartidor,
            'cobrador' => $this->cobrador,
            'ctaespecial' => $this->ctaespecial,
        ]);
        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->hideModal();
    }
    public function edit($id)
    {
        $Ruta = Ruta::find($id);
        $this->ruta_id = $id;
        $this->nombre = $Ruta->nombre;
        $this->tipo = $Ruta->tipo;
        $this->repartidor = $Ruta->repartidor;
        $this->cobrador = $Ruta->cobrador;
        $this->ctaespecial = $Ruta->ctaespecial;

        $this->status = 'updated';
        $this->showModal();
    }
    public function update()
    {
        $this->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'repartidor' => 'required',
            'cobrador' => 'required',
        ]);

        $Ruta = Ruta::find($this->ruta_id);
        $Ruta->update([
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'repartidor' => $this->repartidor,
            'cobrador' => $this->cobrador,
            'ctaespecial' => $this->ctaespecial,
        ]);

        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->hideModal();
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

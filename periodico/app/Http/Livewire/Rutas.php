<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ruta;

class Rutas extends Component
{
    use WithPagination;

    public $Rutas, $keyWord, $nombreruta, $tiporuta, $repartidor, $cobrador, $ctaespecial, $ruta_id, $status = 'created', $isModalOpen = 0, $updateMode = false, $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.rutas.view', [
            'rutas' => Ruta::Where('nombreruta', 'LIKE', $keyWord)
                ->orWhere('tiporuta', 'LIKE', $keyWord)
                ->orWhere('id', 'LIKE', $keyWord)
                ->paginate(10),
        ]);
    }
    public function create()
    {
        $this->resetInput();
        $this->openModalPopover();
        $this->status = 'created';
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
        $this->nombreruta = '';
        $this->tiporuta = '';
        $this->repartidor = '';
        $this->cobrador = '';
        $this->ctaespecial = '';
    }

    public function store()
    {
        $this->validate([
            'nombreruta' => 'required',
            'tiporuta' => 'required',
            'repartidor' => 'required',
            'cobrador' => 'required',
        ]);

        Ruta::Create([
            'nombreruta' => $this->nombreruta,
            'tiporuta' => $this->tiporuta,
            'repartidor' => $this->repartidor,
            'cobrador' => $this->cobrador,
            'ctaespecial' => $this->ctaespecial,
        ]);
        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->closeModalPopover();
    }
    public function edit($id)
    {
        $Ruta = Ruta::find($id);
        $this->ruta_id = $id;
        $this->nombreruta = $Ruta->nombreruta;
        $this->tiporuta = $Ruta->tiporuta;
        $this->repartidor = $Ruta->repartidor;
        $this->cobrador = $Ruta->cobrador;
        $this->ctaespecial = $Ruta->ctaespecial;

        $this->status = 'updated';
        $this->openModalPopover();
    }
    public function update()
    {
        $this->validate([
            'nombreruta' => 'required',
            'tiporuta' => 'required',
            'repartidor' => 'required',
            'cobrador' => 'required',
        ]);

        $Ruta = Ruta::find($this->ruta_id);
        $Ruta->update([
            'nombreruta' => $this->nombreruta,
            'tiporuta' => $this->tiporuta,
            'repartidor' => $this->repartidor,
            'cobrador' => $this->cobrador,
            'ctaespecial' => $this->ctaespecial,
        ]);

        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->closeModalPopover();
    }
    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Ruta creada correctamente!' : '¡Ruta actualizada correctamente!'
        ]);
    }
    public function delete($id)
    {
        Ruta::find($id)->delete();
        session()->flash('message', '¡Ruta Eliminada!.');
    }
}

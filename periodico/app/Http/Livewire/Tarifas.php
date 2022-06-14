<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tarifa;

class Tarifas extends Component
{
    use WithPagination;


    public $Tarifas, $keyWord, $tipo, $ordinario, $dominical, $tarifa_id, $status = 'created';
    public $isModalOpen = 0;
    public $updateMode = false;

    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        /* $this->Tarifas = Tarifa::all(); */
        return view('livewire.tarifas.view', [
            'tarifas' => Tarifa::latest()
                ->orWhere('tipo', 'LIKE', $keyWord)
                ->orWhere('ordinario', 'LIKE', $keyWord)
                ->orWhere('dominical', 'LIKE', $keyWord)
                ->orWhere('created_at', 'LIKE', $keyWord)
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
        $this->tipo = '';
        $this->ordinario = '';
        $this->dominical = '';
    }

    public function store()
    {
        $this->validate([
            'tipo' => 'required',
            'ordinario' => 'required',
            'dominical' => 'required',
        ]);

        Tarifa::Create([
            'tipo' => $this->tipo,
            'ordinario' => $this->ordinario,
            'dominical' => $this->dominical,
        ]);
        /* session()->flash('message', $this->tarifa_id ? '¡Tarifa Actualizado!.' : '¡Tarifa Creado!.'); */
        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->closeModalPopover();
    }
    public function edit($id)
    {
        $Tarifa = Tarifa::find($id);
        $this->tarifa_id = $id;
        $this->tipo = $Tarifa->tipo;
        $this->ordinario = $Tarifa->ordinario;
        $this->dominical = $Tarifa->dominical;
        $this->updateMode = true;

        $this->status = 'updated';
        $this->openModalPopover();
    }
    public function update()
    {
        $this->validate([
            'tipo' => 'required',
            'ordinario' => 'required',
            'dominical' => 'required',
        ]);

        $Tarifa = Tarifa::find($this->tarifa_id);
        $Tarifa->update([
            'tipo' => $this->tipo,
            'ordinario' => $this->ordinario,
            'dominical' => $this->dominical,
        ]);

        $this->toast();
        $this->resetInput();
        $this->emit('closeModal');
        $this->closeModalPopover();
    }
    public function toast()
    {
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Tarifa Creada Correctamente!' : '¡Tarifa Actualizada Correctamente!'
        ]);
    }
    public function delete($id)
    {
        Tarifa::find($id)->delete();
        session()->flash('message', '¡Tarifa Eliminada!.');
    }
}

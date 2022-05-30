<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use App\Models\Domicilio;
use App\Models\Ejemplar;
use App\Models\Ruta;
use App\Models\Tarifa;

class Clientes extends Component
{
    use WithPagination;

    public $Clientes, $keyWord, $clasificacion, $rfc, $rfc_input, $nombre, $estado, $pais, $email, $email_cobranza, $telefono, $regimen_fiscal, $cliente_id;

    public $Domicilios, $calle, $noint, $noext, $colonia, $cp, $localidad, $municipio, $ruta_id, $tarifa_id, $referencia, $domicilio_id;

    public $Ejemplares, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo,  $ejemplar_id;

    public $isModalOpen = 0;
    public $clienteModalOpen = 0;
    public $ejemplarModalOpen = 0;
    public $detallesModalOpen = 0;

    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $data = [
            'Gobierno' => 'GOBIERNO',
            'T/O' => 'T/O',
            'Genérico' => 'GENÉRICO',
            'Libre' => 'LIBRE',
            'Municipio' => 'MUNICIPIO',
            'S-A' => 'S-A',
            'T-E' => 'T-E',
            'Sanborn' => 'SANBORN',
        ];
        $rutas = Ruta::pluck('id', 'id');
        $tarifas = Tarifa::pluck('id', 'id');
        /* $this->Clientes = Cliente::all(); */
        return view('livewire.clientes.view', [
            'clientes' => Cliente::latest()
                ->orWhere('clasificacion', 'LIKE', $keyWord)
                ->orWhere('rfc', 'LIKE', $keyWord)
                ->orWhere('rfc_input', 'LIKE', $keyWord)
                ->orWhere('nombre', 'LIKE', $keyWord)
                ->orWhere('estado', 'LIKE', $keyWord)
                ->orWhere('pais', 'LIKE', $keyWord)
                ->orWhere('email', 'LIKE', $keyWord)
                ->orWhere('email_cobranza', 'LIKE', $keyWord)
                ->orWhere('telefono', 'LIKE', $keyWord)
                ->orWhere('regimen_fiscal', 'LIKE', $keyWord)
                ->paginate(15),
            'domicilios' => Domicilio::latest()
                ->orWhere('calle', 'LIKE', $keyWord)
                ->orWhere('noint', 'LIKE', $keyWord)
                ->orWhere('noext', 'LIKE', $keyWord)
                ->orWhere('colonia', 'LIKE', $keyWord)
                ->orWhere('cp', 'LIKE', $keyWord)
                ->orWhere('localidad', 'LIKE', $keyWord)
                ->orWhere('municipio', 'LIKE', $keyWord)
                ->orWhere('referencia', 'LIKE', $keyWord)
                ->paginate(15),
            'ejemplares' => Ejemplar::latest()
                ->orWhere('lunes', 'LIKE', $keyWord)
                ->orWhere('martes', 'LIKE', $keyWord)
                ->orWhere('miercoles', 'LIKE', $keyWord)
                ->orWhere('jueves', 'LIKE', $keyWord)
                ->orWhere('viernes', 'LIKE', $keyWord)
                ->orWhere('sabado', 'LIKE', $keyWord)
                ->orWhere('domingo', 'LIKE', $keyWord)
                ->paginate(15),
        ], compact('data', 'rutas', 'tarifas'));
    }
    public function create()
    {
        /* $this->resetInput(); */
        $this->openModalPopover();
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
        $this->clienteModalOpen = false;
        $this->ejemplarModalOpen = false;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
        $this->clienteModalOpen = false;
        $this->ejemplarModalOpen = false;
        $this->resetInput();
    }
    public function openClientModal()
    {
        $this->isModalOpen = false;
        /*    $this->resetInput(); */
        $this->ejemplarModalOpen = false;
        $this->clienteModalOpen = true;
    }
    public function closeClientModal()
    {
        $this->clienteModalOpen = false;
    }
    public function openEjemplarModal()
    {
        $this->isModalOpen = false;
        $this->clienteModalOpen = false;
        $this->ejemplarModalOpen = true;
    }
    public function closeEjemplarModal()
    {
        $this->ejemplarModalOpen = false;
    }
    public function openModalAnterior()
    {
        $this->isModalOpen = false;
        $this->clienteModalOpen = true;
        $this->ejemplarModalOpen = false;
    }
    public function detalles($id)
    {
        $Cliente = Cliente::findOrFail($id);
        $this->cliente_id = $id;
        $this->clasificacion = $Cliente->clasificacion;
        $this->rfc = $Cliente->rfc;
        $this->rfc_input = $Cliente->rfc_input;
        $this->nombre = $Cliente->nombre;
        $this->estado = $Cliente->estado;
        $this->pais = $Cliente->pais;
        $this->email = $Cliente->email;
        $this->email_cobranza = $Cliente->email_cobranza;
        $this->telefono = $Cliente->telefono;
        $this->regimen_fiscal = $Cliente->regimen_fiscal;

        $Domicilio = Domicilio::findOrFail($id);
        $this->domicilio_id = $Domicilio->id;
        $this->calle = $Domicilio->calle;
        $this->noint = $Domicilio->noint;
        $this->noext = $Domicilio->noext;
        $this->colonia = $Domicilio->colonia;
        $this->cp = $Domicilio->cp;
        $this->localidad = $Domicilio->localidad;
        $this->municipio = $Domicilio->municipio;
        $this->referencia = $Domicilio->referencia;
        $this->ruta_id = $Domicilio->ruta_id;
        $this->tarifa_id = $Domicilio->tarifa_id;

        $Ejemplar = Ejemplar::findOrFail($id);
        $this->ejemplar_id = $Ejemplar->id;
        $this->lunes = $Ejemplar->lunes;
        $this->martes = $Ejemplar->martes;
        $this->miercoles = $Ejemplar->miercoles;
        $this->jueves = $Ejemplar->jueves;
        $this->viernes = $Ejemplar->viernes;
        $this->sabado = $Ejemplar->sabado;
        $this->domingo = $Ejemplar->domingo;

        $this->detallesModalOpen = true;
    }
    public function closeDetallesModal()
    {
        $this->detallesModalOpen = false;
    }
    private function resetInput()
    {
        $this->clasificacion = '';
        $this->rfc = '';
        $this->rfc_input = '';
        $this->nombre = '';
        $this->estado = '';
        $this->pais = '';
        $this->email = '';
        $this->email_cobranza = '';
        $this->telefono = '';
        $this->regimen_fiscal = '';

        $this->calle = '';
        $this->noint = '';
        $this->noext = '';
        $this->colonia = '';
        $this->cp = '';
        $this->localidad = '';
        $this->municipio = '';
        $this->referencia = '';
        $this->ruta_id = '';
        $this->tarifa_id = '';

        $this->lunes = '';
        $this->martes = '';
        $this->miercoles = '';
        $this->jueves = '';
        $this->viernes = '';
        $this->sabado = '';
        $this->domingo = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'pais' => 'required',
            'regimen_fiscal' => 'required',

            'calle' => 'required',
            'noext' => 'required',
            'colonia' => 'required',
            'cp' => 'required',
            'localidad' => 'required',
            'municipio' => 'required',
            'referencia' => 'required',
            'ruta_id' => 'required',
            'tarifa_id' => 'required',
            'clasificacion' => 'required',
            'rfc' => 'required',
            'rfc_input' => 'required',

            'lunes' => 'required',
            'martes' => 'required',
            'miercoles' => 'required',
            'jueves' => 'required',
            'viernes' => 'required',
            'sabado' => 'required',
            'domingo' => 'required',
        ]);

        Cliente::updateOrCreate(['id' => $this->cliente_id], [
            'clasificacion' => $this->clasificacion,
            'rfc' => $this->rfc,
            'rfc_input' => $this->rfc_input,
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'pais' => $this->pais,
            'email' => $this->email,
            'email_cobranza' => $this->email_cobranza,
            'telefono' => $this->telefono,
            'regimen_fiscal' => $this->regimen_fiscal
        ]);


        Domicilio::updateOrCreate(['id' => $this->domicilio_id], [
            'cliente_id' => $this->cliente_id = Cliente::where('nombre', $this->nombre)->first()->id,
            'calle' => $this->calle,
            'noint' => $this->noint,
            'noext' => $this->noext,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'ruta_id' => $this->ruta_id,
            'tarifa_id' => $this->tarifa_id,
            'referencia' => $this->referencia,
        ]);

        Ejemplar::updateOrCreate(['id' => $this->ejemplar_id], [
            'cliente_id' => $this->cliente_id = Cliente::where('nombre', $this->nombre)->first()->id,
            'lunes' => $this->lunes,
            'martes' => $this->martes,
            'miercoles' => $this->miercoles,
            'jueves' => $this->jueves,
            'viernes' => $this->viernes,
            'sabado' => $this->sabado,
            'domingo' => $this->domingo,
        ]);

        session()->flash('message', $this->cliente_id ? '¡Cliente Actualizado!.' : '¡Cliente Creado!.');
        $this->resetInput();
        $this->emit('closeModal');
        $this->updateMode = false;
        $this->closeModalPopover();
        $this->clienteModalOpen = false;
    }
    public function edit($id)
    {
        $Cliente = Cliente::findOrFail($id);
        $this->cliente_id = $id;
        $this->clasificacion = $Cliente->clasificacion;
        $this->rfc = $Cliente->rfc;
        $this->rfc_input = $Cliente->rfc_input;
        $this->nombre = $Cliente->nombre;
        $this->estado = $Cliente->estado;
        $this->pais = $Cliente->pais;
        $this->email = $Cliente->email;
        $this->email_cobranza = $Cliente->email_cobranza;
        $this->telefono = $Cliente->telefono;
        $this->regimen_fiscal = $Cliente->regimen_fiscal;

        $Domicilio = Domicilio::findOrFail($id);
        $this->domicilio_id = $Domicilio->id;
        $this->calle = $Domicilio->calle;
        $this->noint = $Domicilio->noint;
        $this->noext = $Domicilio->noext;
        $this->colonia = $Domicilio->colonia;
        $this->cp = $Domicilio->cp;
        $this->localidad = $Domicilio->localidad;
        $this->municipio = $Domicilio->municipio;
        $this->referencia = $Domicilio->referencia;
        $this->ruta_id = $Domicilio->ruta_id;
        $this->tarifa_id = $Domicilio->tarifa_id;

        $Ejemplar = Ejemplar::findOrFail($id);
        $this->ejemplar_id = $Ejemplar->id;
        $this->lunes = $Ejemplar->lunes;
        $this->martes = $Ejemplar->martes;
        $this->miercoles = $Ejemplar->miercoles;
        $this->jueves = $Ejemplar->jueves;
        $this->viernes = $Ejemplar->viernes;
        $this->sabado = $Ejemplar->sabado;
        $this->domingo = $Ejemplar->domingo;

        $this->updateMode = true;
        $this->openModalPopover();
    }

    public function delete($id)
    {
        Cliente::find($id)->delete();
        session()->flash('message', 'Cliente Eliminado!.');
    }
}

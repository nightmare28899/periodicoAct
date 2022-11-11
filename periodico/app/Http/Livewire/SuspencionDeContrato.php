<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Suscripcion;
use App\Models\SuscripcionSupendida;
use Carbon\Carbon;
use DateTime;

class SuspencionDeContrato extends Component
{
    public $suscripcionBuscada = [], $incremento = 'aumentar', $dias, $date, $del, $al, $reponerDias = null, $radioOptions = 'reponer', $fechaReposicion, $motivo, $estado = false, $status = 'created';

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->suscripcionBuscada = [];
    }

    public function render()
    {
        if ($this->query != '') {
            $this->suscripcionBuscada = Suscripcion
                ::join("cliente", "cliente.id", "=", "suscripciones.cliente_id")
                ->where("suscripciones.id", $this->query)
                ->orWhere("cliente.nombre", "like", "%" . $this->query . "%")
                ->select('suscripciones.*', 'cliente.nombre', 'cliente.razon_social')
                ->get();
        } else if ($this->query == '') {
            $this->suscripcionBuscada = [];
        }

        if ($this->radioOptions == 'indicar') {
            $this->estado = true;
        } else {
            $this->estado = false;
        }

        return view('livewire.suspencion-de-contrato', [
            'suscripciones' => $this->suscripcionBuscada,
        ]);
    }

    public function suspender()
    {

        $this->validate([
            'del' => 'required',
            'al' => 'required',
            'motivo' => 'required',
            'radioOptions' => 'required',
            'reponerDias' => 'required',
            'motivo' => 'required',
        ]);

        if ($this->del != null && $this->al != null && $this->motivo != null && $this->reponerDias != null && $this->suscripcionBuscada != null) {
            $suspendida = SuscripcionSupendida::where('idsus', $this->suscripcionBuscada[0]->id)->get();

            if (count($suspendida) == 0) {

                if ($this->radioOptions == 'reponer') {

                    $sus = Suscripcion::find($this->suscripcionBuscada[0]->id);
                    $date1 = new Carbon($this->del);
                    $date2 = new Carbon($this->al);
                    $date = date_diff($date1, $date2)->format('%a');
                    $dateSuscripciones = new Carbon($sus->fechaFin);
                    $dateSuscripciones->addDays((int)$date)->format('Y-m-d');

                    $sus = Suscripcion::where('id', $this->suscripcionBuscada[0]->id)->update([
                        'fechaFin' => $dateSuscripciones,
                        'estado' => 'suspendida',
                    ]);

                    SuscripcionSupendida::Create([
                        'del' => $this->del,
                        'al' => $this->al,
                        'motivo' => $this->motivo,
                        'idsus' => $this->suscripcionBuscada[0]->id,
                        'reponerDias' => $this->reponerDias,
                        'IndicarFecha' => $this->radioOptions,
                        'fechaReposicion' => $this->fechaReposicion,
                        'diasAgre' => $date,
                    ]);

                    $this->status = 'created';
                    $this->dispatchBrowserEvent('alert', [
                        'message' => ($this->status == 'created') ? '¡Suspendida correctamente!' : ''
                    ]);

                    $this->del = null;
                    $this->al = null;
                    $this->motivo = null;
                    $this->reponerDias = null;
                    $this->radioOptions = 'reponer';
                    $this->fechaReposicion = null;
                } else {
                }
            } else {
                $this->status = 'error';
                $this->dispatchBrowserEvent('alert', [
                    'message' => ($this->status == 'error') ? '¡Esa suscripción ya está suspendida!' : ''
                ]);
                $this->del = null;
                $this->al = null;
                $this->motivo = null;
                $this->reponerDias = null;
                $this->radioOptions = 'reponer';
                $this->fechaReposicion = null;
            }
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Llena todos los campos!' : ''
            ]);
        }
    }
}

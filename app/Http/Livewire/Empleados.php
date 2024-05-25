<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;
use Livewire\WithPagination;

class Empleados extends Component
{
    use WithPagination;

    public $sort, $direction, $cant, $search;
    public $user;
    protected $listeners = ['render', 'eliminarContrato'];

    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
        $this->user = Auth::user();
    }

    /*public function render()
    {
        return view('livewire.empleados');
    }*/

    public function render()
    {
        $query = ContratoTrabajo::query();

        if ($this->user->hasRole('inspector')) {
            $query->where('idUser', $this->user->id);
        }

        if (!empty($this->search)) {
            // Utilizamos la relación 'empleado' para acceder al campo 'name' de la tabla 'users'
            $query->whereHas('empleado', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $empleados = $query->orderBy($this->sort, $this->direction)->paginate($this->cant);

        return view('livewire.empleados', compact('empleados'));
    }

    public function order($sort)
    {
        if ($this->sort = $sort) {
            $this->direction = ($this->direction === 'desc') ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function verContrato($id)
    {
        return redirect()->route('contratoTrabajo', ['id' => $id]);
    }

    public function redirectContrato($idEmpleado)
    {
        return Redirect::to("Empleado/{$idEmpleado}");
    }

    public function redirectVacacion($contratoId)
    {
        return Redirect::to("Vacacion/{$contratoId}");
    }

    public function eliminarContrato($contratoId)
    {
        $contrato = ContratoTrabajo::findOrFail($contratoId);
        if (!$contrato) {
            return; //Contrato no encontrado
        }    
        //Eliminar vacaciones_asignadas relacionadas
        if ($contrato->vacaciones) {
            foreach ($contrato->vacaciones->vacacionAsignadas as $vacacionAsignada) {
                if ($vacacionAsignada) {
                    $vacacionAsignada->delete();
                }
            }    
            //Eliminar la vacaciones
            if ($contrato->vacaciones) {
                $contrato->vacaciones->delete();
            }
        }    
        //Eliminar contrato_trabajo
        $contrato->delete();
    }

    public function agregar()
    {
        return redirect()->route('ContratoTrabajo');
    }
}

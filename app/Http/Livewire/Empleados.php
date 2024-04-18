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
            $query->where('nombreEmpleado', 'like', '%' . $this->search . '%');
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

    //Para que me rediriga a la vista editar-taller
    public function redirectContrato($idEmpleado)
    {
        return Redirect::to("Empleado/{$idEmpleado}");
    }

    public function eliminarContrato($contratoId)
    {
        ContratoTrabajo::destroy($contratoId);
    }

    public function agregar()
    {
        return redirect()->route('ContratoTrabajo');
    }
}

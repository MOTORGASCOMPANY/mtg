<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class EditarEmpleado extends Component
{
    public $idEmpleado, $empleado;
    //protected $listeners = ['actualizarManuales' => 'render'];
    protected $listeners = ["refrescaEmpleado"];

    public function mount()
    {
        $this->empleado = ContratoTrabajo::find($this->idEmpleado);
    }

    public function render()
    {
        return view('livewire.editar-empleado');
    }

    public function refrescaEmpleado()
    {
        $this->empleado->refresh();
    }

    public function regresar()
    {
        return Redirect::to('/Empleados');
    }
}

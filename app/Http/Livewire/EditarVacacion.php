<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class EditarVacacion extends Component
{
    public $contratoId, $empleado;
    //protected $listeners = ['actualizarManuales' => 'render'];
    protected $listeners = ["refrescaEmpleado"];

    public function mount()
    {
        $this->empleado = ContratoTrabajo::find($this->contratoId);
        //dd($this->empleado);
    }

    public function render()
    {
        return view('livewire.editar-vacacion');
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

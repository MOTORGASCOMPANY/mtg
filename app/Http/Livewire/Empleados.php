<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use App\Models\Vacacion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;
use Livewire\WithPagination;
use DateTime;

class Empleados extends Component
{
    use WithPagination;

    public $sort, $direction, $cant, $search;
    public $user;
    public $openEdit = false, $emp;
    protected $listeners = ['render', 'eliminarContrato'];

    protected $rules = [
        'emp.dniEmpleado' => 'required|digits:8',
        'emp.domicilioEmpleado' => 'required',
        'emp.fechaInicio' => 'required|date|before:fechaExpiracion',
        'emp.fechaExpiracion' => 'required|date|after:fechaInicio',
        'emp.cargo' => 'required',
        'emp.pago' => 'required|numeric',
        'emp.celularEmpleado' => 'required|digits:9',
        'emp.correoEmpleado' => 'required|email',
        'emp.cumpleaosEmpleado' => 'required|date',
    ];

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

    public function abrirModal(ContratoTrabajo $emp)
    {
        $this->emp = $emp;
        $this->openEdit = true;
    }

    public function editarContrato()
    {
        $rules = [
            'emp.dniEmpleado' => 'required|digits:8',
            'emp.domicilioEmpleado' => 'required',
            'emp.fechaInicio' => 'required|date', //|before:emp.fechaExpiracion
            'emp.fechaExpiracion' => 'required|date|after:emp.fechaInicio',
            'emp.cargo' => 'required',
            'emp.pago' => 'required|numeric',
            'emp.celularEmpleado' => 'required|digits:9',
            'emp.correoEmpleado' => 'required|email',
            'emp.cumpleaosEmpleado' => 'required|date',
        ];

        $this->validate($rules);
        $this->emp->save();

        // Calcular la diferencia en años entre fechaInicio y fechaExpiracion
        $fechaInicio = new DateTime($this->emp->fechaInicio);
        $fechaExpiracion = new DateTime($this->emp->fechaExpiracion);
        $diferencia = $fechaInicio->diff($fechaExpiracion);
        $aniosTrabajados = $diferencia->y + ($diferencia->m / 12) + ($diferencia->d / 365);
        //$diasVacaciones = ($aniosTrabajados >= 1) ? ($aniosTrabajados * 15) : 0;

        // Obtener las vacaciones asociadas al contrato
        $vacacion = Vacacion::where('idContrato', $this->emp->id)->first();

        if ($aniosTrabajados >= 1) {
            // Calcular días de vacaciones si ha trabajado al menos un año completo
            $diasVacaciones = floor($aniosTrabajados) * 15;

            // Actualizar los días ganados y restantes
            $vacacion->dias_ganados = $diasVacaciones;
            $vacacion->dias_restantes = $diasVacaciones - $vacacion->dias_tomados;
            $vacacion->save();
        }

        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El contrato del empleado se actualizo correctamente", "icono" => "success"]);
        $this->reset(["openEdit"]);
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

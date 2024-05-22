<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\ContratoTrabajo;
use App\Models\Vacacion;
use App\Models\VacacionAsignada;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Traits\pdfTrait;
use DateTime;

class ContratosTrabajos extends Component
{
    use pdfTrait;

    public $inspectores;
    public $idUser, $dniEmpleado, $domicilioEmpleado, $fechaInicio, $fechaExpiracion, $cargo, $pago;
    public $contrato;
    public $mostrarCampos = false;
    public $contratoPreview = null;

    public function mount()
    {
        $this->inspectores = User::role(['inspector'])->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.contratos-trabajos');
    }

    public function certificar()
    {
        $this->validate([
            'idUser' => 'required',
            'dniEmpleado' => 'required|digits:8',
            'domicilioEmpleado' => 'required',
            'fechaInicio' => 'required',
            'fechaExpiracion' => 'required',
            'cargo' => 'required',
            'pago' => 'required',
        ]);

        $nuevoMemorando =  ContratoTrabajo::create([
            'idUser' => $this->idUser,
            'dniEmpleado' => $this->dniEmpleado,
            'domicilioEmpleado' => $this->domicilioEmpleado,
            'fechaInicio' => $this->fechaInicio,
            'fechaExpiracion' => $this->fechaExpiracion,
            'cargo' => $this->cargo,
            'pago' => $this->pago,
        ]);

        // Calcular días de vacaciones
        $fechaInicio = new DateTime($this->fechaInicio);
        $fechaExpiracion = new DateTime($this->fechaExpiracion);
        $diferencia = $fechaInicio->diff($fechaExpiracion);
        $diasVacaciones = $diferencia->days / 365 * 15;

        // Crear registro de vacaciones
        Vacacion::create([
            'idContrato' => $nuevoMemorando->id,
            'dias_ganados' => $diasVacaciones,
            'dias_tomados' => 0,
            'dias_restantes' => $diasVacaciones,
        ]);

        /* Crear registro de vacacion_asignada
        VacacionAsignada::create([
            'idContrato' => $nuevoMemorando->id,
            'tipo' => $diasVacaciones,
            'razon' => 0,
            'd_tomados' => $diasVacaciones,
            'f_inicio' => $diasVacaciones,
            'observacion' => $diasVacaciones,
        ]);*/


        $this->contrato = $nuevoMemorando;
        $this->reset(['idUser', 'dniEmpleado', 'domicilioEmpleado', 'fechaInicio', 'fechaExpiracion', 'cargo', 'cargo']);
        $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "El contrato se realizo correctamente", "icono" => "success"]);
        //return redirect('ContratoTrabajo');
    }

    public function seleccionarInspector()
    {
        $this->mostrarCampos = true;
    }

    public function updated($field)
    {
        $this->generarVistaPrevia();
    }

    public function generarVistaPrevia()
    {
        $contrato = [
            'nombreEmpleado' => User::findOrFail($this->idUser)->name,
            'dniEmpleado' => $this->dniEmpleado,
            'domicilioEmpleado' => $this->domicilioEmpleado,
            'fechaInicio' => $this->fechaInicio,
            'fechaExpiracion' => $this->fechaExpiracion,
            'cargo' => $this->cargo,
            'pago' => $this->pago,
        ];
        $this->contratoPreview = $contrato;
    }
}

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
    public $idUser, $dniEmpleado, $domicilioEmpleado, $fechaInicio, $fechaExpiracion, $cargo, $pago, $celularEmpleado, $correoEmpleado, $cumpleaosEmpleado ,$renovacion_id;
    public $contrato;
    public $mostrarCampos = false;
    public $contratoPreview = null;
    public $contratosPrevios = [];

    public function mount()
    {
        //$this->inspectores = User::role(['inspector'])->orderBy('name')->get();
        $this->inspectores = User::orderBy('name')->get();
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
            'fechaInicio' => 'required|date|before:fechaExpiracion',
            'fechaExpiracion' => 'required|date|after:fechaInicio',
            'cargo' => 'required',
            'pago' => 'required|numeric',
            //'celularEmpleado' => 'required|digits:9',
            //'correoEmpleado' => 'required|email',

        ]);

        try {
            $nuevoContrato =  ContratoTrabajo::create([
                'idUser' => $this->idUser,
                'dniEmpleado' => $this->dniEmpleado,
                'domicilioEmpleado' => $this->domicilioEmpleado,
                'fechaInicio' => $this->fechaInicio,
                'fechaExpiracion' => $this->fechaExpiracion,
                'cargo' => $this->cargo,
                'pago' => $this->pago,
                'celularEmpleado' => $this->celularEmpleado,
                'correoEmpleado' => $this->correoEmpleado,
                'cumpleaosEmpleado' => $this->cumpleaosEmpleado,

            ]);

            // Calcular días de vacaciones
            $fechaInicio = new DateTime($this->fechaInicio);
            $fechaExpiracion = new DateTime($this->fechaExpiracion);
            $diferencia = $fechaInicio->diff($fechaExpiracion);
            //$diasVacaciones = ($diferencia->days / 365) * 15;
            // Conversión de la diferencia a años
            $aniosTrabajados = $diferencia->y + ($diferencia->m / 12) + ($diferencia->d / 365); 
            // Si el contrato es de al menos un año, calcular vacaciones; de lo contrario, 0
            $diasVacaciones = ($aniosTrabajados >= 1) ? ($aniosTrabajados * 15) : 0;

            // Crear registro de vacaciones
            Vacacion::create([
                'idContrato' => $nuevoContrato->id,
                'dias_ganados' => $diasVacaciones,
                'dias_tomados' => 0,
                'dias_restantes' => $diasVacaciones,
            ]);

            $this->contrato = $nuevoContrato;
            $this->reset(['idUser', 'dniEmpleado', 'domicilioEmpleado', 'fechaInicio', 'fechaExpiracion', 'cargo', 'pago', 'celularEmpleado', 'correoEmpleado', 'cumpleaosEmpleado']);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "El contrato se realizó correctamente", "icono" => "success"]);
        } catch (\Exception $e) {
            $this->emit("minAlert", ["titulo" => "¡ERROR!", "mensaje" => "Ocurrió un error al crear el contrato.", "icono" => "error"]);
        }
    }


    /*public function certificar()
    {
        $this->validate([
            'idUser' => 'required',
            'dniEmpleado' => 'required|digits:8',
            'domicilioEmpleado' => 'required',
            'fechaInicio' => 'required|date|before:fechaExpiracion',
            'fechaExpiracion' => 'required|date|after:fechaInicio',
            'cargo' => 'required',
            'pago' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $nuevoContrato = ContratoTrabajo::create([
                'idUser' => $this->idUser,
                'dniEmpleado' => $this->dniEmpleado,
                'domicilioEmpleado' => $this->domicilioEmpleado,
                'fechaInicio' => $this->fechaInicio,
                'fechaExpiracion' => $this->fechaExpiracion,
                'cargo' => $this->cargo,
                'pago' => $this->pago,
                'renovacion_id' => $this->renovacion_id,
            ]);

            // Calcular el total de días trabajados incluyendo renovaciones
            $totalDiasTrabajados = $this->calcularTotalDiasTrabajados($nuevoContrato);
            $aniosTrabajados = $totalDiasTrabajados / 365;

            // Calcular días de vacaciones
            $diasVacaciones = ($aniosTrabajados >= 1) ? ($aniosTrabajados * 15) : 0;

            // Crear registro de vacaciones
            Vacacion::create([
                'idContrato' => $nuevoContrato->id,
                'dias_ganados' => $diasVacaciones,
                'dias_tomados' => 0,
                'dias_restantes' => $diasVacaciones,
            ]);

            DB::commit();

            $this->contrato = $nuevoContrato;
            $this->reset(['idUser', 'dniEmpleado', 'domicilioEmpleado', 'fechaInicio', 'fechaExpiracion', 'cargo', 'pago', 'renovacion_id']);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "El contrato se realizó correctamente", "icono" => "success"]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit("minAlert", ["titulo" => "¡ERROR!", "mensaje" => "Ocurrió un error al crear el contrato.", "icono" => "error"]);
        }
    }*/

    private function calcularTotalDiasTrabajados($contrato)
    {
        $totalDias = 0;
        while ($contrato) {
            $fechaInicio = new DateTime($contrato->fechaInicio);
            $fechaExpiracion = new DateTime($contrato->fechaExpiracion);
            $diferencia = $fechaInicio->diff($fechaExpiracion);
            $totalDias += $diferencia->days;
            $contrato = $contrato->renovacion;
        }
        return $totalDias;
    }

    public function seleccionarInspector()
    {
        $this->mostrarCampos = true;
        //$this->contratosPrevios = ContratoTrabajo::where('idUser', $this->idUser)->get();
        //dd($this->contratosPrevios);
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

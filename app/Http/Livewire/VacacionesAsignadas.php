<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use App\Models\Vacacion;
use App\Models\VacacionAsignada;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VacacionesAsignadas extends Component
{
    public $usuarios, $vacaciones, $idVacacion, $tipo, $razon, $d_tomados, $f_inicio, $observacion;
    public $contratoId;

    public function mount($contratoId)
    {
        //$this->usuarios = ContratoTrabajo::with('empleado')->get();
        //$this->vacaciones = collect();
        $this->contratoId = $contratoId;
        $this->vacaciones = Vacacion::with('contrato')->where('idContrato', $this->contratoId)->get();
    }   

    public function render()
    {
        return view('livewire.vacaciones-asignadas');
    }

    public function asignarVacacion()
    {
        $this->validate([
            //'idVacacion' => 'required|exists:vacaciones,id',
            'tipo' => 'required|string|max:255',
            'razon' => 'required|string',
            'd_tomados' => 'required|integer',
            'f_inicio' => 'required|date',
            'observacion' => 'nullable|string',
        ]);
        // Crear o actualizar la vacación asignada
        VacacionAsignada::create([
            'idVacacion' => $this->idVacacion,
            'tipo' => $this->tipo,
            'razon' => $this->razon,
            'd_tomados' => $this->d_tomados,
            'f_inicio' => $this->f_inicio,
            'observacion' => $this->observacion,
        ]);

        // Actualizar registro en vacaciones
        $vacacion = Vacacion::find($this->idVacacion);
        $vacacion->dias_tomados += $this->d_tomados;
        $vacacion->dias_restantes = $vacacion->dias_ganados - $vacacion->dias_tomados;
        $vacacion->save();

        $this->reset(['idVacacion', 'tipo', 'razon', 'd_tomados', 'f_inicio', 'observacion']);
        $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "La vacación se asignó correctamente", "icono" => "success"]);
        return redirect()->route('Empleados');

        /*
         DB::beginTransaction();

         try {
            // Crear registro en vacacion_asignada
            VacacionAsignada::create([
                'idVacacion' => $this->idVacacion,
                'tipo' => $this->tipo,
                'razon' => $this->razon,
                'd_tomados' => $this->d_tomados,
                'f_inicio' => $this->f_inicio,
                'observacion' => $this->observacion,
            ]);

            // Actualizar registro en vacaciones
            $vacacion = Vacacion::find($this->idVacacion);
            $vacacion->dias_tomados += $this->d_tomados;
            $vacacion->dias_restantes = $vacacion->dias_ganados - $vacacion->dias_tomados;
            $vacacion->save();

            DB::commit();

            $this->reset(['idVacacion', 'tipo', 'razon', 'd_tomados', 'f_inicio', 'observacion']);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "La vacación se asignó correctamente", "icono" => "success"]);
         } catch (\Exception $e) {
            DB::rollBack();
            $this->emit("minAlert", ["titulo" => "¡ERROR!", "mensaje" => "Hubo un problema al asignar la vacación", "icono" => "error"]);
         }
        */
    }

    /* 
     public function updatedSelectedUser($userId)
     {
        $this->vacaciones = Vacacion::whereHas('contrato', function ($query) use ($userId) {
            $query->where('idUser', $userId);
        })->get();
     }
    */
}

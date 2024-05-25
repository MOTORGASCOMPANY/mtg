<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use App\Models\Vacacion;
use App\Models\VacacionAsignada;
use Livewire\Component;
use Livewire\WithPagination;

class RegistroVacacion extends Component
{
    use WithPagination;

    public  $vacacionesAsignadas;
    public $contratoId;
    public $vacacionId;
    public $openEdit = false;
    public $vacacion_asignada;

    protected $listeners = ['render', 'deleteVacacion', 'refreshVacacionesAsignadas'];

    protected $rules = [
        "vacacion_asignada.tipo" => "required",
        "vacacion_asignada.razon" => "required",
        "vacacion_asignada.d_tomados" => "required|numeric",
        "vacacion_asignada.f_inicio" => "required|date",
        "vacacion_asignada.observacion" => "required",

    ];

    /*     
     public function render()
     {
        return view('livewire.registro-vacacion');
     }
    */

    /*public function mount($contratoId)
    {
        $this->contratoId = $contratoId;
        $contrato = ContratoTrabajo::with('vacaciones.vacacionAsignadas')->find($this->contratoId);
        
        if ($contrato && $contrato->vacaciones) {
            $this->vacacionesAsignadas = $contrato->vacaciones->vacacionAsignadas;
        } else {
            $this->vacacionesAsignadas = collect();
        }
    }*/

    public function mount($contratoId)
    {
        $this->contratoId = $contratoId;
        $this->loadVacacionesAsignadas();
    }

    public function loadVacacionesAsignadas()
    {
        $contrato = ContratoTrabajo::with('vacaciones.vacacionAsignadas')->find($this->contratoId);

        if ($contrato && $contrato->vacaciones) {
            $this->vacacionesAsignadas = $contrato->vacaciones->vacacionAsignadas;
        } else {
            $this->vacacionesAsignadas = collect();
        }
    }

    public function render()
    {
        return view('livewire.registro-vacacion', [
            'vacacionesAsignadas' => $this->vacacionesAsignadas,
        ]);
    }

    public function deleteVacacion($id)
    {
        $vacacion = VacacionAsignada::find($id);
        if ($vacacion) {
            $difference = $vacacion->d_tomados; // Calcular la diferencia
            $vacacion->delete();
            $vacacionPrincipal = Vacacion::find($vacacion->idVacacion);
            $vacacionPrincipal->dias_tomados -= $difference;
            $vacacionPrincipal->dias_restantes = $vacacionPrincipal->dias_ganados - $vacacionPrincipal->dias_tomados;
            $vacacionPrincipal->save();
            $this->loadVacacionesAsignadas(); // Recargar la lista de vacaciones asignadas
        }
    }


    // Método para cargar vacaciones asignadas
    public function refreshVacacionesAsignadas()
    {
        $this->loadVacacionesAsignadas();
    }

    public function abrirModal($id)
    {
        $this->vacacion_asignada = VacacionAsignada::find($id);
        $this->openEdit = true;
    }

    /*public function editarVacacion(){
        $this->validate();
        $this->vacacion_asignada->save();
        $this->emit("minAlert", ["titulo" => "¡Buen trabajo!", "mensaje" => "La vacación se actualizó correctamente", "icono" => "success"]);
        
        $this->openEdit = false;
        $this->loadVacacionesAsignadas();
    }*/

    public function editarVacacion()
    {
        $this->validate();
        $old_d_tomados = $this->vacacion_asignada->getOriginal('d_tomados'); // Guardar d_tomados antes de actualizar        
        $this->vacacion_asignada->save(); // Actualizar data de vacacion asignada        
        $vacacion = Vacacion::find($this->vacacion_asignada->idVacacion); // Obtenemos vacacion para actualizar       
        $difference = $this->vacacion_asignada->d_tomados - $old_d_tomados; // Calcular la diferencia en d_tomados        
        $vacacion->dias_tomados += $difference; // Actualizar los días tomados y restantes
        $vacacion->dias_restantes = $vacacion->dias_ganados - $vacacion->dias_tomados;
        $vacacion->save();
        $this->emit("minAlert", ["titulo" => "¡Buen trabajo!", "mensaje" => "La vacación se actualizó correctamente", "icono" => "success"]);

        $this->openEdit = false;
        $this->loadVacacionesAsignadas();
    }
}

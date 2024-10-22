<?php

namespace App\Http\Livewire;

use App\Models\Taller;
use App\Models\TallerInspector;
use App\Models\User;
use Livewire\Component;

class TalleresInspectores extends Component
{
    public $taller_id;
    public $inspector_id;

    public $talleres;
    public $inspectores;
    public $selectedInspectors = [];
    public $showModal = false;

    protected $rules = [
        'taller_id' => 'required|exists:taller,id',
        'inspector_id' => 'required|exists:users,id',
    ];

    public function mount()
    {
        // Cargar talleres e inspectores
        $this->talleres = Taller::orderBy('nombre')->get();
        $this->inspectores = User::role(['inspector'])->orderBy('name')->get();
    }

    public function openModal()
    {
        $this->showModal = true; // Abrir modal
    }

    public function addInspectorToCart()
    {
        $this->validate();

        // Agregar el inspector al array de seleccionados
        if (!in_array($this->inspector_id, $this->selectedInspectors)) {
            $this->selectedInspectors[] = $this->inspector_id;
            $this->emit("minAlert", ["titulo" => "¡AGREGADO!", "mensaje" => "Inspector agregado al carrito.", "icono" => "success"]);
        } else {
            $this->emit("minAlert", ["titulo" => "¡CUIDADO!", "mensaje" => "El inspector ya está en el carrito.", "icono" => "warning"]);
        }
    }

    public function confirmAddition()
    {
        foreach ($this->selectedInspectors as $inspectorId) {
            // Verificar si ya existe la combinación taller_id e inspector_id
            $exists = TallerInspector::where('taller_id', $this->taller_id)
                ->where('inspector_id', $inspectorId)
                ->exists();

            if ($exists) {
                // Emitir alerta si el inspector ya está asignado al taller
                $this->emit("minAlert", ["titulo" => "¡CUIDADO!", "mensaje" => "Este inspector ya está asignado a este taller.", "icono" => "warning"]);
            } else {
                // Crear registro en la tabla si no existe
                TallerInspector::create([
                    'taller_id' => $this->taller_id,
                    'inspector_id' => $inspectorId,
                ]);
            }
        }

        // Limpiar el array de seleccionados y resetear los campos
        $this->selectedInspectors = [];
        $this->showModal = false;
        $this->reset(['taller_id', 'inspector_id']);
        $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Inspectores agregados al taller con éxito.", "icono" => "success"]);
    }

    public function removeInspector($inspectorId)
    {
        // Eliminar el inspector del array de seleccionados
        $this->selectedInspectors = array_filter($this->selectedInspectors, function ($id) use ($inspectorId) {
            return $id != $inspectorId; // Comparar correctamente
        });
        $this->emit("minAlert", ["titulo" => "¡ELIMINADO!", "mensaje" => "Inspector eliminado del carrito.", "icono" => "info"]);
    }

    public function render()
    {
        $asignaciones = TallerInspector::with(['taller', 'inspector'])->get(); // Cargar registros
        // Agrupar los inspectores por taller
        $asignaciones = $asignaciones->groupBy('taller_id');
        return view('livewire.talleres-inspectores', compact('asignaciones'));
    }
}

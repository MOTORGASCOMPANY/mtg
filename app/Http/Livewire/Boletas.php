<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Boleta;
use App\Models\Taller;

class Boletas extends Component
{
    use WithFileUploads;

    public $idTaller, $fechaInicio, $fechaFin, $monto, $observacion;
    public $talleres = [], $boleta;
    public $mostrarCampos = false;

    protected $rules = [
        'idTaller' => 'required',
        'fechaInicio' => 'required|date',
        'fechaFin' => 'required|date|after_or_equal:fechaInicio',
        'monto' => 'required|numeric|min:0',
        'observacion' => 'nullable|string',
    ];

    public function mount()
    {
        $this->talleres = Taller::orderBy('nombre')->get();
    }

    public function render()
    {
        return view('livewire.boletas');
    }

    public function guardar()
    {
        $this->validate();
        try {
            $nuevoBoleta = Boleta::create([
                'idTaller' => $this->idTaller,
                'fechaInicio' => $this->fechaInicio,
                'fechaFin' => $this->fechaFin,
                'monto' => $this->monto,
                'observacion' => $this->observacion,
            ]);
            $this->reset(['idTaller', 'fechaInicio', 'fechaFin', 'monto', 'observacion']); 
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Boleta guardada exitosamente.", "icono" => "success"]);
        } catch (\Exception $e) {
            $this->emit("minAlert", ["titulo" => "¡ERROR!", "mensaje" => "Ocurrió un error al crear la boleta.", "icono" => "error"]);
        }
    }

    public function seleccionarTaller()
    {
        $this->mostrarCampos = true;
    }
}

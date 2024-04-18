<?php

namespace App\Http\Livewire;

use App\Models\TipoDocumentoEmpleado;
use Livewire\Component;

class CreateTipoDocumentoEmpleado extends Component
{
    public $nombreTipo;
    public $open=false;

    protected $rules=[
        "nombreTipo"=>"required|min:3",       
    ];

    public function render()
    {
        return view('livewire.create-tipo-documento-empleado');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function crearTipoDocumento(){
        $this->validate();
        $tipoman=TipoDocumentoEmpleado::create(["nombreTipo"=>$this->nombreTipo]);
        $this->emitTo("tipos-documentos-emple","render");
        $this->reset(["nombreTipo","open"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Tipo doc empleado creado Correctamente", "icono" => "success"]); 
    }
}

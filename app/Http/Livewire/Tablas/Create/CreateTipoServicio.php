<?php

namespace App\Http\Livewire\Tablas\Create;

use App\Models\TipoServicio;
use Livewire\Component;

class CreateTipoServicio extends Component
{

    public $descripcion;
    public $open=false;

    protected $rules=[
        "descripcion"=>"required|min:3",       
    ];

    public function render()
    {
        return view('livewire.Tablas.create.create-tipo-servicio');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function crearTipoServicio(){
        $this->validate();
        $tiposer=TipoServicio::create(["descripcion"=>$this->descripcion]);
        $this->emitTo("tablas.tiposservicios","render");
        $this->reset(["descripcion","open"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Permiso creado Correctamente", "icono" => "success"]); 
    }
}

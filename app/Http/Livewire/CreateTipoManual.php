<?php

namespace App\Http\Livewire;

use App\Models\TipoManual;
use Livewire\Component;

class CreateTipoManual extends Component
{
    public $nombreTipo;
    public $open=false;

    protected $rules=[
        "nombreTipo"=>"required|min:3",       
    ];

    public function render()
    {
        return view('livewire.create-tipo-manual');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function crearTipoManual(){
        $this->validate();
        $tipoman=TipoManual::create(["nombreTipo"=>$this->nombreTipo]);
        $this->emitTo("tipos-manual","render");
        $this->reset(["nombreTipo","open"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Manual creado Correctamente", "icono" => "success"]); 
    }
}

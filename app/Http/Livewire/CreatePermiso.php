<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class CreatePermiso extends Component
{
    public $nombre,$descripcion;
    public $open=false;

    protected $rules=[
        "nombre"=>"required|min:3",
        "descripcion"=>"required|min:3",
    ];

    public function render()
    {
        return view('livewire.create-permiso');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function crearPermiso(){
        $this->validate();
        $permiso=Permission::create(["name"=>$this->nombre,"descripcion"=>$this->descripcion,"guard_name"=>"web"]);
        $this->emitTo("admin-permisos","render");
        $this->reset(["nombre","descripcion","open"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Permiso creado Correctamente", "icono" => "success"]); 
    }
}

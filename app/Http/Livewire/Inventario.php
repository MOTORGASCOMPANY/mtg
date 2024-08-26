<?php

namespace App\Http\Livewire;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PharIo\Manifest\Author;

class Inventario extends Component
{

    public $todos;
    public $inspector, $inspectores, $tipoMaterial, $estado;
    public $resultado;

    protected $rules = [
        "tipoMaterial" => "required|numeric|min:1",
        "estado" => "required",
    ];

    public function mount()
    {
        $this->inspector = Auth::id();
        $this->todos=Material::where([
            //FORMATOS EN STOCK
           ['idUsuario',Auth::id()],
           ])->get();      
    }

    /*public function mount(){
        $this->todos=Material::where([
             //FORMATOS EN STOCK
            ['idUsuario',Auth::id()],
            ])->get();      
            
            //dd($this->todos);
    }*/

    public function consultar()
    {
        $this->validate();
        $this->resultado = Material::where("idUsuario", $this->inspector)
            ->TipoMaterialInvetariado($this->tipoMaterial)
            ->EstadoInvetariado($this->estado)
            ->get();
    }

    public function updated($nameProperty)
    {
        $this->validateOnly($nameProperty);
        if ($nameProperty) {
            $this->reset(["resultado"]);
        }
    }
    
    public function render()
    {   
        return view('livewire.inventario');
    }   

    
}

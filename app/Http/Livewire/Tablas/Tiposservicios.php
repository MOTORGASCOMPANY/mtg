<?php

namespace App\Http\Livewire\Tablas;

use App\Models\TipoServicio;
use Livewire\Component;
use Livewire\WithPagination;

class Tiposservicios extends Component
{
    use WithPagination;

    public $sort,$direction,$cant,$search,$tipoServicio;
    public $editando=false;

    protected $listeners=["render","eliminar"];

    protected $rules=[
        "tipoServicio.descripcion"=>"required|min:3",       
    ];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;       
    }

    public function render()
    {
        $tiposDeServicios=TipoServicio::
        where([           
            ['descripcion','like','%'.$this->search.'%']
        ])
        ->orWhere("id",'like','%'.$this->search.'%')
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.Tablas.tiposservicios',compact("tiposDeServicios"));
    }
    public function order($sort)
    {
        if($this->sort=$sort){
            if($this->direction=='desc'){
                $this->direction='asc';
            }else{
                $this->direction='desc';
            }
        }else{
            $this->sort=$sort;
            $this->direction='asc';
        }        
    }

    public function actualizar(){
        $this->validate();
        $this->tipoServicio->save();       
        $this->reset(["editando"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se actualizó correctamente el registro", "icono" => "success"]); 
    }

    public function editar(TipoServicio $tiposer){
        $this->tipoServicio=$tiposer;        
        $this->editando=true;
    }

    public function eliminar(TipoServicio $tiposer){
        $tiposer->delete();       
        $this->emitTo("tablas.tiposservicios","render");
    }
}

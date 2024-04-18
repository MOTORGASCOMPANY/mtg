<?php

namespace App\Http\Livewire;

use App\Models\TipoManual;
use Livewire\Component;
use Livewire\WithPagination;

class TiposManual extends Component
{
    public $sort,$direction,$cant,$search,$tipoManual;
    public $editando=false;

    protected $listeners=["render","eliminar"];

    protected $rules=[
        "tipoManual.nombreTipo"=>"required|min:3",       
    ];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;       
    }


    /*public function render()
    {
        return view('livewire.tipos-manual');
    }*/

    public function render()
    {
        $tiposDeManuales=TipoManual::
        where([           
            ['nombreTipo','like','%'.$this->search.'%']
        ])
        ->orWhere("id",'like','%'.$this->search.'%')
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.tipos-manual',compact("tiposDeManuales"));
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
        $this->tipoManual->save();       
        $this->reset(["editando"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se actualizó correctamente el registro", "icono" => "success"]); 
    }

    public function editar(TipoManual $tipoman){
        $this->tipoManual=$tipoman;        
        $this->editando=true;
    }

    public function eliminar(TipoManual $tipoman){
        $tipoman->delete();       
        $this->emitTo("tipos-manual","render");
    }

}

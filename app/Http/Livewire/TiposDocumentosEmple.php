<?php

namespace App\Http\Livewire;

use App\Models\TipoDocumentoEmpleado;
use Livewire\Component;
use Livewire\WithPagination;

class TiposDocumentosEmple extends Component
{
    public $sort,$direction,$cant,$search,$tipoDocumentoEmple;
    public $editando=false;

    protected $listeners = ['render', 'eliminarTipo'];

    protected $rules=[
        "tipoDocumentoEmple.nombreTipo"=>"required|min:3",       
    ];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;       
    }

    /*public function render()
    {
        return view('livewire.tipos-documentos-emple');
    }*/

    public function render()
    {
        $tiposDocumentosEmple=TipoDocumentoEmpleado::
        where([           
            ['nombreTipo','like','%'.$this->search.'%']
        ])
        ->orWhere("id",'like','%'.$this->search.'%')
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.tipos-documentos-emple',compact("tiposDocumentosEmple"));
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
        $this->tipoDocumentoEmple->save();       
        $this->reset(["editando"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se actualizó correctamente el registro", "icono" => "success"]); 
    }

    public function editar(TipoDocumentoEmpleado $tipoman){
        $this->tipoDocumentoEmple=$tipoman;        
        $this->editando=true;
    }

    public function eliminarTipo($tipoId)
    {
        TipoDocumentoEmpleado::destroy($tipoId);
    }

}

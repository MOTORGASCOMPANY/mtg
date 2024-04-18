<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class AdminPermisos extends Component
{
    use WithPagination;

    public $sort,$direction,$cant,$search,$permiso;
   
    public $editando=false;

    protected $rules=[
        "permiso.name"=>"required|string",
        "permiso.descripcion"=>"nullable|string"
    ];

    protected $listeners=["render"];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;       
    }

    public function render()
    {
        $permisos=Permission::
        where([           
            ['name','like','%'.$this->search.'%']
        ])
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.admin-permisos',compact('permisos'));
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

    public function editarPermiso(Permission $permiso){
        $this->permiso=$permiso;        
        $this->editando=true;
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function actualizar(){
        $this->validate();
        $this->permiso->save();
        $this->permiso=Permission::make();
        $this->reset(["editando"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se actualizó correctamente el permiso", "icono" => "success"]);    
        ///$this->emitTo("admin-permisos","render");
    }
}

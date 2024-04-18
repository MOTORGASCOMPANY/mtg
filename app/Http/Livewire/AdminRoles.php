<?php

namespace App\Http\Livewire;

use App\Models\Roles;
use FontLib\Table\Type\name;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoles extends Component
{
    use WithPagination;

    public $sort,$direction,$cant,$search,$rol,$permisos;
    public $selectedPermisos=[];
    public $editando=false;

    protected $rules=[
        "rol.name"=>"required",
        "selectedPermisos"=>"array|min:1",

    ];

    protected $listeners=["render"];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;
       
    }

    public function render()
    {
        $roles=Roles::
        where([           
            ['name','like','%'.$this->search.'%']
        ])
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.admin-roles',compact("roles"));
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

    public function editaRol(Role $rol){
        $this->rol=$rol;
        $this->permisos=Permission::all();       
        $this->selectedPermisos=$rol->Permissions->pluck('name')->all();
        $this->editando=true;
    }

    public function actualizar(){
        $this->validate();
        $this->rol->save();
        $this->rol->syncPermissions($this->selectedPermisos);
        $this->reset(["editando"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se actualizó correctamente el Rol de ".$this->rol->name, "icono" => "success"]); 
    }

    protected $messages = [
        'selectedPermisos.min' => 'Debes seleccionar como mínimo un permiso para este rol.',        
    ];
}

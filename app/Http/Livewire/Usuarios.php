<?php

namespace App\Http\Livewire;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Usuarios extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $sort,$direction,$cant,$search;

    public $selectedRoles=[];
    public $roles;

    public $editando=false;

    public $usuario,$firma;

    protected $rules=[
        "usuario.name"=>"required|string",
        "usuario.email"=>"required|email",
        "usuario.celular"=>"nullable|digits:9",
        "firma"=>"nullable|image",
        "selectedRoles"=>"array|min:1",
    ];
    
    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;
    }

    public function updated($propertyName){
        
        $this->validateOnly($propertyName);
    }
    public function render()
    {
        $usuarios=User::
        where([
            ['id','!=',Auth::id()],
            ['name','like','%'.$this->search.'%']
        ])
        ->orWhere([
            ['id','!=',Auth::id()],
            ['email','like','%'.$this->search.'%']
        ])
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.usuarios',compact('usuarios'));
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
        $this->usuario->syncRoles($this->selectedRoles);
        $this->guardaFirma($this->usuario);
        $this->usuario->save();
        $this->usuario=User::make();
        $this->reset(["editando","firma"]);
        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO", "mensaje" => "Se actualizaron los datos de usuario correctamente.", "icono" => "success"]);

    }

    public function guardaFirma(User $usuario){       
        if($this->firma!=null){            
            $rutaFirma=$this->firma->storeAs('public/FirmasDeInspectores','firma-'.rand().'-'.$usuario->id.'.'.$this->firma->extension());
            $usuario->update(['rutaFirma'=>$rutaFirma]);
        }
       
    }

    public function editarUsuario(User $usuario){
        $this->usuario=$usuario;        
        $this->roles=Roles::all();
        $this->selectedRoles=$usuario->Roles->pluck('name')->all();
        $this->editando=true;
    }

    protected $messages = [
        'selectedRoles.min' => 'Debes seleccionar como mínimo un rol para este usuario.',        
    ];

}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Roles;
use App\Models\Taller;

class ListaRoles extends Component
{
    public $roles;
    public $rol;
    public $talleres;

    public function mount(){
        $this->roles=Roles::all();
        $this->talleres=Taller::orderBy("nombre")->get();
    }

    
    public function render()
    {
        return view('livewire.lista-roles');
    }
}

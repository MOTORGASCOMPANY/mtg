<?php

namespace App\Http\Livewire;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PharIo\Manifest\Author;

class Inventario extends Component
{

    public $todos;


    public function mount(){
        $this->todos=Material::where([
             //FORMATOS EN STOCK
            ['idUsuario',Auth::id()],
            ])->get();      
            
            //dd($this->todos);
    }
    
    public function render()
    {   
        return view('livewire.inventario');
    }   

    
}

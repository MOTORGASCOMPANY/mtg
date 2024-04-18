<?php

namespace App\Http\Livewire;

use App\Models\Taller;
use Livewire\Component;
use Livewire\WithPagination;

class ListaTalleres extends Component
{

    use WithPagination;

    public $talleres,$seleccion;

    public function mount(){
        $this->talleres=Taller::all();
    }

    protected $rules=[        
        'seleccion'=>'required|numeric|min:1',  
    ];

    public function render()
    {
        return view('livewire.lista-talleres');
    }

    public function updatingSeleccion(){
        $this->emitTo('revision-expedientes','tallerSel',$this->seleccion);
    }
    
}

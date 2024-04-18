<?php

namespace App\Http\Livewire;

use App\Models\Solicitud;
use App\Models\User;
use Livewire\Component;

class VistaSolicitud extends Component
{
    public $inspector,$solicitud,$soliId;


    public function mount(){
       
        $this->solicitud=Solicitud::find($this->soliId);
        $this->inspector=User::find($this->solicitud->idInspector)->name;
    }
    public function render()    {
        
        return view('livewire.vista-solicitud');
    }
}

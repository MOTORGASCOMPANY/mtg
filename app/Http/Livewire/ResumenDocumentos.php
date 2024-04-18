<?php

namespace App\Http\Livewire;

use App\Models\Taller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ResumenDocumentos extends Component
{

    public $taller,$documentos;

    public function mount(){
        
        if( Auth::user()->taller!=0 ){
        
        $this->taller=Taller::find(Auth::user()->taller);
        $this->documentos=$this->taller->Documentos;
        }
    }
    public function render()
    {
        return view('livewire.resumen-documentos');
    }
}

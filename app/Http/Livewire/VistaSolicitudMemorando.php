<?php

namespace App\Http\Livewire;

use App\Models\Memorando;
use App\Models\User;
use Livewire\Component;

class VistaSolicitudMemorando extends Component
{
   
    public $pdf, $user, $memorando;

    public function mount($memoId)
    {
        $this->memorando = Memorando::find($memoId);
        $this->pdf = $this->memorando->rutaVistaMemorando; 
        $this->user = User::find($this->memorando->idUser)->name;
    }

    public function render()
    {
        return view('livewire.vista-solicitud-memorando');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ManualFunciones extends Component
{
    protected $listeners = ['actualizarManuales' => 'render'];
    
    public function render()
    {
        return view('livewire.manual-funciones');
    }
}

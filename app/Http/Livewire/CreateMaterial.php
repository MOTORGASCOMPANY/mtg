<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateMaterial extends Component
{
    public $open;
    

    public function mount(){
        $open=false;
    }

    public function render()
    {
        return view('livewire.create-material');
    }
}

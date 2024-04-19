<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Organigramas extends Component
{
    protected $listeners = ['actualizarOrganigrama' => 'render'];

    public function render()
    {
        return view('livewire.organigramas');
    }
}

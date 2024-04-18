<?php

namespace App\Http\Livewire;

use App\Models\Servicio;
use Livewire\Component;

class ListaServicios extends Component
{

    public $servicios;

    public function mount(){
        $this->servicios=Servicio::all();
    }
    public function render()
    {
        return view('livewire.lista-servicios');
    }
}

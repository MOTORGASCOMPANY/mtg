<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\Solicitud as ModelSolicitud;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Solicitud extends Component
{

    use WithPagination;

    public function render()
    {
        $solicitudes=ModelSolicitud::all();
        return view('livewire.solicitud',compact("solicitudes"));
    }
}

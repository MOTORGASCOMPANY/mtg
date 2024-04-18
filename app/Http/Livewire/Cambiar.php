<?php

namespace App\Http\Livewire;

use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cambiar extends Component
{
    public function render()
    {
        return view('livewire.cambiar');
    }

    /*public function cambiar(){

    DB::table('material')->update(['anio'=>DB::raw('añoActivo')]);
    dd('Se actualizo correctamente');
    }*/

}

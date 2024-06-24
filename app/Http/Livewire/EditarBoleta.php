<?php

namespace App\Http\Livewire;

use App\Models\Boleta;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class EditarBoleta extends Component
{
    public $idBoleta, $boleta;
    protected $listeners = ["refrescaBoleta"];

    public function mount()
    {
        $this->boleta = Boleta::find($this->idBoleta);
    }

    public function render()
    {
        return view('livewire.editar-boleta');
    }

    public function refrescaBoleta()
    {
        $this->boleta->refresh();
    }

    public function regresar()
    {
        return Redirect::to('/Listaboletas');
    }

    public function generatePdf()
    {
        return redirect()->route('generaPdfBoleta', ['id' => $this->idBoleta]);
    }
}

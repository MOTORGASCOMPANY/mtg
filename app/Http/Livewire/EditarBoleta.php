<?php

namespace App\Http\Livewire;

use App\Models\Boleta;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class EditarBoleta extends Component
{
    public $idBoleta, $boleta;
    public $auditoria; //para auditoria
    protected $listeners = ["refrescaBoleta"];

    public function mount()
    {
        $this->boleta = Boleta::find($this->idBoleta);
        $this->auditoria = $this->boleta->auditoria;
    }

    public function render()
    {
        return view('livewire.editar-boleta');
    }

    public function refrescaBoleta()
    {
        $this->boleta->refresh();
        $this->auditoria = $this->boleta->auditoria;
    }

    public function regresar()
    {
        return Redirect::to('/Listaboletas');
    }

    public function generatePdf()
    {
        return redirect()->route('generaPdfBoleta', ['id' => $this->idBoleta]);
    }

    public function updatedAuditoria($value)
    {
        $this->boleta->auditoria = $value ? 1 : 0;
        $this->boleta->save();
    }
}

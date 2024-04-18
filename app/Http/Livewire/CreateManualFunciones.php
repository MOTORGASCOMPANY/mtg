<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DocumentoManual;
use App\Models\TipoManual;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateManualFunciones extends Component
{
    use WithFileUploads;
    public $addDocument = false;
    public $tiposDisponibles, $tipoSel, $fechaInicial, $fechaCaducidad, $documento;

    public function render()
    {
        $this->tiposDisponibles = TipoManual::all();
        return view('livewire.create-manual-funciones');
    }

    public function agregarDocumento()
    {
        $this->validate([
            'tipoSel' => 'required',
            'fechaInicial' => 'required',
            'fechaCaducidad' => 'required|after:fechaInicial',
            'documento' => 'required|mimes:pdf|max:10240',
        ]);

        $nombre = $this->tipoSel . '-doc-' . uniqid() . '.' . $this->documento->extension();
        DocumentoManual::create([
            'fechaInicio' => $this->fechaInicial,
            'fechaExpiracion' => $this->fechaCaducidad,
            'extension' => $this->documento->getClientOriginalExtension(),
            'ruta' => $this->documento->storeAs('public/docsManual',$nombre),
            'tipomanual_id' => $this->tipoSel,
        ]);

        $this->addDocument = false;
        $this->reset(['tipoSel', 'fechaInicial', 'fechaCaducidad', 'documento']);
        $this->emit('documentoAgregado');
        $this->emitTo('manual-funciones', 'actualizarManuales');
    }
}

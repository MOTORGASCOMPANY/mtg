<?php

namespace App\Http\Livewire;

use App\Models\Organigrama;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateOrganigrama extends Component
{
    use WithFileUploads;
    public $addDocument = false;
    public $documento, $doc;

    public function render()
    {
        return view('livewire.create-organigrama');
    }

    public function agregardocumento()
    {
        $this->validate([
            'documento' => 'required',
            'doc' => 'required|mimes:pdf|max:10240',
        ]);

        $nombre = '-doc-' . uniqid() . '.' . $this->doc->extension();
        Organigrama::create([
            'documento' => $this->documento,       
            'extension' => $this->doc->getClientOriginalExtension(),
            'ruta' => $this->doc->storeAs('public/docsOrganigrama',$nombre),
        ]);

        $this->addDocument = false;
        $this->reset(['documento', 'doc']);
        $this->emit('documentoAgregado');
        $this->emitTo('organigramas', 'actualizarOrganigrama');
    }
}

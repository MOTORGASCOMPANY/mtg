<?php

namespace App\Http\Livewire;

use App\Models\Boleta;
use App\Models\BoletaArchivo;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBoletaArchivo extends Component
{
    use WithFileUploads;
    public $idBoleta, $boleta;
    public $addDocument = false;
    public  $documento, $nombre;

    public function mount()
    {
        $this->boleta = Boleta::find($this->idBoleta);
        $this->nombre = ''; 
    }

    public function render()
    {
        return view('livewire.create-boleta-archivo');
    }

    public function agregarDocumento()
    {
        $this->validate([
            'documento' => 'required|mimes:jpg,jpeg,png|max:2048', //pdf,
            'nombre' => 'required|string|max:255'
        ]);

        BoletaArchivo::create([
            'boleta_id' => $this->idBoleta,
            'nombre' => $this->nombre,
            'ruta' => $this->documento->storeAs('public/docsBoletas', $this->nombre . '.' . $this->documento->extension()),
            'extension' => $this->documento->extension(),
        ]);
        $this->emitTo('editar-boleta', 'refrescaBoleta');
        $this->emitTo('boletas-archivos', 'resetBoleta');
        $this->reset(['documento', 'nombre', 'addDocument']);
        $this->emit("CustomAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "Se ingreso correctamente un nuevo documento", "icono" => "success"]);
    }

}

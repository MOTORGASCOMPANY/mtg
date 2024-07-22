<?php

namespace App\Http\Livewire;

use App\Models\Boleta;
use App\Models\BoletaArchivo;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class BoletasArchivos extends Component
{
    use WithFileUploads;

    public  $boleta;
    public $idBoleta;
    public $openEdit = false, $documento, $nuevoPdf;  
    protected $listeners=["eliminar"=>"delete","resetBoleta"=>"refrescaBoleta"];

    protected $rules=[
        "documento.nombre"=>"required",  
        //"nuevoPdf" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:2048"      
    ];

    public function mount(){
        $this->boleta=Boleta::find($this->idBoleta);
        //dd($this->boleta);
    }

    public function render()
    {
        return view('livewire.boletas-archivos');
    }

    public function refrescaBoleta(){
        $this->boleta->refresh();
    }

    public function delete($id)
    {
        $documento = BoletaArchivo::findOrFail($id);
        Storage::delete([$documento->ruta]);
        $documento->delete();
        $this->refrescaBoleta();
        //$this->emit("CustomAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Documento eliminado correctamente", "icono" => "success"]);
    }

    /*public function generatePdf()
    {
        return redirect()->route('generaPdfBoleta', ['id' => $this->idBoleta]);
    }*/

    public function abrirModal($id)
    {
        $this->documento = BoletaArchivo::findOrFail($id);
        $this->openEdit = true;
    }
    
    public function editarDocumento()
    {
        $this->validate();

        if ($this->nuevoPdf) {
            $nombre = rand() . '-doc-' . rand();
            $nuevaRuta = $this->guardaNuevoArchivo($nombre, $this->nuevoPdf);
            Storage::delete([$this->documento->ruta]);
            $this->documento->ruta = $nuevaRuta;
            $this->documento->extension = $this->nuevoPdf->extension();
        }

        $this->documento->save();

        $this->emit("CustomAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Documento actualizado correctamente", "icono" => "success"]);
        $this->reset(['openEdit', 'nuevoPdf']);
        $this->refrescaBoleta();
    }

    private function guardaNuevoArchivo($nombre, $file)
    {
        return $file->storeAs('public/docsBoletas', $nombre . '.' . $file->extension());
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DocumentoManual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class DocumentosManual extends Component
{
    use WithFileUploads;
    public $tDocumentos;
    public $openEdit,$documento,$nuevoPdf;
    public $user;

    protected $rules=[
        "documento.tipomanual_id"=>"required|numeric|min:1",        
        "documento.fechaInicio"=>"required|date",
        "documento.fechaExpiracion"=>"required|date",       
    ];

    protected $listeners=["eliminar"=>"delete","resetDocumento"=>"refrescaDocumento"];

    /*public function render()
    {
        $this->tDocumentos = DocumentoManual::with('tipoManual')->get();
        return view('livewire.documentos-manual');
    }*/

    public function mount()
    {      
        $this->user = Auth::user();
    }

    public function render()
    {
        if ($this->user->hasRole('inspector')) {
            $this->tDocumentos = DocumentoManual::whereHas('tipoManual', function ($query) {
                $query->where('nombreTipo', 'Inspector');
            })->with('tipoManual')->get();
        } else {
            $this->tDocumentos = DocumentoManual::with('tipoManual')->get();
        }

        return view('livewire.documentos-manual');
    }

    public function abrirModal(DocumentoManual $doc){
        $this->documento=$doc;
        $this->openEdit=true;
    }

    public function editarDocumento(){

        $rules=[
            "documento.tipomanual_id"=>"required|numeric|min:1",        
            "documento.fechaInicio"=>"required|date",
            "documento.fechaExpiracion"=>"required|date", 
        ];
        
        if($this->nuevoPdf!=null){
            $rules+=["nuevoPdf"=>"required|mimes:pdf"];
            $this->validate($rules);
            $nombre= rand().'-doc-'.rand();  
            $nuevaRuta=$this->guardaNuevoArchivo($nombre,$this->nuevoPdf);
            Storage::delete([$this->documento->ruta]); 
            $this->documento->ruta=$nuevaRuta;
            $this->documento->save(); 
            $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El documento ".$this->documento->tipoManual->nombreTipo." se actualizo correctamente", "icono" => "success"]);
        }else{
            $this->validate($rules);
            $this->documento->save(); 
            $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El documento ".$this->documento->tipoManual->nombreTipo." se actualizo correctamente", "icono" => "success"]);
        }     
        $this->reset(["openEdit","nuevoPdf"]);
    }

    public function delete($id)
    {        
        $doc = DocumentoManual::findOrFail($id);
        Storage::delete($doc->ruta);
        $doc->delete();
        $doc=DocumentoManual::make();
        $this->documento=null;
        //$this->refrescaDocumento();
        $this->emitTo('editar-manual','refrescaDocumento'); 
        $this->emitTo('documentos-manual','render');   
    }
    

    public function guardaNuevoArchivo($nombre,$file){
        $ruta=null;
        if($file != null){
            $ruta=$file->storeAs('public/docsManual',$nombre.'.'.$file->extension());
        }
       
        return $ruta;
    }
}

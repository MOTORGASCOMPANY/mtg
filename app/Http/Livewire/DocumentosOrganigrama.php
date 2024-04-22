<?php

namespace App\Http\Livewire;

use App\Models\Organigrama;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class DocumentosOrganigrama extends Component
{
    use WithFileUploads;
    public $tDocumentos;
    public $openEdit,$doc,$nuevoPdf;

    protected $listeners=["eliminar"=>"delete","resetDocumento"=>"refrescaDocumento"];

    protected $rules=[
        "doc.documento"=>"required",      
    ];

    public function render()
    {
        $this->tDocumentos = Organigrama::get();
        return view('livewire.documentos-organigrama');
    }
    

    public function abrirModal(Organigrama $doc){
        $this->doc=$doc;
        $this->openEdit=true;
    }

    public function editarDocumento(){

        $rules=[
            "doc.documento"=>"required",   
        ];
        
        if($this->nuevoPdf!=null){
            $rules+=["nuevoPdf"=>"required|mimes:pdf"];
            $this->validate($rules);
            $nombre= rand().'-doc-'.rand();  
            $nuevaRuta=$this->guardaNuevoArchivo($nombre,$this->nuevoPdf);
            Storage::delete([$this->doc->ruta]); 
            $this->doc->ruta=$nuevaRuta;
            $this->doc->save(); 
            $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El doc ".$this->doc->documento." se actualizo correctamente", "icono" => "success"]);
        }else{
            $this->validate($rules);
            $this->doc->save(); 
            $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El doc ".$this->doc->documento." se actualizo correctamente", "icono" => "success"]);
        }     
        $this->reset(["openEdit","nuevoPdf"]);
    }

    public function delete($id)
    {        
        $doc2 = Organigrama::findOrFail($id);
        Storage::delete($doc2->ruta);
        $doc2->delete();
        $doc2=Organigrama::make();
        $this->doc=null;
        $this->emitTo('documentos-organigrama','render');   
    }
    
    

    public function guardaNuevoArchivo($nombre,$file){
        $ruta=null;
        if($file != null){
            $ruta=$file->storeAs('public/docsManual',$nombre.'.'.$file->extension());
        }
       
        return $ruta;
    }
}

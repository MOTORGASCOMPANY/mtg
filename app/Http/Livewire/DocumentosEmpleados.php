<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use App\Models\DocumentoEmpleado;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class DocumentosEmpleados extends Component
{
    use WithFileUploads;

    public  $empleado;

    public $openEdit,$documento,$nuevoPdf,$idEmpleado;  

    protected $rules=[
        "documento.tipoDocumento"=>"required|numeric|min:1",        
        "documento.fechaInicio"=>"required|date",
        "documento.fechaExpiracion"=>"required|date",       
    ];

    protected $listeners=["eliminar"=>"delete","resetEmpleado"=>"refrescaEmpleado"];

    public function mount(){
        $this->empleado=ContratoTrabajo::find($this->idEmpleado);
    }

    public function render()
    {
        return view('livewire.documentos-empleados');
    }

    public function abrirModal(DocumentoEmpleado $doc){
        $this->documento=$doc;
        $this->openEdit=true;
    }

    public function delete($id){
        $doc=DocumentoEmpleado::findOrFail($id);
        Storage::delete($doc->ruta);
        $doc->delete();
        $doc=DocumentoEmpleado::make();
        $this->documento=null;
        $this->refrescaEmpleado();
        $this->emitTo('editar-empleado','refrescaEmpleado'); 
        $this->emitTo('documentos-empleados','render');         
    }


    public function refrescaEmpleado(){
        $this->empleado->refresh();
    }

    public function editarDocumento(){

        $rules=[
            "documento.tipoDocumento"=>"required|numeric|min:1",        
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
            $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El documento ".$this->documento->TipoDocumento->nombreTipo." se actualizo correctamente", "icono" => "success"]);
        }else{
            $this->validate($rules);
            $this->documento->save(); 
            $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El documento ".$this->documento->TipoDocumento->nombreTipo." se actualizo correctamente", "icono" => "success"]);
        }     
        $this->reset(["openEdit","nuevoPdf"]);
    }


    public function guardaNuevoArchivo($nombre,$file){
        $ruta=null;
        if($file != null){
            $ruta=$file->storeAs('public/docsEmpleados',$nombre.'.'.$file->extension());
        }
       
        return $ruta;
    }
}

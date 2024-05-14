<?php

namespace App\Http\Livewire;

use App\Models\Documento;
use App\Models\DocumentoTaller;
use App\Models\Imagen;
use App\Models\Taller;
use App\Models\TipoDocumento;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateDocumentoTaller extends Component
{
    use WithFileUploads;

    public  $taller,$idTaller;
    public $addDocument=false;

    public $tiposDocumentos,$tipoSel,$documento,$fechaInicial,$fechaCaducidad,$tiposDisponibles,$empleado;  
    public $combustible;  
    public $combustibleSeleccionado = false;

    protected $rules=[
        "tipoSel"=>"required|numeric|min:1",
        "documento"=>"required|mimes:pdf",
        "fechaInicial"=>"required|date",
        "fechaCaducidad"=>"required|date",   
        "combustible" => "required|in:GNV,GLP",     
    ];

    public function updated($nameProperty){

        $this->validateOnly($nameProperty);
    }

    public function updatedCombustible()
    {
        $this->listaDisponibles();  
        $this->combustibleSeleccionado = true;
    }

    public function mount(){
        $this->taller=Taller::find($this->idTaller);
       // $this->tiposDocumentos=TipoDocumento::all();
        $this->listaDisponibles();    
    }
    
    
    public function render()
    {
        return view('livewire.create-documento-taller');
    }

    

    public function updatedAddDocument(){
        //$this->listaDisponibles();   
        $this->reset(["tipoSel","fechaInicial","fechaCaducidad","documento","empleado","combustible","combustibleSeleccionado"]);
        $this->tipoSel=""; 
    }

    
    public function agregarDocumento(){

        $this->validate();

        if ($this->combustibleSeleccionado) {
            $combustibleElegido = $this->combustibleSeleccionado;
        }

        if($this->tipoSel==9){
            $this->validate(["empleado"=>"required|string"]);
        }
        $nombre= $this->idTaller.'-doc-'.rand();
        $documento_guardado=Documento::create([
            'tipoDocumento'=>$this->tipoSel, 
            'fechaInicio'=>$this->fechaInicial,
            'fechaExpiracion'=>$this->fechaCaducidad, 
            'estadoDocumento'=>1,  
            'combustible'=>$this->combustible,         
            'ruta'=>$this->documento->storeAs('public/docsTaller',$nombre.'.'.$this->documento->extension()),
            'extension'=>$this->documento->extension(), 
        ]); 
        if($this->tipoSel==9){
            $documento_guardado->update(['nombreEmpleado'=>$this->empleado]);            
        }

        $docTaller=DocumentoTaller::create([
            'idDocumento'=>$documento_guardado->id,
            'idTaller'=>$this->idTaller,
            'estado'=>1,
            'combustible' => $this->combustible,
        ]);
        $this->emitTo('editar-taller','refrescaTaller'); 
        $this->emitTo('documentos-taller','resetTaller'); 
        $this->reset(["tipoSel","fechaInicial","fechaCaducidad","documento","empleado","addDocument"]);
        $this->tipoSel="";
        $this->emit("CustomAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "Se ingreso correctamente un nuevo documento del taller ".$this->taller->nombre, "icono" => "success"]);

    }

    public function cuentaDisGNV($tipo){
        $cuenta=0;
        if(isset($this->taller->Documentos)){
            if($this->taller->Documentos->count() >0){
                foreach($this->taller->Documentos as $doc){                    
                    if($doc->tipoDocumento == $tipo && $doc->combustible=='GNV'){
                        $cuenta++;
                    }
                }
            }
        }
        return $cuenta;
    }

    public function cuentaDisGLP($tipo){
        $cuenta=0;
        if(isset($this->taller->Documentos)){
            if($this->taller->Documentos->count() >0){
                foreach($this->taller->Documentos as $doc){                                    
                    if($doc->tipoDocumento == $tipo && $doc->combustible=='GLP'){
                        $cuenta++;
                    }
                }
            }
        }
        return $cuenta;
    }

    public function listaDisponibles(){        
        $aux=[];
        $todos=TipoDocumento::all();
        if($this->combustible=='GNV'){
            foreach($todos as $tip){
                if($tip->id==9){
                    array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombreTipo,"estado"=>1));
                }else{
                    if($this->cuentaDisGNV($tip->id) >= 1 ){
                        array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombreTipo,"estado"=>0));
                    }else{
                        array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombreTipo,"estado"=>1));
                    }
                }            
            }   
        }else if($this->combustible=='GLP'){
            foreach($todos as $tip){
                if($tip->id==9){
                    array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombreTipo,"estado"=>1));
                }else{
                    if($this->cuentaDisGLP($tip->id) >= 1 ){
                        array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombreTipo,"estado"=>0));
                    }else{
                        array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombreTipo,"estado"=>1));
                    }
                }            
            }   
        }         
        $this->tiposDisponibles=$aux;             
    }
}

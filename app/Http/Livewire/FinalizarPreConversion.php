<?php

namespace App\Http\Livewire;

use App\Jobs\guardarArchivosEnExpediente;
use App\Models\CertifiacionExpediente;
use App\Models\Certificacion;
use App\Models\Equipo;
use App\Models\Expediente;
use App\Models\Imagen;
use App\Models\Material;
use App\Models\TipoServicio;
use App\Models\vehiculo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class FinalizarPreConversion extends Component
{
    use WithFileUploads;

    public $placa,$idCertificacion,$certificacion,$conChip,$vehiculo,$open=false,$equipo;
    public $imagenes=[];

    // Agregando para que solo me muestre para gnv y no glp
    public $tipoServicio;


   
    protected $rules=[
        "vehiculo.placa"=>"required|min:6|max:7",
        "vehiculo.anioFab"=>"required|numeric",
        "equipo.*"=>"required",
        "equipo.numSerie"=>"required|min:3",
        "equipo.marca"=>"required|min:2",
        "equipo.modelo"=>"required|min:2",
        "equipo.capacidad"=>"required|min:3",
        "equipo.peso"=>"required|numeric|min:1",
        ];

    public function mount(){
        $this->conChip=0; //CAMBIE EL VALOR INICIAL PARA QUE ME MUESTRE DESACTIVADO DE 1 A 0
        $this->certificacion=Certificacion::find($this->idCertificacion);
        $this->vehiculo=vehiculo::find($this->certificacion->idVehiculo);
        // Obtén el tipo de servicio
        $tipoServicioId = $this->certificacion->Servicio->tipoServicio_idtipoServicio;
        $this->tipoServicio = TipoServicio::find($tipoServicioId)->descripcion;
    }

    public function render()
    {
        return view('livewire.finalizar-pre-conversion');

    }
    public function completar(){
        $rules=[
            "vehiculo.placa"=>"required|min:6|max:7",
            "vehiculo.anioFab"=>"required|numeric",];
        $this->validate($rules);       
        $chip=Material::where([["idUsuario",Auth::id()],["estado",3],["idTipoMaterial",2]])->first();
        if($this->conChip==1){
            if($chip!=null){
               
                if(isset($this->vehiculo)){
                    $chip->update(["estado"=>4,"ubicacion"=>"En poder del cliente","descripcion"=>"consumido"]);
                    $this->vehiculo->save();
                    //dd($this->vehiculo);
                    $this->certificacion->update(["estado"=>1]);
                    $expe=Expediente::create([
                        "placa"=>$this->vehiculo->placa,
                        "certificado"=>$this->certificacion->Hoja->numSerie,
                        "estado"=>1,
                        "idTaller"=>$this->certificacion->Taller->id,
                        'usuario_idusuario'=>Auth::id(),
                        'servicio_idservicio'=>$this->certificacion->Servicio->id,
                    ]);            
                    //dd($expe);            
                    $this->guardarFotos($expe);
                    guardarArchivosEnExpediente::dispatch($expe,$this->certificacion);                       
                    $certEx=CertifiacionExpediente::create(["idCertificacion"=>$this->certificacion->id,"idExpediente"=>$expe->id]);
                    
                    return redirect()->to("/Listado-Certificaciones");
                }
            }else{
                $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No se pudo seleccionar un chip para realizar el servicio", "icono" => "warning"]);
            }            
        }else{
            
            if(isset($this->vehiculo)){                               
                $this->vehiculo->save();
                //dd($this->vehiculo);
                $this->certificacion->update(["estado"=>1]);
                $expe=Expediente::create([
                    "placa"=>$this->vehiculo->placa,
                    "certificado"=>$this->certificacion->Hoja->numSerie,
                    "estado"=>1,
                    "idTaller"=>$this->certificacion->Taller->id,
                    'usuario_idusuario'=>Auth::id(),
                    'servicio_idservicio'=>$this->certificacion->Servicio->id,
                ]);     
                //dd($expe);                      
                $this->guardarFotos($expe);
                guardarArchivosEnExpediente::dispatch($expe,$this->certificacion);                       
                $certEx=CertifiacionExpediente::create(["idCertificacion"=>$this->certificacion->id,"idExpediente"=>$expe->id]);
                $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "TODO OKo", "icono" => "success"]);
                return redirect()->to("/Listado-Certificaciones");
            }
        }      
    }

    public function guardarFotos(Expediente $expe){
        $this->validate(["imagenes"=>"nullable|array","imagenes.*"=>"image"]);
        if(count($this->imagenes)){
            foreach($this->imagenes as $key => $file){          
                $nombre=$expe->placa.'-foto'.($key+1).'-'.$expe->certificado;
                $file_save=Imagen::create([                
                    'nombre'=>$nombre,
                    'ruta'=>$file->storeAs('public/expedientes',$nombre.'.'.$file->extension()),
                    'extension'=>$file->extension(),
                    'Expediente_idExpediente'=>$expe->id,
                ]);            
            }
        }
       $this->reset(["imagenes"]);      
    }

    

    public function edit(Equipo $eq){
        $this->equipo=$eq;
        $this->open=true;
    }

    public function actualizar(){

        switch($this->equipo->idTipoEquipo){
            case 1:
                $this->salvaChip();
                $this->vehiculo->refresh(); 
                $this->emitTo('finalizar-pre-conversion','render'); 
            break;

            case 2:
                $this->salvaReductor();
                $this->vehiculo->refresh(); 
                $this->emitTo('finalizar-pre-conversion','render');
            break;

            case 3:
                $this->salvaTanque();
                $this->vehiculo->refresh(); 
                $this->emitTo('finalizar-pre-conversion','render');
            break;
        }
        
    }

    public function salvaTanque(){
        $this->validate([
                        "equipo.numSerie"=>"required|min:1",
                        "equipo.marca"=>"required|min:1",
                        "equipo.capacidad"=>"required|numeric|min:1",
                        "equipo.peso"=>"required|numeric|min:1",
                        "equipo.fechaFab"=>"required|date"
                        ]);
       
       
        $this->equipo->numSerie=strtoupper($this->equipo->numSerie);
        $this->equipo->marca=strtoupper($this->equipo->marca);        
        $this->equipo->save();

           
        $this->open=false;
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$this->equipo->tipo->nombre." con serie ".$this->equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        
        $this->reset(["equipo"]);   
    }

    public function salvaReductor(){
        $this->validate([
            "equipo.numSerie"=>"required|min:1",
            "equipo.marca"=>"required|min:1",
            "equipo.modelo"=>"required|min:1"
            ]); 

        $this->equipo->save();       
        $this->open=false;
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$this->equipo->tipo->nombre." con serie ".$this->equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        $this->reset(["equipo"]);   
    }

    public function salvaChip(){
        $this->validate([
            "equipo.numSerie"=>"required|min:1",           
            ]);      

        $this->equipo->numSerie=strtoupper($this->equipo->numSerie);
        $this->equipo->save();          
                  
        $this->open=false;        
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$this->equipo->tipo->nombre." con serie ".$this->equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        
        $this->reset(["equipo"]);  

        
    }

   
}

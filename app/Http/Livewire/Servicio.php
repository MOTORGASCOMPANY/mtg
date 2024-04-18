<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\Equipo;
use App\Models\EquiposVehiculo;
use App\Models\Expediente;
use App\Models\Material;
use App\Models\Servicio as ModelServicio;
use App\Models\ServicioMaterial;
use App\Models\Taller;
use App\Models\TipoEquipo;
use App\Models\vehiculo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;



class Servicio extends Component
{   
    

    //Definiendo Variables de vehiculo
    public $placa,$categoria,$marca,$modelo,$version,$anioFab,$numSerie,$numMotor,
    $cilindros,$cilindrada,$combustible,$ejes,$ruedas,$asientos,$pasajeros,
    $largo,$ancho,$altura,$color,$pesoNeto,$pesoBruto,$cargaUtil;

    //Definiendo Variables de equipos
    
    public $tiposDisponibles=[];
    public $tipoEquipo,$equipoSerie,$equipoMarca,$equipoModelo,$equipoCapacidad,$equipoPeso,$equipoFechaFab,$cantEquipos;
    public $equipos=[];
    

    //Variables del servicio
    public $formatosGnvDisponibles;
    public $listaVehiculos=[];
    public $talleres,$servicios,$serv,$tipoServicio,$taller,$ruta,$open,$formularioVehiculo,$vehiculoServicio,$rutaDes,$certDuplicado;

    public $busqueda=false;
    public $busquedaCert=false;
    public $certificaciones;
    public $vehiculos;
    public $fechaCerti;
    //variables del certificado
    public $servicioCertificado,$numSugerido;   
    protected $rules=[
                    "taller"=>"required|numeric|min:1",
                    "serv"=>"required|numeric|min:1",
                    "placa"=>"required|min:6",
                    "categoria"=>"nullable",
                    "marca"=>"required|min:2",
                    "modelo"=>"required|min:2",
                    "version"=>"nullable", 
                    "anioFab"=>"nullable|numeric|min:1900",                  
                    "numSerie"=>"nullable|min:2",
                    "numMotor"=>"nullable|min:2",
                    "cilindros"=>"nullable|numeric|min:1",
                    "cilindrada"=>"nullable|numeric|min:1",
                    "combustible"=>"nullable|min:2", 
                    "ejes"=>"nullable|numeric|min:1",   
                    "ruedas"=>"nullable|numeric|min:1",    
                    "asientos"=>"nullable|numeric|min:1",      
                    "pasajeros"=>"nullable|numeric|min:1",   
                    "largo"=>"nullable|numeric",   
                    "ancho"=>"nullable|numeric",
                    "altura"=>"nullable|numeric",
                    "color"=>"nullable|min:2",
                    "pesoNeto"=>"nullable|numeric",
                    "pesoBruto"=>"nullable|numeric",
                    "cargaUtil"=>"nullable|numeric",
                    ];

    

    
    public function render()
    {
        return view('livewire.servicio');
    }
    
    public function mount(){
        //$this->servicios=ModelServicio::make();
        $this->talleres=Taller::all()->sortBy('nombre');
        $this->taller=Taller::make();        
        //$this->listaTiposDisponibles();
        $this->open=false;
        $this->formularioVehiculo=true;
        $this->formatosGnvDisponibles=Material::where([['estado',3],['idUsuario',Auth::id()],['idTipoMaterial',1]])->get();   
        //$this->numSugerido=$this->numFormatoSugerido();     
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    }

    public function updatedTaller($val){
        $this->servicios=ModelServicio::where("taller_idtaller",$val)->get();
        $this->reset(["serv"]);
    }  

    public function updatedServ($val){
        
        if($val){
            $this->tipoServicio=ModelServicio::find($val)->tipoServicio;            
            $this->sugeridoSegunTipo($this->tipoServicio->id);  
            $this->reset(["vehiculoServicio","servicioCertificado"]);
            $this->resetFormVehiculo();
        }else{
            $this->tipoServicio=null;
            $this->reset(["vehiculoServicio","servicioCertificado"]);
            $this->resetFormVehiculo();
        }       
    }

    public function resetFormVehiculo(){
        $this->reset([
            "placa",
            "categoria",
            "marca",
            "modelo",
            "version",
            "anioFab",
            "numSerie",
            "numMotor",
            "cilindros",
            "cilindrada",
            "combustible",
            "ejes",
            "ruedas",
            "asientos",
            "pasajeros",
            "largo",
            "ancho",
            "altura",
            "color",
            "pesoNeto",
            "pesoBruto",  
            "cargaUtil",     
        ]);
    }

    public function updatedOpen(){
        
            $this->listaTiposDisponibles();
        
    }
        
    //muestra el número de formato sugerido según el tipo de servicio
    public function sugeridoSegunTipo($tipoServ){
        $formatoGnv=1;        
        $formatoGlp=3;
        if($tipoServ){
            switch ($tipoServ) {
                case 1:
                    $this->numSugerido=$this->formatoSugerido($formatoGnv);
                break;
                case 2:
                    $this->numSugerido=$this->formatoSugerido($formatoGnv);
                break;
                case 3:
                    $this->numSugerido=$this->formatoSugerido($formatoGlp);
                break;
                case 4:
                    $this->numSugerido=$this->formatoSugerido($formatoGlp);
                break;                   
                case 8:
                    $this->numSugerido=$this->formatoSugerido($formatoGnv);
                break;  
                case 9:
                    $this->numSugerido=$this->formatoSugerido($formatoGlp);
                break; 
                default:
                    $this->numSugerido=0;
                break;
            }
        }
    }
    

    public function guardaVehiculo(){
        $this->validate();
        $vehiculo=vehiculo::create([            
                                    "placa"=>strtoupper($this->placa),
                                    "categoria"=>strtoupper($this->categoria),
                                    "marca"=>$this->retornaNE($this->marca),
                                    "modelo"=>$this->retornaNE($this->modelo),
                                    "version"=>$this->retornaSV($this->version),

                                    //considerar en el PDF
                                    "anioFab"=>$this->retornaNulo($this->anioFab),
                                    //considerar en el PDF

                                    "numSerie"=>$this->retornaNE($this->numSerie),
                                    "numMotor"=>$this->retornaNE($this->numMotor),


                                    //considerar en el PDF
                                    "cilindros"=>$this->retornaNulo($this->cilindros),
                                    "cilindrada"=>$this->retornaNulo($this->cilindrada),
                                    //considerar en el PDF


                                    "combustible"=>$this->retornaNE($this->combustible),

                                    //considerar en el PDF
                                    "ejes"=>$this->retornaNulo($this->ejes),
                                    "ruedas"=>$this->retornaNulo($this->ruedas),
                                    "asientos"=>$this->retornaNulo($this->asientos),
                                    "pasajeros"=>$this->retornaNulo($this->pasajeros),
                                    //considerar en el PDF


                                    //considerar en el PDF
                                    "largo"=>$this->retornaNulo($this->largo),
                                    "ancho"=>$this->retornaNulo($this->ancho),
                                    "altura"=>$this->retornaNulo($this->altura),
                                    //considerar en el PDF

                                    "color"=>$this->retornaNE($this->color),

                                    //considerar en el PDF
                                    "pesoNeto"=>$this->retornaNulo($this->pesoNeto),
                                    "pesoBruto"=>$this->retornaNulo($this->pesoBruto),  
                                    "cargaUtil"=>$this->retornaNulo($this->cargaUtil), 
                                    //considerar en el PDF         

                                    ]);
        //$this->emit("alert","El vehículo con placa ".$vehiculo->placa." se registro correctamente.");
        $this->formularioVehiculo=false;
        $this->vehiculoServicio=$vehiculo;
        $this->equipos=Equipo::make();
        $this->emit('alert','El vehículo con placa '.$vehiculo->placa.' se registro correctamente.');
    }

    public function retornaNE($value){
        if($value){
            return strtoupper($value);                   
        }else{
            return $value='NE';    
        }
    }

    public function retornaSV($value){
        if($value){
            return strtoupper($value);         
        }else{
            return $value='S/V'; 
        }
    }

    public function retornaNulo($value){
        if(isset($value)){
            return $value;
        }else{
            return $value=null;
        }
    }

    public function actualizarVehiculo(){
            $this->validate();
             $this->vehiculoServicio->update([
             "placa"=>strtoupper($this->placa),
             "categoria"=>strtoupper($this->categoria),
             "marca"=>$this->retornaNE($this->marca),
             "modelo"=>$this->retornaNE($this->modelo),
             "version"=>$this->retornaSV($this->version),

             //considerar en el PDF
             "anioFab"=>$this->retornaNulo($this->anioFab),
             //considerar en el PDF

             "numSerie"=>$this->retornaNE($this->numSerie),
             "numMotor"=>$this->retornaNE($this->numMotor),


             //considerar en el PDF
             "cilindros"=>$this->retornaNulo($this->cilindros),
             "cilindrada"=>$this->retornaNulo($this->cilindrada),
             //considerar en el PDF


             "combustible"=>$this->retornaNE($this->combustible),

             //considerar en el PDF
             "ejes"=>$this->retornaNulo($this->ejes),
             "ruedas"=>$this->retornaNulo($this->ruedas),
             "asientos"=>$this->retornaNulo($this->asientos),
             "pasajeros"=>$this->retornaNulo($this->pasajeros),
             //considerar en el PDF


             //considerar en el PDF
             "largo"=>$this->retornaNulo($this->largo),
             "ancho"=>$this->retornaNulo($this->ancho),
             "altura"=>$this->retornaNulo($this->altura),
             //considerar en el PDF

             "color"=>$this->retornaNE($this->color),

             //considerar en el PDF
             "pesoNeto"=>$this->retornaNulo($this->pesoNeto),
             "pesoBruto"=>$this->retornaNulo($this->pesoBruto),  
             "cargaUtil"=>$this->retornaNulo($this->cargaUtil),]); 
        $this->formularioVehiculo=false;   
        $this->emit("alert","Los datos del vehículo se actualizaron correctamente");
              
    }    

    public function guardaEquipos(){
        $this->validate([
                        "tipoEquipo"=>"required|numeric|min:1"
                        ]);
        switch ($this->tipoEquipo) {
            case 1:
                $this->salvaDatosChip();
                $this->listaTiposDisponibles();
            break;
            case 2:
                $this->salvaDatosReductor();
                $this->listaTiposDisponibles();
            break;
            case 3:
                $this->salvaDatosTanque();
                $this->listaTiposDisponibles();
            break;
            
            default:
                $this->emit("alert","ocurrio un error al guardar los datos");
                break;
        }
    }

    public function updatedEquipoCapacidad($var){
        if($var!=null && $var!='e'){
            $this->equipoPeso=$var+(mt_rand(5,8));
        }else{
            $this->equipoPeso=null;
        }   
    }      

    public function salvaTanque(){
        $this->validate([
                        "equipoSerie"=>"required|min:1",
                        "equipoMarca"=>"required|min:1",
                        "equipoCapacidad"=>"required|numeric|min:1",
                        "equipoPeso"=>"required|numeric|min:1",
                        "equipoFechaFab"=>"required|date"
                        ]);
        $equipo=new Equipo();
        $equipo->idTipoEquipo=$this->tipoEquipo;
        $equipo->numSerie=strtoupper($this->equipoSerie);
        $equipo->marca=strtoupper($this->equipoMarca);
        $equipo->capacidad=$this->equipoCapacidad;
        $equipo->fechaFab=$this->equipoFechaFab;
        $equipo->peso=$this->equipoPeso;  
        $equipo->save();

        $this->reset(["equipoSerie","equipoMarca","equipoModelo","equipoCapacidad","tipoEquipo","equipoFechaFab","equipoPeso"]);      
        $this->open=false;
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        
        
        
        return $equipo; 
        /*
        $this->reset(["equipoSerie","equipoMarca","equipoModelo","equipoCapacidad","tipoEquipo","equipoFechaFab","equipoPeso"]);      
        $this->open=false;
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        //$this->emit("alert","El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadió correctamente.");
        */
    }

    public function salvaReductor(){
        $this->validate([
            "equipoSerie"=>"required|min:1",
            "equipoMarca"=>"required|min:1",
            "equipoModelo"=>"required|min:1"
            ]);

        $equipo=new Equipo();
        $equipo->idTipoEquipo=$this->tipoEquipo;
        $equipo->numSerie=strtoupper($this->equipoSerie);
        $equipo->marca=strtoupper($this->equipoMarca);
        $equipo->modelo=strtoupper($this->equipoModelo);

        //array_push($this->equipos,$equipo);   
        $equipo->save();
        $this->reset(["equipoSerie","equipoMarca","equipoModelo","equipoCapacidad","tipoEquipo","equipoFechaFab","equipoPeso"]);
        $this->open=false;
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        
        

        return $equipo;    
    }

    public function salvaChip(){
        $this->validate([
            "equipoSerie"=>"required|min:1",           
            ]);

        $equipo=new Equipo();
        $equipo->idTipoEquipo=$this->tipoEquipo;
        $equipo->numSerie=strtoupper($this->equipoSerie);

        $equipo->save();   
        
        $this->reset(["equipoSerie","equipoMarca","equipoModelo","equipoCapacidad","tipoEquipo","equipoFechaFab","equipoPeso","equipos"]);     
        $this->equipos=Equipo::make();   
        $this->open=false;
        //$this->emit("alert","El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadio Correctamente");
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadio Correctamente","icono"=>"success"]);
        
        

        return $equipo;
    }
    
    public function actualizaListaEquipos(){
        if( isset($this->vehiculoServicio->Equipos)){
            $this->vehiculoServicio->refresh();
            $this->equipos=$this->vehiculoServicio->Equipos;
        }
        
    }

    public function eliminaEquipo(Equipo $eq){        
        $eq->delete();
        $this->reset(["equipos"]);
        
        $this->actualizaListaEquipos();

        $this->cantEquipos=$this->cuentaEquipos();

        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"Eliminaste un item de tu lista de equipos","icono"=>"success",]); 
    }

    
    public function cuentaDis($tipo){
        $cuenta=0;
        if(isset($this->vehiculoServicio->Equipos)){
            if($this->vehiculoServicio->Equipos->count() >0){
                foreach($this->vehiculoServicio->Equipos as $eq){
                    if($eq["idTipoEquipo"] == $tipo){
                        $cuenta++;
                    }
                }
            }else{
                $cuenta=0;
            }
        }
        return $cuenta;
    }

    public function listaTiposDisponibles(){
        $this->equipos=Equipo::make();
        $this->equipos=$this->vehiculoServicio->Equipos;
        $aux=[];
        $todos=TipoEquipo::all();
        foreach($todos as $tip){
            if($tip->id==3){
                array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombre,"estado"=>1));
            }else{
                if($this->cuentaDis($tip->id) >= 1 ){
                    array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombre,"estado"=>0));
                }else{
                    array_push($aux,array("id"=>$tip->id,"nombre"=>$tip->nombre,"estado"=>1));
                }
            }            
        }
        //$this->cantEquipos=$this->cuentaDis();
        $this->tiposDisponibles=$aux;
        $this->tipoEquipo="";
        //return $aux;
    }   

    public function salvaEquipos(){
        $aux=[];
        if(isset($this->equipos)){
            if(count($this->equipos) > 0){
                foreach($this->equipos as $eq){
                    $equipoGuardado=$this->guardaEquipoEnBD($eq);
                    array_push($aux,$equipoGuardado);
                }
            }else{
                return null;
            }
        }
        return $aux;
    }

    public function asignaEquiposVehiculo($equipos,vehiculo $veh){
        $aux=[];
        if($equipos){
            foreach($equipos as $equipo){
                $equipoVehiculo=EquiposVehiculo::create(["idEquipo"=>$equipo["id"],"idVehiculo"=>$veh->id]);
                array_push($aux,$equipoVehiculo);
            }
        }else{
            $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"No se pudo asignar equipos al vehículo","icono"=>"error"]);
        }
    }    

    public function guardaEquipo(){
        $this->validate([
            "tipoEquipo"=>"required|numeric|min:1"
            ]);
            switch ($this->tipoEquipo) {
            case 1:
                $chip=$this->salvaChip();
                $equipoVehiculo=EquiposVehiculo::create(["idEquipo"=>$chip->id,"idVehiculo"=>$this->vehiculoServicio->id]);
                $this->actualizaListaEquipos();
                $this->cantEquipos=$this->cuentaEquipos();
            break;
            case 2:
                $reductor=$this->salvaReductor();
                $equipoVehiculo=EquiposVehiculo::create(["idEquipo"=>$reductor->id,"idVehiculo"=>$this->vehiculoServicio->id]);
                $this->actualizaListaEquipos();
                $this->cantEquipos=$this->cuentaEquipos();
            break;
            case 3:
                $tanque=$this->salvaTanque();
                $equipoVehiculo=EquiposVehiculo::create(["idEquipo"=>$tanque->id,"idVehiculo"=>$this->vehiculoServicio->id]);
                $this->actualizaListaEquipos();
                $this->cantEquipos=$this->cuentaEquipos();
            break;

            default:
                $this->emit("alert","ocurrio un error al guardar los datos");
                break;
            }
    }

    


    public function certificar(){        
        $servicio=ModelServicio::find($this->serv);
        $v=$this->validaVehiculo();
        $e=$this->validaEquipos();
        $hoja=$this->procesaFormato($this->numSugerido,$this->tipoServicio->id);
        if($hoja){
            if($v){
                if($e){
                    $cert=Certificacion::create([
                        "idVehiculo"=>$this->vehiculoServicio->id,
                        "idTaller"=>$this->taller,
                        "idInspector"=>Auth::id(),
                        "idServicio"=>$this->serv,
                        "estado"=>1,
                        "precio"=>$servicio->precio,
                        "pagado"=>0,
                    ]);
                    $this->servicioCertificado=$cert;           
                    $hoja->update(["estado"=>4]);
                    $servM=ServicioMaterial::create([
                                                    "idMaterial"=>$hoja->id,
                                                    "idCertificacion"=>$cert->id
                                                    ]);
                   //$this->asignaEquiposVehiculo($this->salvaEquipos(),$this->vehiculoServicio);

                    
                    $this->ruta=$this->generarRuta($cert);
                    $this->rutaDes=$this->generarRutaDescarga($cert);
                    $this->emit("minAlert",["titulo"=>"Buen Trabajo!","mensaje"=>"Tu certificado esta listo!","icono"=>"success",]);
                }else{
                    $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"Debe completar los datos de los equipos para continuar","icono"=>"error"]);
                }
            }else{
                $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"Ingrese un vehículo valido para poder continuar","icono"=>"error"]);
            }


                        
        }        
        
    }

    public function generarRutaDuplicado(Certificacion $certificacion,Certificacion $nuevo){
        $ver=null;
        if($certificacion){
            $tipoSer=$certificacion->Servicio->tipoServicio->id;            
            switch ($tipoSer) {
                case 1:
                    $ver= route('duplicadoInicialGnv', ['idAntiguo' =>$certificacion->id,'idNuevo'=>$nuevo->id]);                    
                break; 
                case 2:
                    $ver= route('duplicadoAnualGnv', ['idAntiguo' =>$certificacion->id,'idNuevo'=>$nuevo->id]);
                break;                
                default:                    
                    break;
            }
        }
        return $ver;
    }

    public function duplicarCertificado(){
        $servicio=ModelServicio::find($this->serv);
        if(Certificacion::findOrFail($this->servicioCertificado->id)){
            $hoja=$this->procesaFormato($this->numSugerido,$this->tipoServicio->id);
            $cert=Certificacion::create([
                "idVehiculo"=>$this->servicioCertificado->Vehiculo->id,
                "idTaller"=>$this->taller,
                "idInspector"=>Auth::id(),
                "idServicio"=>$this->serv,
                "estado"=>1,
                "precio"=>$servicio->precio,
                "pagado"=>0,
            ]);
           // $this->servicioCertificado=$cert;           
            $hoja->update(["estado"=>4]);
            $servM=ServicioMaterial::create([
                                            "idMaterial"=>$hoja->id,
                                            "idCertificacion"=>$cert->id
                                            ]);
            $this->certDuplicado=$cert;
            $this->ruta=$this->generarRutaDuplicado($this->servicioCertificado,$cert);
            $this->emit("minAlert",["titulo"=>"Buen Trabajo!","mensaje"=>"Tu certificado esta listo!","icono"=>"success",]);
        }else{
            $this->emit("minAlert",["titulo"=>"AVISO DEL SISTEMA","mensaje"=>"No se pudo realizar la certificación","icono"=>"warning"]);
        }
    }

  

    public function generarRuta(Certificacion $certificacion){        
        $ver="";
        $descargar="";
        if($certificacion){
            $tipoSer=$certificacion->Servicio->tipoServicio->id;            
            switch ($tipoSer) {
                case 1:
                    $ver= route('certificadoInicial', ['id' => $certificacion->id]);                    
                break; 
                case 2:
                    $ver= route('certificado', ['id' => $certificacion->id]);
                break;                
                default:
                    # code...
                    break;
            }
        }

        return $ver;
    }

    public function generarRutaDescarga(Certificacion $certificacion){        
        $descargar="";
        if($certificacion){
            $tipoSer=$certificacion->Servicio->tipoServicio->id;            
            switch ($tipoSer) {
                case 1:                    
                    $descargar=route('descargarInicial', ['id' => $certificacion->id]);
                break; 
                case 2:
                    $descargar=route('descargarCertificado', ['id' => $certificacion->id]);
                break;                
                default:
                    # code...
                    break;
            }
        }

        return $descargar;
    }


    public function reseteaBusquedaCert(){
        $this->servicioCertificado=null;
    }

    //revisa la existencia del vehiculo en nuestra base de datos y los devuelve en caso de encontrarlo
    public function buscarVehiculo(){
        $this->validate(['placa'=>'min:6|max:6']);

        $vehiculos=vehiculo::where('placa','like','%'.$this->placa.'%')->get();
        if($vehiculos->count() > 0){
            $this->busqueda=true;
           
            $this->vehiculos=$vehiculos;
        }else{
            $this->emit("minAlert",["titulo"=>"AVISO DEL SISTEMA","mensaje"=>"No se encontro ningún vehículo con la placa ingresada","icono"=>"warning"]);
        }
       
    }

    public function buscarCertificacion(){
        $this->validate(['placa'=>'required|min:6|max:6']);

        //implementar un switch o if else segun el servicio
        $certis=Certificacion::PlacaVehiculo($this->placa)        
        ->orderBy('created_at','desc')
        ->get();

        $certs=$certis->whereBetween("tipo_servicio",[1,2]);
                      
        if($certs->count() > 0){
            $this->busquedaCert=true;           
            $this->certificaciones=$certs;
        }else{
            $this->emit("minAlert",["titulo"=>"AVISO DEL SISTEMA","mensaje"=>"No se encontro ningúna certificación con la placa ingresada","icono"=>"warning"]);
        }
       
    }

    

    public function seleccionaVehiculo($id){
        $this->pasaDatosVehiculo($this->vehiculos[$id]);
        $this->formularioVehiculo=false;
        $this->vehiculoServicio=$this->vehiculos[$id];
        if(isset($this->vehiculoServicio->Equipos)){
            $this->equipos=$this->vehiculoServicio->Equipos;
        }
        $this->cantEquipos=$this->cuentaEquipos();
        $this->vehiculos=null;
        $this->busqueda=false;
    }

    public function seleccionaCertificacion($id){
        $certi=$this->certificaciones[$id];
        $this->servicioCertificado=$certi;
        $this->fechaCerti=$this->calculaFecha($this->servicioCertificado->created_at);       
        $this->certificaciones=null;
        $this->busquedaCert=false;
        $this->reset(['placa']);
      
    }

    public function calculaFecha($fecha){
        $dif=null;

        $hoy=Carbon::now();

        $dif=$fecha->diffInDays($hoy);
        
        return $dif;
    }

    public function cuentaEquipos(){
        $estado=false;
        $chips=$this->cuentaDis(1);
        $reg=$this->cuentaDis(2);       
        $cil=$this->cuentaDis(3);
            if($chips>0 && $reg>0 && $cil >0){
                //$this->validaVehiculo();
                $estado=true;                
            }
        return $estado;
    }

    public function pasaDatosVehiculo(vehiculo $ve){
        $this->placa=$ve->placa;
        $this->categoria=$ve->categoria;
        $this->marca=$ve->marca;       
        $this->modelo=$ve->modelo;
        $this->version=$ve->version;
        $this->anioFab=$ve->anioFab;
        $this->numSerie=$ve->numSerie;
        $this->numMotor=$ve->numMotor;
        $this->cilindros=$ve->cilindros;
        $this->cilindrada=$ve->cilindrada;
        $this->combustible=$ve->combustible;
        $this->ejes=$ve->ejes;
        $this->ruedas=$ve->ruedas;
        $this->asientos=$ve->asientos;
        $this->pasajeros=$ve->pasajeros;
        $this->largo=$ve->largo;
        $this->ancho=$ve->ancho;
        $this->altura=$ve->altura;
        $this->color=$ve->color;
        $this->pesoNeto=$ve->pesoNeto;
        $this->pesoBruto=$ve->pesoBruto;  
        $this->cargaUtil=$ve->cargaUtil;     

    }


    //selecciona una hoja segun el tipo de servicio
    public function seleccionaHojaSegunServicio($serie,$tipo){
        $hoja=null;
        switch ($tipo) {
            case 1:
                $hoja=Material::where([['numSerie',$serie],['idTipoMaterial',1],['estado',3],['idUsuario',Auth::id()]])->first();
                return $hoja;
            break;

            case 2:
                $hoja=Material::where([['numSerie',$serie],['idTipoMaterial',1],['estado',3],['idUsuario',Auth::id()]])->first();
                return $hoja;
            break;

            case 3:
                $hoja=Material::where([['numSerie',$serie],['idTipoMaterial',3],['estado',3],['idUsuario',Auth::id()]])->first();
                return $hoja;
            break;

            case 4:
                $hoja=Material::where([['numSerie',$serie],['idTipoMaterial',3],['estado',3],['idUsuario',Auth::id()]])->first();
                return $hoja;
            break;

            case 8:
                $hoja=Material::where([['numSerie',$serie],['idTipoMaterial',1],['estado',3],['idUsuario',Auth::id()]])->first();
                return $hoja;
            break;
            
            default:
                return $hoja;
                break;
        }
    }

    //valida el formato antes de enviarlo
    public function procesaFormato($numSerieFormato,$servicio){
        if($numSerieFormato){
            $hoja=$this->seleccionaHojaSegunServicio($numSerieFormato,$servicio);            
            if($hoja!=null){               
                return $hoja;
            }else{
                $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"El número de serie ingresado no corresponde con ningún formato en su poder","icono"=>"error"]);
                return null;
            }
        } else{
            $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"Número de serie no válido.","icono"=>"error"]);
            return null;
        }
    }

    public function formatoSugerido($tipo){
        $formato=Material::where([
            ["idTipoMaterial",$tipo],
            ['idUsuario',Auth::id()],
            ["estado",3],
            //['nombre',1]
        ])
        ->orderBy('numSerie','asc')    
        ->min("numSerie");    
        if(isset($formato)){
            return $formato;
        }else{
            return null;
        }                
    }
    /*
    public function numFormatoSugerido(){
        $formato=Material::where([
            ["idTipoMaterial",1],
            ['idUsuario',Auth::id()],
            ["estado",3]
        ])
        ->orderBy('numSerie','asc')->get();
        return $formato;        
    }
    */

    public function validaEquipos(){
        $estado=false;
        $chips=$this->cuentaDis(1);
        $reg=$this->cuentaDis(2);       
        $cil=$this->cuentaDis(3);
            if($chips>0 && $reg>0 && $cil >0){
                //$this->validaVehiculo();
                $estado=true;                
            }else{
                $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"Debe completar los datos de equipos para poder certificar","icono"=>"error"]);                
            }
        return $estado;
    }
    public function validaVehiculo(){
        $estado=false;
        if($this->vehiculoServicio!=null){
            //$this->validaEquipos();
            $estado=true;
        }else{
                $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"Ingrese un vehículo válido para poder certificar","icono"=>"error"]);
        }
        return $estado;
    }

    public function generaPdfAnualGnv($id){
        if(Certificacion::findOrFail($id)){
            $certificacion=Certificacion::find($id);
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $fechaCert=$certificacion->created_at;
            $fecha=$fechaCert->format('d').' días del mes de '.$meses[$fechaCert->format('m')-1].' del '.$fechaCert->format('Y').'.';     
            $hoja=$certificacion->Hoja;           
            $data=[
            "fecha"=>$fecha,
            "empresa"=>"MOTORGAS COMPANY S.A.",
            "carro"=>$certificacion->Vehiculo,
            "taller"=>$certificacion->Taller, 
            "hoja"=>$hoja, 
            "fechaCert"=>$fechaCert,
            ];                 
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('anualGnv',$data);        
            return $pdf->stream($certificacion->Vehiculo->placa.'-'.$hoja->numSerie.'-anual.pdf');
        }else{
            return abort(404);
        }
    }
    public function descargaPdfAnualGnv($id){
        if(Certificacion::findOrFail($id)){
            $certificacion=Certificacion::find($id);
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $fechaCert=$certificacion->created_at;
            $fecha=$fechaCert->format('d').' días del mes de '.$meses[$fechaCert->format('m')-1].' del '.$fechaCert->format('Y').'.';  
            $hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();              
            $data=[
            "fecha"=>$fecha,
            "empresa"=>"MOTORGAS COMPANY S.A.",
            "carro"=>$certificacion->Vehiculo,
            "taller"=>$certificacion->Taller, 
            "hoja"=>$hoja, 
            ];                 
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('anualGnv',$data);        
            return $pdf->download($certificacion->Vehiculo->placa.'-'.$hoja->numSerie.'.pdf');
        }else{
            return abort(404);
        }
    }

    public function generaPdfInicialGnv($id){
        if(Certificacion::findOrFail($id)){
            $certificacion=Certificacion::find($id);
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $fechaCert=$certificacion->created_at;
            $fecha=$fechaCert->format('d').' días del mes de '.$meses[$fechaCert->format('m')-1].' del '.$fechaCert->format('Y').'.';              
            $chip=$certificacion->vehiculo->Equipos->where("idTipoEquipo",1)->first();           
            $equipos=$certificacion->vehiculo->Equipos->where("idTipoEquipo","!=",1)->sortBy("idTipoEquipo");                     
            //dd($equipos); 
            $hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();
            $data=[
            "fecha"=>$fecha,
            "empresa"=>"MOTORGAS COMPANY S.A.",
            "carro"=>$certificacion->Vehiculo,
            "taller"=>$certificacion->Taller, 
            "hoja"=>$hoja, 
            "equipos"=>$equipos,
            "chip"=>$chip,
            "fechaCert"=>$fechaCert,
            ];                 
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('conversionGnv',$data);        
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->stream($certificacion->Vehiculo->placa.'-'.$hoja->numSerie.'-inicial.pdf');
        }else{
            return abort(404);
        }
    }

    public function descargaPdfInicialGnv($id){
        if(Certificacion::findOrFail($id)){
            $certificacion=Certificacion::find($id);
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $fechaCert=$certificacion->created_at;
            $fecha=$fechaCert->format('d').' días del mes de '.$meses[$fechaCert->format('m')-1].' del '.$fechaCert->format('Y').'.';              
            $chip=$certificacion->vehiculo->Equipos->where("idTipoEquipo",1)->first();           
            $equipos=$certificacion->vehiculo->Equipos->where("idTipoEquipo","!=",1)->sortBy("idTipoEquipo");                     
            //dd($equipos); 
            $hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();
            $data=[
            "fecha"=>$fecha,
            "empresa"=>"MOTORGAS COMPANY S.A.",
            "carro"=>$certificacion->Vehiculo,
            "taller"=>$certificacion->Taller, 
            "hoja"=>$hoja, 
            "equipos"=>$equipos,
            "chip"=>$chip,
            ];                 
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('conversionGnv',$data);        
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->download($certificacion->Vehiculo->placa.'-'.$hoja->numSerie.'.pdf');
        }else{
            return abort(404);
        }
    }

   
}

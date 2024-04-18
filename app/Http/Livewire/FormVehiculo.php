<?php

namespace App\Http\Livewire;

use App\Models\vehiculo;
use Livewire\Component;

class FormVehiculo extends Component
{

    public $nombreDelInvocador;

    //VARIABLES DEL VEHICULO
    public $placa,$categoria,$marca,$modelo,$version,$anioFab,$numSerie,$numMotor,
    $cilindros,$cilindrada,$combustible,$ejes,$ruedas,$asientos,$pasajeros,
    $largo,$ancho,$altura,$color,$pesoNeto,$pesoBruto,$cargaUtil;

    //VARIABLES DEL COMPONENTE
    public vehiculo $vehiculo;
    public $estado,$vehiculos,$busqueda,$tipoServicio;

    public function mount(){
        $this->estado="nuevo";
        //$this->vehiculo=vehiculo::make();
    }

    protected $rules=[

        "placa"=>"required|min:6|max:7",
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

        "vehiculo.placa"=>"required|min:6",
        "vehiculo.categoria"=>"nullable",
        "vehiculo.marca"=>"required|min:2",
        "vehiculo.modelo"=>"required|min:2",
        "vehiculo.version"=>"nullable",
        "vehiculo.anioFab"=>"nullable|numeric|min:1900",
        "vehiculo.numSerie"=>"nullable|min:2",
        "vehiculo.numMotor"=>"nullable|min:2",
        "vehiculo.cilindros"=>"nullable|numeric|min:1",
        "vehiculo.cilindrada"=>"nullable|numeric|min:1",
        "vehiculo.combustible"=>"nullable|min:2",
        "vehiculo.ejes"=>"nullable|numeric|min:1",
        "vehiculo.ruedas"=>"nullable|numeric|min:1",
        "vehiculo.asientos"=>"nullable|numeric|min:1",
        "vehiculo.pasajeros"=>"nullable|numeric|min:1",
        "vehiculo.largo"=>"nullable|numeric",
        "vehiculo.ancho"=>"nullable|numeric",
        "vehiculo.altura"=>"nullable|numeric",
        "vehiculo.color"=>"nullable|min:2",
        "vehiculo.pesoNeto"=>"nullable|numeric",
        "vehiculo.pesoBruto"=>"nullable|numeric",
        "vehiculo.cargaUtil"=>"nullable|numeric",
    ];

    public function render()
    {
        return view('livewire.form-vehiculo');
    }

    public function guardaVehiculo(){
        $this->validate(
            [
                "placa"=>"required|min:6|max:7",
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
                "cargaUtil"=>"nullable|numeric"
            ]
        );

        if(
        $vehiculo=vehiculo::create(
            [
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

                                    ]
        )){
            $this->vehiculo=$vehiculo;
            $this->estado='cargado';
            $this->emit("minAlert",["titulo"=>"¡BUEN TRABAJO!","mensaje"=>'El vehículo con placa '.$vehiculo->placa.' se registro correctamente.',"icono"=>"success"]);
            if($this->nombreDelInvocador!=null){
                $this->emitTo($this->nombreDelInvocador,'cargaVehiculo',$vehiculo->id);
            }else{
                $this->emitTo('prueba','cargaVehiculo',$vehiculo->id);
            }


        }else{
            $this->emit("minAlert",["titulo"=>"AVISO DEL SISTEMA","mensaje"=>"Ocurrio un error al guardar los datos del vehículo","icono"=>"warning"]);
        }


    }

    public function actualizarVehiculo(){
        $this->validate(
            [
                "vehiculo.placa"=>"required|min:6|max:7",
                "vehiculo.categoria"=>"nullable",
                "vehiculo.marca"=>"required|min:2",
                "vehiculo.modelo"=>"required|min:2",
                "vehiculo.version"=>"nullable",
                "vehiculo.anioFab"=>"nullable|numeric|min:1900",
                "vehiculo.numSerie"=>"nullable|min:2",
                "vehiculo.numMotor"=>"nullable|min:2",
                "vehiculo.cilindros"=>"nullable|numeric|min:1",
                "vehiculo.cilindrada"=>"nullable|numeric|min:1",
                "vehiculo.combustible"=>"nullable|min:2",
                "vehiculo.ejes"=>"nullable|numeric|min:1",
                "vehiculo.ruedas"=>"nullable|numeric|min:1",
                "vehiculo.asientos"=>"nullable|numeric|min:1",
                "vehiculo.pasajeros"=>"nullable|numeric|min:1",
                "vehiculo.largo"=>"nullable|numeric",
                "vehiculo.ancho"=>"nullable|numeric",
                "vehiculo.altura"=>"nullable|numeric",
                "vehiculo.color"=>"nullable|min:2",
                "vehiculo.pesoNeto"=>"nullable|numeric",
                "vehiculo.pesoBruto"=>"nullable|numeric",
                "vehiculo.cargaUtil"=>"nullable|numeric",
            ]
        );

        if(
        $this->vehiculo
        ->update([
            "placa"=>strtoupper($this->vehiculo->placa),
            "categoria"=>strtoupper($this->vehiculo->categoria),
            "marca"=>$this->retornaNE($this->vehiculo->marca),
            "modelo"=>$this->retornaNE($this->vehiculo->modelo),
            "version"=>$this->retornaSV($this->vehiculo->version),

            //considerar en el PDF
            "anioFab"=>$this->retornaNulo($this->vehiculo->anioFab),
            //considerar en el PDF

            "numSerie"=>$this->retornaNE($this->vehiculo->numSerie),
            "numMotor"=>$this->retornaNE($this->vehiculo->numMotor),


            //considerar en el PDF
            "cilindros"=>$this->retornaNulo($this->vehiculo->cilindros),
            "cilindrada"=>$this->retornaNulo($this->vehiculo->cilindrada),
            //considerar en el PDF


            "combustible"=>$this->retornaNE($this->vehiculo->combustible),

            //considerar en el PDF
            "ejes"=>$this->retornaNulo($this->vehiculo->ejes),
            "ruedas"=>$this->retornaNulo($this->vehiculo->ruedas),
            "asientos"=>$this->retornaNulo($this->vehiculo->asientos),
            "pasajeros"=>$this->retornaNulo($this->vehiculo->pasajeros),
            //considerar en el PDF


            //considerar en el PDF
            "largo"=>$this->retornaNulo($this->vehiculo->largo),
            "ancho"=>$this->retornaNulo($this->vehiculo->ancho),
            "altura"=>$this->retornaNulo($this->vehiculo->altura),
            //considerar en el PDF

            "color"=>$this->retornaNE($this->vehiculo->color),

            //considerar en el PDF
            "pesoNeto"=>$this->retornaNulo($this->vehiculo->pesoNeto),
            "pesoBruto"=>$this->retornaNulo($this->vehiculo->pesoBruto),
            "cargaUtil"=>$this->retornaNulo($this->vehiculo->cargaUtil),
        ])){
            $this->estado='cargado';
            $this->emit("minAlert",["titulo"=>"¡BUEN TRABAJO!","mensaje"=>"Datos del vehículo actualizados correctamente","icono"=>"success"]);
        } else{
            $this->emit("minAlert",["titulo"=>"AVISO DEL SISTEMA","mensaje"=>"Ocurrio un error al actualizar los datos del vehículo","icono"=>"warning"]);
        }


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
        if($value){
            return $value;
        }else{
            return Null;
        }
    }

    //revisa la existencia del vehiculo en nuestra base de datos y los devuelve en caso de encontrarlo
    public function buscarVehiculo(){
        $this->validate(['placa'=>'min:3|max:7']);

        $vehiculos=vehiculo::where('placa','like','%'.$this->placa.'%')->get();
        if($vehiculos->count() > 0){
            $this->busqueda=true;
            $this->vehiculos=$vehiculos;
        }else{
            $this->emit("minAlert",["titulo"=>"AVISO DEL SISTEMA","mensaje"=>"No se encontro ningún vehículo con la placa ingresada","icono"=>"warning"]);
        }

    }

    public function seleccionaVehiculo(vehiculo $veh){
        $this->vehiculo=$veh;
        $this->estado='cargado';
        if($this->nombreDelInvocador!=null){
            $this->emitTo($this->nombreDelInvocador,'cargaVehiculo',$veh->id);
        }else{
            $this->emitTo('prueba','cargaVehiculo',$veh->id);
        }
        $this->vehiculos=null;
        $this->busqueda=false;
    }
}

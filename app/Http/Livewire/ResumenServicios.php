<?php

namespace App\Http\Livewire;

use App\Models\CertifiacionExpediente;
use App\Models\Certificacion;
use App\Models\TipoServicio;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Livewire\Component;

class ResumenServicios extends Component
{
    public $servicios,$total,$mensaje,$cantServicios,$fecha,$cantidad,$monto,$periodo;

    public array $dataset = [];
    public array $labels = [];  
    public array $data = [];
    public array $colores = [];  
    public array $bordes = [];

    public function mount(){       
        $this->fecha=$this->inicioFinDia(Carbon::now());
        $this->periodo=1;
        $this->cargaDatos();
        $this->formateaChart();     
    }



    public function render()
    {  
        return view('livewire.resumen-servicios');
    }

    public function formateaChart(){
        $this->mensaje='Servicios';
        //$this->labels = ['Por revisar','Observados','Desaprobados','Aprobados'];
        $this->colores= [            
            'rgba(210,220,255)',           
        ];
        $this->bordes= [            
            'rgb(96, 72, 250)',                  
        ];
        $this->dataset = [
            [
                'label' => $this->mensaje,               
                'data' =>$this->data,
                'backgroundColor'=>$this->colores,
                'borderColor'=>$this->bordes,
                'borderWidth'=>1 ,
            ],            
        ]; 
        
    }

    public function updatedPeriodo($value){
        switch ($value) {
            case 1:
                $this->fecha=$this->inicioFinDia(Carbon::now());
                $this->cargaDatos();
                $this->formateaChart();
                $this->emit("updateChart1",$this->dataset);
            break;
            case 2:
                $this->fecha=$this->inicioFinSemana(Carbon::now()->format('d-m-Y'));
                $this->cargaDatos();
                $this->formateaChart();
                $this->emit("updateChart1",$this->dataset);
            break;

            case 3:
                $this->fecha=$this->inicioFinMes(Carbon::now());
                $this->cargaDatos();
                $this->formateaChart();
                $this->emit("updateChart1",$this->dataset);
            break;
            
            default:
                # code...
                break;
        }
    }

    public function cargaDatos(){       
      $tipos=TipoServicio::all();
      $this->servicios=Certificacion::rangoFecha($this->fecha["fechaInicio"],$this->fecha["fechaFin"])->get();

      $this->cantidad=$this->servicios->count();
      $this->monto=$this->servicios->sum('precio');
      $data=[];     
      foreach($tipos as $tipo){
        $servicioTipo=Certificacion::tipoServicio($tipo->id)
            ->rangoFecha($this->fecha["fechaInicio"],$this->fecha["fechaFin"])
            ->get();
        if($servicioTipo->count()>0){
            array_push($this->labels,$tipo->descripcion);
            $cantidad=$servicioTipo->count();            
            $monto=$servicioTipo->sum('precio');            
            array_push($data,["id"=>$tipo->descripcion.':  S/ '.$monto,"nested"=>["value"=>$cantidad]]);            
        } 
        $this->data=$data;       
      }
    }
   
    public function inicioFinSemana($fecha){

        $diaInicio="Monday";
        $diaFin="Sunday";
    
        $strFecha = strtotime($fecha);
    
        $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
        $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
    
        if(date("l",$strFecha)==$diaInicio){
            $fechaInicio= date("Y-m-d",$strFecha);
        }
        if(date("l",$strFecha)==$diaFin){
            $fechaFin= date("Y-m-d",$strFecha);
        }
        return Array("fechaInicio"=>$fechaInicio,"fechaFin"=>$fechaFin);
    }

    public function inicioFinMes($fechaActual){
        $mes=$fechaActual->format('M');
        $año=$fechaActual->format('Y');
        $primerDia= new Carbon('first day of '.$mes.' '.$año);        
        $ultimoDia= new Carbon('last day of '.$mes.' '.$año);
        return Array("fechaInicio"=>$primerDia->format('Y-m-d'),"fechaFin"=>$ultimoDia->format('Y-m-d'));
    }

    public function inicioFinDia($fechaActual){        
        $inicioDia= $fechaActual->format('Y-m-d')." 00:00:00";        
        $finDia= $fechaActual->format('Y-m-d')." 23:59:59";
        return Array("fechaInicio"=>$inicioDia,"fechaFin"=>$finDia);
    }


}

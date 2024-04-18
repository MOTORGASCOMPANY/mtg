<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Certificacion;
use App\Models\ServiciosImportados;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteGeneralGnv extends Component
{
    use WithPagination;

    public $sort,$direction,$cant,$search,$permiso,$fechaInicio='',$fechaFin='',$inspectores,$ins='',$taller,$talleres,$data=[],$total;

    public $editando=false;

    protected $queryStrings=['search'=>['except'=>'']];
    
    protected $rules=[
                        "ins"=>"nullable|string|min:3",
                        "taller"=>"nullable|min:3",
                        "fechaInicio"=>"required|date",
                        "fechaFin"=>"required|date",
                    ];

    protected $listeners=["render"];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;   
        $this->inspectores=ServiciosImportados::groupBy('certificador')->pluck('certificador');
        $this->talleres=ServiciosImportados::groupBy('taller')->pluck('taller');     
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $importados=DB::table('certificacion') 
        ->select('si.*')             
        ->join('vehiculo', 'certificacion.idVehiculo', '=', 'vehiculo.id')
        ->join('servicio','certificacion.idServicio','=','servicio.id')
        ->join('tiposervicio', 'tiposervicio.id', '=', 'servicio.tipoServicio_idtipoServicio')
        ->join('users','users.id','=','certificacion.idInspector')
        ->join('taller','taller.id','=','servicio.idTaller')
        ->join('servicios_importados as si','si.placa','=','vehiculo.placa');       
        return view('livewire.reportes.reporte-general-gnv',compact('importados'));
    }

    public function generarReporte(){
        $total=0;
        $encontrados= new Collection();
        $this->validate();    
        $ser_mtg=$this->listaServiciosMtg($this->fechaInicio,$this->fechaFin,$this->taller,$this->ins);   
        $serv_gas =$this->listaServiciosGasolution($this->fechaInicio,$this->fechaFin,$this->taller,$this->ins);
        foreach($serv_gas as $servicio){
            //dd($ser_mtg->first());
            $total+=$servicio->precio;
            $servicio_mtg=$ser_mtg->where("placa",$servicio->placa);
            if(!empty($servicio)){                
                $encontrados->push(["serv_mtg"=>$servicio_mtg->first(),"serv_gas"=>$servicio]);
            }
        }
        $this->total=$total;
        $this->data=$encontrados;
    }

    public function listaServiciosMtg($fechaIni,$fechaFin,$taller,$inspector){
        $servicios_mtg=
        DB::table('certificacion as c') 
        ->select('c.id','u.name as inspector','t.nombre as taller','v.placa','ts.descripcion as servicio','c.created_at','ts.id as tipo_servicio','s.precio','c.estado')             
        ->join('vehiculo as v', 'c.idVehiculo', '=', 'v.id')
        ->join('servicio as s','c.idServicio','=','s.id')
        ->join('tiposervicio as ts', 'ts.id', '=', 's.tipoServicio_idtipoServicio')
        ->join('users as u','u.id','=','c.idInspector')
        ->join('taller as t','t.id','=','c.idTaller')
        ->where('c.estado',1)  
        ->whereIn("ts.id",[1,2,7,10,12]) //SOLO SERVICIOS DE TIPO GNV CERTIFICABLES
        ->whereBetween('c.created_at',[$fechaIni." 00:00",$fechaFin." 23:59"])    
        ->get();
       
        if(!empty($taller)){
            $servicios_mtg=$servicios_mtg->where("taller",$taller);      
            //dd($servicios_mtg);     
        }
        if(!empty($inspector)){            
            $servicios_mtg=$servicios_mtg->where("inspector",$inspector);
            //dd($servicios_mtg);
        }

        return $servicios_mtg;
    }
    
    public function listaServiciosGasolution($fechaIni,$fechaFin,$taller,$inspector){
        $servicios_gasolution=ServiciosImportados::whereBetween("fecha",[$fechaIni." 00:00",$fechaFin." 23:59"]);
        if(!empty($taller)){
            $servicios_gasolution=$servicios_gasolution->where("taller",$taller);      
            //dd($servicios_mtg);     
        }
        if(!empty($inspector)){            
            $servicios_gasolution=$servicios_gasolution->where("certificador",$inspector);
            //dd($servicios_mtg);
        }
        return $servicios_gasolution->get();
    }

    public function actualizaData(){        
        
        $encontrados=new Collection();

        $servicios_mtg=DB::table('certificacion as c') 
        ->select('c.id','u.name as inspector','t.nombre as taller','v.placa','ts.descripcion as servicio','c.created_at','ts.id as tipo_servicio','s.precio','c.estado')             
        ->join('vehiculo as v', 'c.idVehiculo', '=', 'v.id')
        ->join('servicio as s','c.idServicio','=','s.id')
        ->join('tiposervicio as ts', 'ts.id', '=', 's.tipoServicio_idtipoServicio')
        ->join('users as u','u.id','=','c.idInspector')
        ->join('taller as t','t.id','=','c.idTaller')
        ->where('c.estado',1)      
        ->get();
        
        $imports=ServiciosImportados::all();   
           
        foreach($imports as $servicio){
            $servicio_mtg=$servicios_mtg->where("placa",$servicio->placa);
            if($servicio_mtg != null){
                dd($servicio_mtg);
                $encontrados->push($servicio_mtg);
            }
        }
        $this->data=$encontrados;
    }

    



    public function order($sort)
    {
        if($this->sort=$sort){
            if($this->direction=='desc'){
                $this->direction='asc';
            }else{
                $this->direction='desc';
            }
        }else{
            $this->sort=$sort;
            $this->direction='asc';
        }        
    }
}


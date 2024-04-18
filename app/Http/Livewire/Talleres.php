<?php

namespace App\Http\Livewire;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Imagen;
use App\Models\Provincia;
use App\Models\Servicio;
use App\Models\Taller;
use App\Models\TipoServicio;
use Doctrine\Inflector\Rules\English\Rules;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Talleres extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $sort,$order,$cant,$search,$direction,$editando,$taller,$open; 
    public $serviciosTaller=[];

    public $departamentosTaller,$provinciasTaller,$distritosTaller,$logoTaller,$firmaTaller;

    public $logoNuevo=null;
    public $firmaNuevo=null;

    public $departamentoSel=Null;
    public $provinciaSel=Null;
    public $distritoSel=Null;

    public $index;
    public $agregando=false;
    public $serviciosNuevos;
    public $serviciosDisponibles;

    //protected $queryStrings=['search'=>['except'=>null]];

    public function mount(){
      $this->direction='desc';
      $this->sort='id';       
      $this->cant=10;
      $this->open=false;
      $this->index=rand();
      $this->serviciosNuevos= new Collection();
      $this->departamentosTaller=Departamento::all();
    }

    protected $rules=[
      'taller.nombre'=>'required|min:5',
      'taller.direccion'=>'required|min:5',
      'taller.ruc'=>'required|digits:11',
      'taller.representante'=>'required|min:5',
      'taller.idDistrito'=>'required',
      'taller.servicios.*.estado'=> 'nullable',
      'taller.servicios.*.precio'=> 'required|numeric',
      'logoNuevo'=>'nullable|mimes:jpg,bmp,png,jpeg,tif,tiff',
      'firmaNuevo'=>'nullable|mimes:jpg,bmp,png,jpeg,tif,tiff',
      'serviciosNuevos.*.estado'=>'nullable',
      'serviciosNuevos.*.taller_idtaller'=>'numeric',
      'serviciosNuevos.*.tipoServicio_idtipoServicio'=>'numeric',
      'serviciosNuevos.*.precio'=>'nullable|numeric',

    ];

    public function render()
    {
        //$files=Imagen::where('Expediente_idExpediente','=',367)->whereIn('extension',['jpg','jpeg','png','gif','tif','tiff','bmp'])->get();
        $talleres=Taller::where('nombre','like','%'.$this->search.'%')
                        ->orWhere('ruc','like','%'.$this->search.'%')          
                        ->orderBy($this->sort,$this->direction)
                        ->paginate($this->cant);
        return view('livewire.talleres',compact('talleres'));
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function cargaServiciosTaller($id){
            $this->serviciosTaller=DB::table('servicio') 
            ->select('servicio.*', 'tiposervicio.descripcion')             
            ->join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
            ->where('taller_idtaller',$id)
            ->get();
    }
    

    public function edit(Taller $tal){          
       $this->reset(["logoTaller","firmaTaller"]);
        $this->index=rand();
        if($tal->idDistrito!=null) {
            $dist=Distrito::find($tal->idDistrito);
            $prov=Provincia::find($dist->idProv);
            $depa=Departamento::find($prov->idDepa);        
            
            $this->departamentoSel=$depa->id;
            $this->updatedDepartamentoSel($depa->id);
            $this->provinciaSel=$prov->id;
            $this->updatedProvinciaSel($prov->id);
        }else{
          $this->reset(["departamentoSel","provinciaSel","distritoSel"]);          
        }
        if($tal->rutaFirma){
            $this->firmaTaller=$tal->rutaFirma;
        }
        if($tal->rutaLogo){
            $this->logoTaller=$tal->rutaLogo;
        }      
          $this->taller=$tal;
          $this->editando=true;         
       
    }

    public function updatedEditando(){
        $this->reset(["logoNuevo","firmaNuevo"]);
    }

    public function updatedDepartamentoSel($depa){        
        $this->provinciasTaller=Provincia::where("idDepa",$depa)->get();  
        $this->provinciaSel=null;  
         
    }

    public function updatedProvinciaSel($prov){        
        $this->distritosTaller=Distrito::where("idProv",$prov)->get();               
        $this->distritoSel=null;          
    }

    public function actualizar(){
        
        $this->validate();
        if($this->logoNuevo){
            //Storage::delete($this->taller->rutaLogo);  
            $rutaLogo=$this->logoNuevo->storeAs('public/Logos','logo-'.$this->taller->ruc.'.'.$this->logoNuevo->extension());  
            $this->taller->rutaLogo=$rutaLogo;
        }

        if($this->firmaNuevo){
            //Storage::delete($this->taller->rutaFirma);
            $rutaFirma=$this->firmaNuevo->storeAs('public/Firmas','firma-'.$this->taller->ruc.'.'.$this->firmaNuevo->extension()); 
            $this->taller->rutaFirma=$rutaFirma;
        }

        $this->taller->save();

        foreach($this->taller->servicios as $ser){                
               
                if($ser->isDirty()){
                    $ser->save();
                }
        }
        $this->reset(['editando']);
        $this->emit('alert','Los datos del taller se actualizaron correctamente.');

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

    protected $listeners=['render'];

    public function agregarServicios(Taller $taller){
        $this->serviciosNuevos=new Collection();
        $this->reset(['serviciosDisponibles','taller']);

        $this->taller=$taller;        
        $this->serviciosDisponibles=$this->obtieneServiciosDisponibles($taller);
       //$dis=$this->obtieneServiciosDisponibles($taller);
        $this->creaNuevosServicios($this->serviciosDisponibles);
        $this->agregando=true;
    }


    public function obtieneServiciosDisponibles(Taller $taller){
        
        $usados=$taller->servicios->pluck('tipoServicio_idtipoServicio')->toArray();
        $servicios=TipoServicio::all();
        $disp=$servicios->except($usados);      
        return $disp;
    }

    public function creaNuevosServicios($tipos){
        foreach($tipos as $tipo){
            $servicio= new Servicio();
            $servicio->estado=0;
            $servicio->precio=null;
            $servicio->taller_idtaller=$this->taller->id;
            $servicio->tipoServicio_idtipoServicio=$tipo->id;
            $this->serviciosNuevos->push($servicio);
        }
    }

    public function guardarServicios(){
        $nuevos= new Collection();
        $rules=[];
        foreach($this->serviciosNuevos as $eky=>$servicio){
            if($servicio->estado==1){    
               $rules+=["serviciosNuevos.".$eky.".precio"=>"numeric"];           
            }
        }
        if(count($rules)){
            $this->validate($rules);
        }
        
        foreach($this->serviciosNuevos as $eky=>$servicio){
            if($servicio->estado==1){                               
                $servicio->save();
                $nuevos->push($servicio);
            }
        }
        $this->serviciosNuevos=new Collection();
        $this->reset(['serviciosDisponibles','taller']);
        $this->index=rand();
        $this->agregando=false;
        if($nuevos->count()>1){
            $this->emit("minAlert",["titulo"=>"¡BUEN TRABAJO!","mensaje"=>"se agregaron correctamente ".$nuevos->count()." servicios","icono"=>"success"]);
        }else{
            $this->emit("minAlert",["titulo"=>"¡AVISO!","mensaje"=>"Debes seleccionar al menos un servicio para registrar","icono"=>"warning"]);
        }
        
    }

    protected $messages = [
        //'precios.*.min' => 'Ingrese un precio valido', 
        'serviciosNuevos.*.precio.numeric' => 'Ingrese un precio valido.'      
    ]; 

    public function updatedAgregando(){
        $this->reset(['serviciosDisponibles','taller','serviciosNuevos']);
    }

    //Para que me rediriga a la vista editar-taller
    public function redirectEditarTaller($idTaller)
    {
        return Redirect::to("Taller/edit/{$idTaller}");
    }

}

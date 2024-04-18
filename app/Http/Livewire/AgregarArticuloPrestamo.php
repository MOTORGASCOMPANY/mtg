<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\TipoMaterial;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AgregarArticuloPrestamo extends Component
{

    public $open=false;
    public $stockGlp,$stockGnv,$stockChips,$nombreTipo,$tiposMateriales;
    public $stockModi;//variables faltantes(modi)

    public $cantidad,$numInicio,$numFinal,$tipoM=0,$motivo="Prestamo de material";

    public  $articulos=[];

    public $stocks= [ ];

    public Collection $disponibles;

    protected $rules=[
        "tipoM"=>"required|numeric",
        //"motivo"=>"required|min:3","cantidad"=>"required",
    ];



    public function render()
    {
        return view('livewire.agregar-articulo-prestamo');
    }

    public function mount(){
        $this->tiposMateriales=TipoMaterial::all()->sortBy("descripcion");
       // $this->disponibles=new Collection();
        $this->listaStock();
    }

    public function listaStock(){
        $materiales=TipoMaterial::all();
        foreach($materiales as $key=>$material){
            if(count($this->disponibles)){
                $lista=$this->disponibles->where('idTipoMaterial',$material->id);
            }else{
                $lista=[];
            }
            $this->stocks+=[$material->descripcion=>count($lista)];
        }
    }

    public function updatedCantidad(){
        //Muestra el formato con el numeroSerie mas bajo segun el Tipo de Material y Grupo Seleccionado
        if($this->validateOnly("cantidad")){
            $num=$this->disponibles->where('idTipoMaterial',$this->tipoM)->sortBy("numSerie")->min("numSerie");
            //dd($num);
                $this->numInicio=$num;
        }
    }



    public function updated($propertyName){

        switch ($this->tipoM) {
            case 1:
                    $cant=$this->disponibles->where("idTipoMaterial",$this->tipoM)->count();
                    //dd($cant);
                    if (array_key_exists("cantidad",$this->rules)){
                        $this->rules["cantidad"]="required|numeric|min:1|max:".$cant;
                    }else{
                        $this->rules+=["cantidad"=>'required|numeric|min:1|max:'.$cant];
                    }

            break;
            case 2:
                $this->rules+=["cantidad"=>'required|numeric|min:1|max:'.$this->stocks["CHIP"]];
                break;
            case 3:
                $cant=$this->disponibles->where("idTipoMaterial",$this->tipoM)->count();
                    //dd($cant);
                    if (array_key_exists("cantidad",$this->rules)){
                        $this->rules["cantidad"]="required|numeric|min:1|max:".$cant;
                    }else{
                        $this->rules+=["cantidad"=>'required|numeric|min:1|max:'.$cant];
                    }
            break;
            case 4:               
                $cant=$this->disponibles->where("idTipoMaterial",$this->tipoM)->count();
                //dd($cant);                                       
                if (array_key_exists("cantidad",$this->rules)){
                    $this->rules["cantidad"]="required|numeric|min:1|max:".$cant;
                }else{
                    $this->rules+=["cantidad"=>'required|numeric|min:1|max:'.$cant];
                }
            
            break;
            default:
               //$this->guias=new Collection();
            break;
        }


        if($propertyName=="cantidad" && $this->numInicio>0){
            if($this->cantidad){
                $this->numFinal=$this->numInicio+($this->cantidad-1);
            }else{
                $this->numFinal=0;
            }
        }
        if($propertyName=="numInicio" && $this->cantidad>0){

            if($this->numInicio){
                $this->numFinal=$this->numInicio+($this->cantidad-1);
            }
        }
        $this->validateOnly($propertyName);
    }

    public function addArticulo(){
        $temp=new Collection();
        switch ($this->tipoM) {
            case 1:
                $temp = $this->validaSeries();
                if ($temp->count() > 0) {
                    // $this->emit("minAlert",["titulo"=>"TODO OK","mensaje"=>"BIEN HECHO ".$temp->count(),"icono"=>"success"]);
                    $articulo = array("tipo" => $this->tipoM, "nombreTipo" => $this->nombreTipo, "cantidad" => $this->cantidad, "inicio" => $this->numInicio, "final" => $this->numFinal, "motivo" =>"Prestamo de Materiales");
                    $this->emit('agregarArticulo', $articulo);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'numInicio', 'numFinal']);
                    $this->open = false;
                    $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El articulo se añadio Correctamente", "icono" => "success"]);
                    //$this->reset(["grupo"]);
                } else {
                    $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Las series seleccionadas ya fueron agregadas o no estan en su poder", "icono" => "error"]);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'numInicio', 'numFinal']);
                }
            break;

            case 2:
                $rule = ["cantidad" => 'required|numeric|min:1|max:' . $this->stocks["CHIP"]];
                if($this->validate($rule)){
                    $articulo = array("tipo" => $this->tipoM, "nombreTipo" => $this->nombreTipo, "cantidad" => $this->cantidad, "inicio" => "N/A", "final" => "N/A", "motivo" =>"Prestamo de Materiales");
                    $this->emit('agregarArticulo', $articulo);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'numInicio', 'numFinal']);
                    $this->open = false;
                    $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El articulo se añadio Correctamente", "icono" => "success"]);
                    //$this->reset(["grupo"]);
                } else {
                    $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Ocurrio un error a la agregar CHIPS ", "icono" => "error"]);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'numInicio', 'numFinal']);
                }
            break;

            case 3:
                $temp=$this->validaSeries();
                if($temp->count()>0){
                   // $this->emit("minAlert",["titulo"=>"TODO OK","mensaje"=>"BIEN HECHO ".$temp->count(),"icono"=>"success"]);
                    $articulo= array("tipo"=>$this->tipoM,"nombreTipo"=>$this->nombreTipo,"cantidad"=>$this->cantidad,"inicio"=>$this->numInicio,"final"=>$this->numFinal,"motivo"=>"Prestamo de Materiales");
                    $this->emit('agregarArticulo',$articulo);
                    $this->reset(['tipoM','motivo','cantidad','numInicio','numFinal']);
                    $this->open=false;
                    $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El articulo se añadio Correctamente","icono"=>"success"]);
                    //$this->reset(["grupo"]);
                }else{
                    $this->emit("minAlert",["titulo"=>"ERROR","mensaje"=>"Las series seleccionadas ya fueron agregadas o no estan en su poder","icono"=>"error"]);
                    $this->reset(['tipoM','motivo','cantidad','numInicio','numFinal']);

                }
            break;
            case 4:                
                $temp = $this->validaSeries();
                if ($temp->count() > 0) {
                    // $this->emit("minAlert",["titulo"=>"TODO OK","mensaje"=>"BIEN HECHO ".$temp->count(),"icono"=>"success"]); 
                    $articulo = array("tipo" => $this->tipoM, "nombreTipo" => $this->nombreTipo, "cantidad" => $this->cantidad, "inicio" => $this->numInicio, "final" => $this->numFinal, "motivo" =>"Prestamo de Materiales");
                    $this->emit('agregarArticulo', $articulo);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'numInicio', 'numFinal']);
                    $this->open = false;
                    $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El articulo se añadio Correctamente", "icono" => "success"]);
                    //$this->reset(["grupo"]);
                } else {
                    $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Las series seleccionadas ya fueron agregadas o no estan en su poder", "icono" => "error"]);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'numInicio', 'numFinal']);
                }
            break;

            default:
                $rule = ["cantidad" => 'required|numeric|min:1'];
                break;
        }

    }

    public function creaColeccion($inicio,$fin){
        return range($inicio, $fin);
    }

    public function validaSeries(){
        $result= new Collection();
        if($this->tipoM==1 || $this->tipoM==3 || $this->tipoM==4){
            if($this->numInicio && $this->numFinal){
                $series=$this->creaColeccion($this->numInicio,$this->numFinal);
                $mat=$this->disponibles->pluck('numSerie');
                $result=$mat->intersect($series);
            }
        }
        return $result;
        //$result = collect();
    }


}

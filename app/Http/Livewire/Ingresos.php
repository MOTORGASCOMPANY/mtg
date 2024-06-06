<?php

namespace App\Http\Livewire;

use App\Models\Ingreso;
use App\Models\TipoMaterial;
use Livewire\Component;
use Livewire\WithPagination;

class Ingresos extends Component
{

    use WithPagination;
    
    public $cant,$sort,$direction,$search,$ingreso,$details;
    public $editando=false;
    public $mat, $tipos;

    
    public function mount(){
        $this->sort="id";
        $this->direction="desc";
        $this->tipos = TipoMaterial::all();
    }

    protected $listeners=['render','delete','deleteFile'];

    

    public function render()
    {
        $ingresos=Ingreso::where('estado',1)
        ->when($this->mat, function ($query) {
            $query->whereHas('materiales.tipo', function ($query) {
                $query->where('id', $this->mat);
            });
        })
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        //return view('livewire.ingresos',compact("ingresos"));
        return view('livewire.ingresos', [
            'ingresos' => $ingresos,
            'tipos' => $this->tipos,
        ]);
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

    public function edit(Ingreso $ing){
        $this->ingreso=$ing;
        //$this->details=$this->detalle($ing);
        $this->editando=true;
    }

    public function eliminaMateriales(Ingreso $ingreso){
        foreach($ingreso->materiales as $material){
            $material->delete();
        }
    }


    public function delete(Ingreso $ingres){
        $this->eliminaMateriales($ingres);
        $ingres->delete();
        
        $this->emitTo('ingresos','render');
    }

    public function validaEstadoMateriales(Ingreso $ingreso){
        $sinMod=$ingreso->materiales->where("estado",1)->count();
        $total=$ingreso->materiales->count();
        if($sinMod==$total){
            $this->emit('deleteIngreso',$ingreso->id);
        }else{
            $this->emit("CustomAlert",["titulo"=>"ERROR","mensaje"=>"No puedes eliminar este registro, ya que 1 o mas materiales se encuentran en uso.","icono"=>"error",]); 
        }
        
    }



    /*
    public function detalle($ing){
        $aux=[];
        $var="";
        $contador=0;
        if($ing->id!=null){
            
            foreach($ing->materiales as $material){
                if($material->tipo->descripcion!=$var){
                    $var=$material->tipo->descripcion;
                }
                array_push($aux,$material->tipo->descripcion);                
            }            
            $a=array_count_values($aux);
            $o=[];
            array_push($o,array("tipo"=>$var,"cantidad"=>$a));
        }

        return $a;
    }
    */

    
}

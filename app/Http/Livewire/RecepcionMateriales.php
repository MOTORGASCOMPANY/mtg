<?php

namespace App\Http\Livewire;

use App\Models\Salida;
use App\Models\TipoMaterial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecepcionMateriales extends Component
{
    public $recepcion,$materiales,$acepto;
    public $open=false;

    public function mount(){
        //$this->recepcion=Salida::make();
    }

    public function render()
    {
        $recepciones=Salida::where([
            ['idUsuarioAsignado',Auth::id()],
            ['estado',1]
            ])
                        ->orderBy("created_at","desc")
                        ->get();
        return view('livewire.recepcion-materiales',compact("recepciones"));
    }

    public function recepcionar(Salida $salida){
        if($salida->id!=null){
         $this->recepcion=$salida;
         $this->materiales=$this->cuentaMateriales($salida->materiales);
        }
        $this->open=true;
    }

    /*public function cuentaMateriales($materiales){
        $end=[];
        $tipos=TipoMaterial::All();    
        $aux=$materiales->toArray();       
        $mat=array_column($aux, 'idTipoMaterial');        
        $conteo=array_count_values($mat);        
        foreach($tipos as $tipo){
            if(isset($conteo[$tipo->id])){
                array_push($end,array("tipo"=>$tipo->descripcion,"cantidad"=>$conteo[$tipo->id]));
            }
        }        
        return $end;        
    }*/

    public function cuentaMateriales($materiales)
    {
        $end = [];
        $tipos = TipoMaterial::all();
        $aux = $materiales->toArray();

        // Agrupar los materiales por tipo de material
        $agrupados = [];
        foreach ($aux as $material) {
            $idTipoMaterial = $material['idTipoMaterial'];
            if (!isset($agrupados[$idTipoMaterial])) {
                $agrupados[$idTipoMaterial] = [];
            }
            $agrupados[$idTipoMaterial][] = $material;
        }

        // Crear el array final con tipo, cantidad, numSerie mínimo y máximo
        foreach ($tipos as $tipo) {
            if (isset($agrupados[$tipo->id])) {
                $cantidad = count($agrupados[$tipo->id]);
                $numSeries = array_column($agrupados[$tipo->id], 'numSerie');

                $numSerieMin = min($numSeries);
                $numSerieMax = max($numSeries);

                array_push($end, [
                    "tipo" => $tipo->descripcion,
                    "cantidad" => $cantidad,
                    "numSerieMin" => $numSerieMin,
                    "numSerieMax" => $numSerieMax
                ]);
            }
        }

        return $end;
    }


    public function terminar(){
        $usuario=User::find(Auth::id());
        $this->validate([
            "acepto"=>"required"
        ]);

        $materiales=$this->recepcion->materiales;
        foreach($materiales as $material){
            $material->update(['idUsuario'=>Auth::id(),'ubicacion'=>'En poder de '.$usuario->name,'estado'=>3]);
            $this->recepcion->update(["estado"=>3]);//se cambia estado a recepcionado
        }
        $this->open=false;
        $this->emit("render");
        $this->emit('alert','Se recepcionaron correctamente tus materiales');        

    }

    protected $messages=[
        "acepto.required"=>"Debe aceptar y estar conforme con el cargo para poder recepcionar los materiales."        
    ];

}



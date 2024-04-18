<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\Solicitud;
use App\Models\TipoMaterial;
use App\Models\User;
use App\Notifications\CreateSolicitud as NotificationsCreateSolicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class CreateSolicitud extends Component
{

    public $gnvs, $glps, $chips, $open, $stock,$stockGNV,$stockGLP,$stockCHIP, $tiposMateriales, $tipoM, $cantidad;

    public $articulos = [];


    protected $rules = [
        "tipoM" => "required|numeric|min:1",
        "cantidad" => "required|numeric|min:1"
    ];

    public function mount(){
        $this->stock = Material::where([
            ["idUsuario", Auth::id()],
            ["estado", 3]
        ])->get();
        $this->stockGNV=Material::where([            
            ["idTipoMaterial",1],// 1= TIPO - FORMATO DE GNV
            ["idUsuario",Auth::id()],
            ["estado",3]
        ])->get()->count();
        $this->stockGLP=Material::where([            
            ["idTipoMaterial",3],// 1= TIPO - FORMATO DE GLP
            ["idUsuario",Auth::id()],
            ["estado",3]
        ])->get()->count();
        $this->stockCHIP=Material::where([            
            ["idTipoMaterial",2],// 1= TIPO - FORMATO DE CHIPS
            ["idUsuario",Auth::id()],
            ["estado",3]
        ])->get()->count();

        $this->listaMaterialesDisponibles();
        $this->open = false;
    }

    public function render(){
        return view('livewire.create-solicitud');
    }  

    public function agregarArticulo(){
        $this->validate();
        $art = TipoMaterial::find($this->tipoM);
        $articulo = array("id" => $art->id,"nombre" => $art->descripcion, "cantidad" => $this->cantidad);
        array_push($this->articulos, $articulo);
        $this->open = false;
        $this->emit("minAlert", ["titulo" => "PERFECTO!", "mensaje" => "El articulo se agregó correctamente", "icono" => "success",]);
        $this->reset(["tipoM", "cantidad"]);
        $this->listaMaterialesDisponibles();
        
    }

    public function eliminaArticulo($idArticulo){
        unset($this->articulos[$idArticulo]);
        $this->emit("minAlert", ["titulo" => "PERFECTO!", "mensaje" => "El articulo se eliminó correctamente", "icono" => "success",]);
        $this->listaMaterialesDisponibles();
    }

    public function listaMaterialesDisponibles(){
        $aux=[];
        $todos=TipoMaterial::all();
        foreach ($todos as $art) {
                if ($this->cuentaTipo($art->id)>= 1) {
                    array_push($aux,array("id"=>$art->id,"nombre"=>$art->descripcion,"estado"=>0));
                }else{                    
                    array_push($aux,array("id"=>$art->id,"nombre"=>$art->descripcion,"estado"=>1));
                }
        }        
       $this->tiposMateriales = $aux;
       $this->tipoM="";       
    }

    public function cuentaTipo($tipo){
        $cuenta=0;
        if(count($this->articulos)>0){
            foreach($this->articulos as $eq){
                if($eq["id"] == $tipo){
                    $cuenta++;
                }
            }
        }else{
            $cuenta=0;
        }
        
        return $cuenta;
    }
    public function guardaSolicitud(){
        $this->validate(["articulos"=>"required|array|min:1"]);

        $sol=Solicitud::create([
            "idInspector"=>Auth::id(),
            "data"=>json_encode($this->articulos,true),
            "estado"=>1
        ]);

        $this->emit("CustomAlert",["titulo"=>"BUEN TRABAJO","mensaje"=>"Se genero correctamente su solicitud ".$sol->id,"icono"=>"success"]);
        $users=User::role(['administrador'])->get();
        Notification::send($users, new NotificationsCreateSolicitud($sol));
        return redirect('Solicitud-de-materiales');
    }

}

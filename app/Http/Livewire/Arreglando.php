<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\Imagen;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection ;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Arreglando extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $idExpediente;
    public $formatos,$recortados,$rec;


    //public $certificaciones;





    public $imagenes=[];
    public $fotos=[];

    protected $rules=["imagenes"=>"nullable|array",
                        "fotos"=>"nullable|array"];

    protected $listernes=["addImg"];

    public function mount(){
       // $this->certificaciones=Certificacion::where('id','>',0)->paginate();
    }



    public function render()
    {
        $certificaciones=Certificacion::where('id','>',0)->paginate(15);
        return view('livewire.arreglando',compact('certificaciones'));
    }

    public function cambiar(){
        foreach($this->certificaciones as $certi){
            $ubicacion="En poder del cliente";
            $usuario=$certi->Inspector->id;
            $certi->Hoja->update(["idUsuario"=>$usuario,"ubicacion"=>$ubicacion,"estado"=>4]);
        }
      $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Todo OK", "icono" => "success"]);
    }



    public function seleccionaFormatos(){
        $nuevos=Material::where([
            ["idTipoMaterial",1],
            ["estado",1]
        ])
        ->orderBy('numSerie','asc')
        ->Paginate(50);

        $this->recortados=$nuevos->all();

        $this->emitTo("arreglando","render");

    }

    public function calculaCorrelativos(){
        $this->encuentraSeries($this->recortados);
    }

    public function encuentraSeries($arreglo){
        $inicio=$arreglo[0]["numSerie"];
        $final=$arreglo[0]["numSerie"];
        $nuevos=[];
        foreach($this->recortados as $key=>$rec){
            if($key+1 < count($this->recortados) ){
                if($this->recortados[$key+1]["numSerie"] - $rec["numSerie"]==1){
                    $final=$this->recortados[$key+1]["numSerie"];
                }else{
                    array_push($nuevos,["inicio"=>$inicio,"final"=>$final]);
                    $inicio=$this->recortados[$key+1]["numSerie"];
                    $final=$this->recortados[$key+1]["numSerie"];
                }
            }else{
                $final=$this->recortados[$key]["numSerie"];
                array_push($nuevos,["inicio"=>$inicio,"final"=>$final]);
            }
        }
        $this->rec=$nuevos;
    }

    public function upload(){
        $this->emit("minAlert",["titulo"=>"ERROR","mensaje"=>"Debe completar los datos de equipos para poder certificar","icono"=>"error"]);
    }



    public function guardar(){
        $this->validate();
        foreach($this->imagenes as $key => $file){
            $nombre="Prueba";
            $file_save=Imagen::create([
                'nombre'=>$nombre,
                'ruta'=>$file->storeAs('public/expedientes',$nombre.$key.'.'.$file->extension()),
                'extension'=>$file->extension(),
                'Expediente_idExpediente'=>3167,
            ]);
            array_push($this->fotos,$file_save);
        }

       $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"Todo bien","icono"=>"success"]);

    }




}

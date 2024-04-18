<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\TipoMaterial;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateAsignacion extends Component
{

    public $open = false;

    public $inspectores, $inspector, $tiposMateriales, $cantidad, $nombre, $motivo, $nombreTipo, $guia, $numInicio, $numFinal;
    public $guias;
    public $tipoM = 0;
    public $stocks = [];

    protected $rules = [
        "tipoM" => "required|numeric",
        "motivo" => "required|min:3", "cantidad" => "required",
    ];


    public function listaStock()
    {
        $materiales = TipoMaterial::all();
        foreach ($materiales as $key => $material) {
            $lista = Material::where([
                ['estado', 1],
                ['idTipoMaterial', $material->id]
            ])
                ->get();
            $this->stocks += [$material->descripcion => count($lista)];
        }
    }

    public function mount()
    {
        $this->listaStock();
        $this->inspectores = User::role(['inspector', 'supervisor'])
            ->orderBy('name')
            ->get();
        $this->tiposMateriales = TipoMaterial::all()->sortBy("descripcion");
        //$this->guias= new Collection();     
    }

    public function render()
    {
        return view('livewire.create-asignacion');
    }


    public function updated($propertyName)
    {
        switch ($this->tipoM) {
            case 1:
                $this->guias = json_decode(Material::stockPorGruposGnv(), true);
                if ($this->guia) {
                    $cant = Material::where([
                        ['estado', 1],
                        ['idTipoMaterial', $this->tipoM],
                        ['grupo', $this->guia],
                    ])->count();
                    //dd($cant);
                    //$this->reset(["numInicio"]);                    
                    if (array_key_exists("cantidad", $this->rules)) {
                        $this->rules["cantidad"] = "required|numeric|min:1|max:" . $cant;
                    } else {
                        $this->rules += ["cantidad" => 'required|numeric|min:1|max:' . $cant];
                    }
                }
                break;
            case 2:
                $this->rules += ["cantidad" => 'required|numeric|min:1|max:' . $this->stocks["CHIP"]];
                break;
            case 3:
                $this->guias = json_decode(Material::stockPorGruposGlp(), true);
                if ($this->guia) {
                    $cant = Material::where([
                        ['estado', 1],
                        ['idTipoMaterial', $this->tipoM],
                        ['grupo', $this->guia],
                    ])->count();
                    //dd($cant);
                    //$this->reset(["numInicio"]);                    
                    //$this->rules+=["cantidad"=>'required|numeric|min:1|max:'.$cant];
                    if (array_key_exists("cantidad", $this->rules)) {
                        $this->rules["cantidad"] = "required|numeric|min:1|max:" . $cant;
                    } else {
                        $this->rules += ["cantidad" => 'required|numeric|min:1|max:' . $cant];
                    }
                }
                break;
            case 4:
                    $this->guias = json_decode(Material::stockPorGruposModi(), true);
                    if ($this->guia) {
                        $cant = Material::where([
                            ['estado', 1],
                            ['idTipoMaterial', $this->tipoM],
                            ['grupo', $this->guia],
                        ])->count();
                        if (array_key_exists("cantidad", $this->rules)) {
                            $this->rules["cantidad"] = "required|numeric|min:1|max:" . $cant;
                        } else {
                            $this->rules += ["cantidad" => 'required|numeric|min:1|max:' . $cant];
                        }
                    }
                    break;
            default:
                $this->guias = new Collection();
                break;
        }


        if ($propertyName == "numInicio" && $this->cantidad > 0) {

            if ($this->numInicio) {
                $this->numFinal = $this->numInicio + ($this->cantidad - 1);
            }
        }
        if ($propertyName == "cantidad" && $this->numInicio > 0) {
            if ($this->cantidad) {
                $this->numFinal = $this->numInicio + ($this->cantidad - 1);
            } else {
                $this->numFinal = 0;
            }
        }

        $this->validateOnly($propertyName);
    }

    public function updatedCantidad()
    {
        //Muestra el formato con el numeroSerie mas bajo segun el Tipo de Material y Grupo Seleccionado
        if ($this->validateOnly("cantidad")) {
            $num = Material::where([
                ['estado', 1],
                ['idTipoMaterial', $this->tipoM],
                ['grupo', $this->guia],
            ])->orderBy("numSerie", "asc")->min("numSerie");;
            $this->numInicio = $num;
        }
    }


    public function creaColeccion($inicio, $fin)
    {
        $cole = new Collection();
        for ($i = $inicio; $i <= $fin; $i++) {
            $cole->push($i);
        }
        return $cole;
    }

    public function validaSeries()
    {
        $result = new Collection();
        if ($this->tipoM == 1 || $this->tipoM == 3 || $this->tipoM == 4) { // AGREGUE EL TIPOM 4 PARA MODIFI
            if ($this->numInicio && $this->guia) {
                $series = $this->creaColeccion($this->numInicio, $this->numFinal);
                $mat = Material::where([['idTipoMaterial', $this->tipoM], ['grupo', $this->guia], ["estado", 1]])->pluck('numSerie');
                $result = $mat->intersect($series);
            }
        }
        return $result;
    }

    public function addArticulo()
    {

        switch ($this->tipoM) {
            case 1:
                $rule = [
                    "guia" => 'required',
                    "numInicio" => 'required',
                    "numFinal" => 'required',
                ];
                $this->validate($rule);
                $temp = $this->validaSeries();
                if ($temp->count() > 0) {
                    // $this->emit("minAlert",["titulo"=>"TODO OK","mensaje"=>"BIEN HECHO ".$temp->count(),"icono"=>"success"]); 
                    $articulo = array("tipo" => $this->tipoM, "nombreTipo" => $this->nombreTipo, "cantidad" => $this->cantidad, "inicio" => $this->numInicio, "final" => $this->numFinal,"grupo"=>$this->guia, "motivo" => $this->motivo);
                    $this->emit('agregarArticulo', $articulo);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'guia', 'numInicio', 'numFinal']);
                    $this->open = false;
                    $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El articulo se añadio Correctamente", "icono" => "success"]);
                    //$this->reset(["grupo"]);
                } else {
                    $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Las series ingresadas no pertenecen al grupo seleccionado o no existen ", "icono" => "error"]);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'guia', 'numInicio', 'numFinal']);
                }
            break;

            case 2:
                $rule = ["cantidad" => 'required|numeric|min:1|max:' . $this->stocks["CHIP"]];
                if($this->validate($rule)){                    
                    $articulo = array("tipo" => $this->tipoM, "nombreTipo" => $this->nombreTipo, "cantidad" => $this->cantidad, "inicio" => "N/A", "final" => "N/A", "motivo" => $this->motivo);
                    $this->emit('agregarArticulo', $articulo);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'guia', 'numInicio', 'numFinal']);
                    $this->open = false;
                    $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El articulo se añadio Correctamente", "icono" => "success"]);
                    //$this->reset(["grupo"]);
                } else {
                    $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Las series ingresadas no pertenecen al grupo seleccionado o no existen ", "icono" => "error"]);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'guia', 'numInicio', 'numFinal']);
                }
            break;

            case 3:
                $rule = [
                    "guia" => 'required',
                    "numInicio" => 'required|numeric|min:1',
                    "numFinal" => 'required|numeric|min:1',
                ];
                $this->validate($rule);        
                $temp=$this->validaSeries();
                if($temp->count()>0){
                   // $this->emit("minAlert",["titulo"=>"TODO OK","mensaje"=>"BIEN HECHO ".$temp->count(),"icono"=>"success"]); 
                    $articulo= array("tipo"=>$this->tipoM,"nombreTipo"=>$this->nombreTipo,"cantidad"=>$this->cantidad,"inicio"=>$this->numInicio,"final"=>$this->numFinal,"grupo"=>$this->guia ,"motivo"=>$this->motivo);
                    $this->emit('agregarArticulo',$articulo);
                    $this->reset(['tipoM','motivo','cantidad','guia','numInicio','numFinal']);
                    $this->open=false;
                    $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"El articulo se añadio Correctamente","icono"=>"success"]);
                    //$this->reset(["grupo"]);
                }else{
                    $this->emit("minAlert",["titulo"=>"ERROR","mensaje"=>"Las series ingresadas no pertenecen al grupo seleccionado o no existen ","icono"=>"error"]); 
                    $this->reset(['tipoM','motivo','cantidad','guia','numInicio','numFinal']);
        
                }
            break;

            case 4:
                $rule = [
                    "guia" => 'required',
                    "numInicio" => 'required',
                    "numFinal" => 'required',
                ];
                $this->validate($rule);
                $temp = $this->validaSeries();
                if ($temp->count() > 0) {
                    // $this->emit("minAlert",["titulo"=>"TODO OK","mensaje"=>"BIEN HECHO ".$temp->count(),"icono"=>"success"]); 
                    $articulo = array("tipo" => $this->tipoM, "nombreTipo" => $this->nombreTipo, "cantidad" => $this->cantidad, "inicio" => $this->numInicio, "final" => $this->numFinal,"grupo"=>$this->guia , "motivo" => $this->motivo);
                    $this->emit('agregarArticulo', $articulo);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'guia', 'numInicio', 'numFinal']);
                    $this->open = false;
                    $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El articulo se añadio Correctamente", "icono" => "success"]);
                    //$this->reset(["grupo"]);
                } else {
                    $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Las series ingresadas no pertenecen al grupo seleccionado o no existen ", "icono" => "error"]);
                    $this->reset(['tipoM', 'motivo', 'cantidad', 'guia', 'numInicio', 'numFinal']);
                }
            break;

            default:
                $rule = ["cantidad" => 'required|numeric|min:1'];
                break;
        }
       
    }

    public function updatedOpen()
    {
        $this->reset(['tipoM', 'motivo', 'cantidad', 'stocks', 'numInicio', 'numFinal']);
        $this->listaStock();
    }
}

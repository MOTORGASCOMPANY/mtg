<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\Salida;
use App\Models\SalidaDetalle;
use App\Models\TipoMaterial;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PrestamoMateriales extends Component
{

    public $inspectores,$inspectoresReceptores,$inspectorEmisor, $inspectorReceptor,$envio,$ruta;
    public $estado = 1;
    public $articulos = [];

    public $todo, $disponibles;
    public  $seleccionados;

    //public $dispGNV, $selGNV, $nuevoDispGNV, $dispGLP, $selGLP, $nuevoDispGLP;


    protected $listeners = ['agregarArticulo'];

    public function render(){
        return view('livewire.prestamo-materiales');
    }

    public function mount(){
        $this->inspectores = User::role(['inspector', 'supervisor'])
            ->where('id', '!=', Auth::id())
            ->orderBy('name')->get();


        $this->estado=1;

        $this->seleccionados = new Collection();

    }

    public function updatedInspectorEmisor($value){
        if($value!=null){
            $this->inspectoresReceptores = User::role(['inspector', 'supervisor'])
            ->where('id', '!=', $value)
            ->orderBy('name')->get();
            $this->todo = Material::where([
                ["idUsuario", $value], ["estado", 3]
            ])->get();
        }
        $this->disponibles = $this->todo;
    }

    public function agregarArticulo($articulo){
        $tipoMat = TipoMaterial::find($articulo["tipo"]);
        $articulo["nombreTipo"] = $tipoMat->descripcion;
        $this->actualizaMaterialesSeleccionados($articulo);
        array_push($this->articulos, $articulo);
        $this->emit('render');
    }

    public function deleteArticulo($id){
        if($this->articulos[$id]["tipo"]==1 || $this->articulos[$id]["tipo"]==3 || $this->articulos[$id]["tipo"]==4){
            $formatosSeleccionados = $this->creaColeccion($this->articulos[$id]["inicio"], $this->articulos[$id]["final"]);
            $this->agregaMaterialesAdisponibles($this->buscaMateriales($formatosSeleccionados,$this->articulos[$id]["tipo"]));
            $this->quitaDeMaterialesSeleccionados($this->buscaMateriales($formatosSeleccionados,$this->articulos[$id]["tipo"]));
            unset($this->articulos[$id]);
        }else{
            $chips=$this->buscaChipsParaEliminar($this->articulos[$id]["cantidad"]);
            $this->agregaMaterialesAdisponibles($chips);
            $this->quitaDeMaterialesSeleccionados($chips);
            unset($this->articulos[$id]);
        }

    }

    public function creaColeccion($inicio, $fin){
        $cole = new Collection();
        for ($i = $inicio; $i <= $fin; $i++) {
            $cole->push($i);
        }
        return $cole;
    }

    public function actualizaMaterialesSeleccionados($articulo){
        switch ($articulo["tipo"]) {
            case 1:
                $formatosSeleccionados = $this->creaColeccion($articulo["inicio"], $articulo["final"]);
                $this->agregaMaterialesAseleccionados( $this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));
                $this->quitaDeMaterialesDisponibles( $this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));

            break;
            case 2:
                $chips=$this->buscaChips($articulo["cantidad"]);
                $this->agregaMaterialesAseleccionados($chips);
                $this->quitaDeMaterialesDisponibles($chips);

            break;
            case 3:
                $formatosSeleccionados = $this->creaColeccion($articulo["inicio"], $articulo["final"]);
                $this->agregaMaterialesAseleccionados( $this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));
                $this->quitaDeMaterialesDisponibles( $this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));
            break;
            //para modificacion
            case 4:
                $formatosSeleccionados = $this->creaColeccion($articulo["inicio"], $articulo["final"]);
               // dd($this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));
                $this->agregaMaterialesAseleccionados( $this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));
                $this->quitaDeMaterialesDisponibles( $this->buscaMateriales($formatosSeleccionados,$articulo["tipo"]));
            break;
            
            default:
                # code...
            break;
        }
    }


    public function quitaArticulosDeStock($articulo){
        switch ($articulo["tipo"]) {
            case 1:
                $this->quitaFormato($articulo);
                break;
            case 2:
                # code...
                break;
            case 3:
                $this->quitaFormato($articulo);
                break;
            // para modificacion
            case 4:
                $this->quitaFormato($articulo);
                break;

            default:

                break;
        }
    }

    public function quitaFormato($articulo){
            /*
                if ($this->Seleccionados->count() <= 0) {
                    //$formatosDisponibles = $this->todo->where('idTipoMaterial', $articulo["tipo"])->pluck("numSerie");
                    $formatosSeleccionados = $this->creaColeccion($articulo["inicio"], $articulo["final"]);
                    //$this->nuevoDispGNV = $this->dispGNV->diff($this->selGNV);
                    $this->disponibles = $this->buscaMateriales($formatosSeleccionados , $articulo["tipo"]);
                } else {
                    $this->$this->nuevoDispGNV;
                    $this->selGNV = $this->creaColeccion($articulo["inicio"], $articulo["final"]);
                    //dd($this->p2);
                    $this->nuevoDispGNV = $this->dispGNV->diff($this->selGNV);
                    $this->disponibles = $this->buscaMateriales($this->selGNV, $articulo["tipo"]);
                }
            */

    }

    public function quitaChip(){

    }

    public function buscaMateriales($nuevaLista, $tipo){
        $dispo = new Collection();
        switch ($tipo) {
            case 1:
                $dispo = $this->todo->filter(function ($item) use ($nuevaLista, $tipo) {
                    if (in_array($item->numSerie, $nuevaLista->all())&& $item->idTipoMaterial  == $tipo)//Valida que el numero de serie exista en nuestro inventario
                    {
                        return $item;
                    }
                });
            break;
            case 3:
                $dispo = $this->todo->filter(function ($item) use ($nuevaLista, $tipo) {
                    if (in_array($item->numSerie, $nuevaLista->all())&& $item->idTipoMaterial  == $tipo) {
                        return $item;
                    }
                });
            break;
            //para modificacion

            case 4:
                //dd($this->todo);
                $dispo = $this->todo->filter(function ($item) use ($nuevaLista, $tipo) {
                    //
                    if (in_array($item->numSerie, $nuevaLista->all())&& $item->idTipoMaterial  == $tipo) { 
                       // dd($item);
                        return $item;
                    }
                });

            break;
            default:
                # code...
                break;
        }
        return $dispo;
    }

    public function buscaChips($cantidad){
        $chips=new Collection();
        $todoChips=$this->disponibles->where("idTipoMaterial",2)->sortBy("id");
        $chips=$todoChips->chunk($cantidad)->first();
        return $chips;
    }

    public function buscaChipsParaEliminar($cantidad){
        $chips=new Collection();
        $todoChips=$this->seleccionados->where("idTipoMaterial",2)->sortBy("id")->chunk($cantidad)->first();
        $chips=$todoChips;
        return $chips;
    }


    public function agregaMaterialesAseleccionados(Collection $materiales){
        $materiales->each(function ($item, $key) {
            $this->seleccionados->push($item);
        });
    }

    public function quitaDeMaterialesSeleccionados(Collection $materiales){
        $materiales->each(function ($item, $key) {
            if($this->seleccionados->find($item->id)){
                $index=$this->seleccionados->search($this->seleccionados->find($item->id));
                $this->seleccionados->pull($index);
            }
        });
    }

    public function agregaMaterialesAdisponibles(Collection $materiales){
        $materiales->each(function ($item, $key) {
            $this->disponibles->push($item);
        });
    }

    public function quitaDeMaterialesDisponibles(Collection $materiales){
        $materiales->each(function ($item, $key) {
            if($this->disponibles->find($item->id)){
                $index=$this->disponibles->search($this->disponibles->find($item->id));
                $this->disponibles->pull($index);
            }
        });
    }

    public function guardar(){

        $this->validate(
            [
                "inspectorEmisor"=>"required|numeric|min:1",
                "inspectorReceptor"=>"required|numeric|min:1",
                "articulos"=>"required|array|min:1"
            ]
        );
        $salida=Salida::create(
            [
                "numero"=>date('dmY').Auth::id().rand(),
                "idUsuarioSalida"=>$this->inspectorEmisor,
                "idUsuarioAsignado"=>$this->inspectorReceptor,
                "motivo"=>"Prestamo de Materiales",
                "estado"=>1   //se asigna estado de salida como envio
            ]
        );
        $usuario=User::find($salida->idUsuarioAsignado);
        $this->seleccionados->each(function ($item, $key) use($usuario,$salida) {
            //dd(Material::findOrFail($item->id));
            if (Material::findOrFail($item->id)) {
                $item->update(['idUsuario'=>null,'ubicacion'=>'En proceso de envio a '.$usuario->name,'estado'=>2]);
                $this->guardaDetalles($item,$salida->id);
                //dd($this->guardaDetalles($item,$salida->id));
            }
        });

        $this->envio=$salida;
        $this->estado=2;
        $this->ruta=route('generaCargo', ['id' => $salida->id]);
        $this->reset(['articulos','inspectorEmisor','inspectorReceptor']);


    }

    public function guardaDetalles($articulo,$idSalida){
        $detalleSal=SalidaDetalle::create([
            "idSalida"=>$idSalida,
            "idMaterial"=>$articulo->id,
            "estado"=>1,
            "motivo"=>"Préstamo de materiales"
        ]);
        return $detalleSal;
    }


}

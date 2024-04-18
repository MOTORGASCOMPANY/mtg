<?php

namespace App\Http\Livewire;

use App\Jobs\guardarArchivosEnExpediente;
use App\Models\CertifiacionExpediente;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Expediente;
use App\Models\Material;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListaCertificacionesPendientes extends Component
{

    use WithPagination;

    public $sort,$direction,$cant,$search,$numSugerido,$open=false,$pendiente,$combustible,$pesoNeto;

    protected $rules=["numSugerido"=>"required|min:1","combustible"=>"required|min:2","pesoNeto"=>"required:numeric|min:1"];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;
        //$this->numSugerido=50187;
    }

    public function render()
    {
        $certis=CertificacionPendiente::
        placaVehiculo($this->search)
        ->idInspector(Auth::id())
        //->placaVehiculo($this->search)
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);;
        return view('livewire.lista-certificaciones-pendientes',compact("certis"));
    }

    public function certificar(){
        $this->validate();
        
        $certi=$this->pendiente;
        $certi->Vehiculo->update(["combustible"=>$this->combustible,"pesoNeto"=>$this->pesoNeto]);
        $precio=$certi->precio;

        //PENDIENTE REVISAR EL COMPORTAMIENTO DE LOS PRECIOS.
        /*
        $aux = Servicio::where([['taller_idtaller', $certi->Taller->id], ['tipoServicio_idtipoServicio', 2]])->first(); // su existiera otro servicio pendiente se deberia agregar una validacion para activacion de chip(anual == 2)
        if($aux){
            $precio= $aux->precio;
        }else{
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No se encontro precio invalido", "icono" => "warning"]);
            return ;
        }
        //dd($aux);
        

        if($certi->pagado>0){
            $precio=$certi->precio;
        }
        */

        $hoja=$this->procesaFormato($this->numSugerido,11);
        //dd($hoja);
        if($hoja!=null){
            //crea una certificacion
            $certif= Certificacion::certificarGnvPendiente($certi->Taller, $certi->Servicio, $hoja, $certi->Vehiculo, $certi->Inspector,$precio, $certi->externo);
            //Encuentra el expediente y cambia su estado
            $expe=Expediente::find($certi->idExpediente);
            if($expe){
                $expe->update(["servicio_idservicio"=>$certif->idServicio,"certificado"=>$certif->Hoja->numSerie]);
                //Crea la relacion entre la nueva certificacion y el expediente previamente registrado
                $certEx=CertifiacionExpediente::create(["idCertificacion"=>$certif->id,"idExpediente"=>$expe->id]);
            }                                  
            //agrega la certificacion al registro de certificado pendiente
            $certi->update(["idCertificacion"=>$certif->id]);
            //Se cambia la fecha de certificacion por la fecha en que se registro el certificado pendiente
            $certif->update(["created_at"=>$certi->created_at]);
            // Actualizar el campo pagado a 1 en la certificación
            $certif->update(['pagado' => 1]); // agregue esto para ya me aparezca como cobrado
            //Agrega a la cola de trabajo la carga de los archivos de certificacion
            guardarArchivosEnExpediente::dispatch($expe,$certif);
            //cambia el estado de la certificacion a realizado
            $this->cambiaEstado($certi);
            $this->reset(["numSugerido","open"]);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Tu certificado N°: " . $certif->Hoja->numSerie . " esta listo.", "icono" => "success"]);       
        }else{
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No fue posible encontrar un formato para realizar la certificación", "icono" => "warning"]);
        }
    }

    public function muestraModal(CertificacionPendiente $certi){       
        $this->pendiente=$certi; 
        $formato=$this->obtieneFormato(1);
        if(!empty($formato)){
            $numero=$this->obtieneFormato(1)->numSerie;
            $this->numSugerido=$numero;
        }else{
            $this->numSugerido=0;
        }       
        
        $this->open=true;
    }
    
    
    public function cambiaEstado(CertificacionPendiente $certi){
        $certi->update(["estado"=>2]);
    }

    public function obtieneFormato($tipo)
    {
        $formato = Material::where([
            ["idTipoMaterial", $tipo],
            ['idUsuario', Auth::id()],
            ["estado", 3],
        ])->orderBy('numSerie', 'asc')
          ->first();        
        return $formato;
    }

    public function procesaFormato($numSerieFormato, $servicio)
    {
        if ($numSerieFormato) {
            $hoja = $this->seleccionaHojaSegunServicio($numSerieFormato, $servicio);
            if ($hoja != null) {
                return $hoja;
            } else {
                $this->emit("CustomAlert", ["titulo" => "ERROR", "mensaje" => "El número de serie ingresado no corresponde con ningún formato en su poder", "icono" => "error"]);
                return null;
            }
        } else {
            $this->emit("CustomAlert", ["titulo" => "ERROR", "mensaje" => "Número de serie no válido.", "icono" => "error"]);
            return null;
        }
    }   

    public function seleccionaHojaSegunServicio($serie, $tipo)
    {
        $hoja = null;
        switch ($tipo) {
            case 1:
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                return $hoja;
                break;

            case 2:
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                return $hoja;
                break;

            case 3:
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 3], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                return $hoja;
                break;

            case 4:
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 3], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                return $hoja;
                break;

            case 8:
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                return $hoja;
                break;

            case 10:
                    $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                    return $hoja;
                    break;
            case 11:
                    $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                    return $hoja;
                    break;
            case 12:
                    $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3], ['idUsuario', Auth::id()]])->first();
                    return $hoja;
                    break;
            default:
                return $hoja;
                break;
        }
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

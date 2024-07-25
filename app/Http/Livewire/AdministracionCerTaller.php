<?php

namespace App\Http\Livewire;

use App\Jobs\guardarArchivosEnExpediente;
use App\Models\CartaAclaratoria;
use App\Models\CertifiacionExpediente;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\CertificacionTaller;
use App\Models\Desmontes;
use App\Models\Expediente;
use App\Models\Material;
use App\Models\Taller;
use App\Models\TipoMaterial;
use App\Models\TipoServicio;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdministracionCerTaller extends Component
{

    use WithPagination;

    public $search, $sort, $direction, $cant, $inspectores, $ins, $talleres, $ta, $fecIni, $fecFin, $materiales, $mate, $tipos, $serv;
    public $modelo;

    //Variables para modal (certificaciones pendientes)
    public $numSugerido,$open=false,$pendiente,$combustible,$pesoNeto;
    public $tipoServicio, $pertenece, $chip, $servicios, $taller, $servicio;

    protected $listeners = ['render', 'delete'];

    protected $rules=["numSugerido"=>"required|min:1","combustible"=>"required|min:2","pesoNeto"=>"required:numeric|min:1"];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'], //certificados_taller.
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];


    public function mount()
    {
        $this->cant = "10";
        $this->sort = 'id'; //certificados_taller.
        $this->direction = "desc";
        //Inicializar
        $this->ins = '';
        $this->fecIni = '';
        $this->fecFin = '';
        $this->ta = '';
        $this->mate = '';
        $this->modelo = '';
        //Para filtros
        $this->inspectores = User::role(['inspector', 'supervisor'])->where('id', '!=', Auth::id())->orderBy('name')->get();
        $this->talleres = Taller::all()->sortBy('nombre');
        $this->materiales = TipoMaterial::whereIn('id', [1, 3])->get();
        $this->tipos = TipoServicio::all();

    }

    public function render()
    {
        $certificaciones = null;
        $pendientes = null;
        $desmontes = null;
        $carta = null;
        $chipsConsumidos = null;
        

        if ($this->modelo === 'taller') {
            $certificaciones = CertificacionTaller::NumFormato2($this->search)
                ->IdInspector($this->ins)
                //->IdMaterial($this->mate)
                ->IdTaller($this->ta)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'pendientes') {
            $pendientes = CertificacionPendiente::idInspector($this->ins)
                ->IdTalleres($this->ta)
                //->idTipoServicios($this->serv)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'desmontes') {
            $desmontes = Desmontes::idInspector($this->ins)
                ->idTaller($this->ta)
                //->idTipoServicios($this->serv)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'carta') {
            $carta = CartaAclaratoria::idInspector($this->ins)
                //->IdMaterial($this->mate)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'chipsConsumidos') {
            $chipsConsumidos = Material::query()
                ->select(
                    'material.id',
                    'material.idUsuario',
                    'material.estado',
                    'material.ubicacion',
                    'material.grupo',
                    'material.updated_at',
                    'users.name as nombreInspector',
                )
                ->join('users', 'material.idUsuario', '=', 'users.id')
                ->where([
                    ['material.estado', '=', 4], // Chips consumidos
                    ['material.idTipoMaterial', '=', 2], // Tipo de material CHIP
                    //['material.idUsuario', '=', Auth::id()], // Filtra por el usuario actualmente autenticado
                ])
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        }
        return view('livewire.administracion-cer-taller', compact('certificaciones', 'pendientes', 'desmontes', 'carta', 'chipsConsumidos'));
    }


    public function muestraModal(CertificacionPendiente $certi){       
        $this->pendiente=$certi; 
        /*$formato=$this->obtieneFormato(1);
        if(!empty($formato)){
            $numero=$this->obtieneFormato(1)->numSerie;
            $this->numSugerido=$numero;
        }else{
            $this->numSugerido=0;
        }*/       
        
        $this->open=true;
    }

    public function updatednumSugerido($val)
    {
        $this->pertenece = $this->obtienePertenece($val);
    }

    public function updatedTaller($val)
    {
        if ($val) {
            $this->servicios = Servicio::where('taller_idtaller', $val)
                ->whereHas('tipoServicio', function ($query) {
                    $query->where('descripcion', 'Revisión anual GNV');
                })
                ->get();

            $this->servicio = "";
        } else {
            $this->reset(["servicios", "servicio"]);
        }
    }


    public function updatedServicio($val)
    {
        if ($val) {
            $this->tipoServicio = Servicio::find($val)->tipoServicio;
            //dd($this->tipoServicio);
            $this->sugeridoSegunTipo($this->tipoServicio->id);
            if ($this->tipoServicio->id == 10) {
                $this->chip = $this->obtieneChip();
            }
            $this->reset(["externo", "estado"]);
        } else {
            $this->tipoServicio = null;
        }
    }

    public function obtienePertenece($val)
    {
        if ($val) {
            $m = Material::where("numSerie", $val)->where("idTipoMaterial", 1)->first();
            // return User::find(Material::where([["numSerie", $val],["idTipoMaterial", 4]] )->first()->idUsuario);
            if ($m == null) {
                return "No existe";
            } else {
                if ($m->idUsuario == null) {
                    return "No esta asignado";
                } else {
                    if ($m->estado == 4) {
                        return "Formato Consumido";
                    } else {
                        return User::find($m->idUsuario)->name;
                    }
                }
            }
            //return User::find($m)->name;
        } else {
            return null;
        }
    }

    public function sugeridoSegunTipo($tipoServ)
    {
        $formatoGnv = 1;
        $formatoGlp = 3;
        $formatoModi = 4;
        if ($tipoServ) {
            switch ($tipoServ) {
                case 1:
                    $this->numSugerido = $this->obtieneFormato($formatoGnv);
                    break;
        
                case 2:
                    $this->numSugerido = $this->obtieneFormato($formatoGnv);
                    break;
                default:
                    $this->numSugerido = 0;
                    break;
            }
        }
    }    
    
    public function obtieneFormato($tipo)
    {
        $formato = Material::where([
            ["idTipoMaterial", $tipo],
            //['idUsuario', Auth::id()],
            ["estado", 3],
        ])
            ->orderBy('numSerie', 'asc')
            ->min("numSerie");
        if (isset($formato)) {
            return $formato;
        } else {
            return null;
        }
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
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3]])->first();
                return $hoja;
                break;

            case 2:
                $hoja = Material::where([['numSerie', $serie], ['idTipoMaterial', 1], ['estado', 3]])->first();
                return $hoja;
                break;
            default:
                return $hoja;
                break;
        }
    }

    public function cambiaEstado(CertificacionPendiente $certi){
        $certi->update(["estado"=>2]);
    }

    public function certificar(){
        $this->validate();
        
        $certi=$this->pendiente;
        $certi->Vehiculo->update(["combustible"=>$this->combustible,"pesoNeto"=>$this->pesoNeto]);
        $precio=$certi->precio;

        $m = Material::where("numSerie", $this->numSugerido)->where("idTipoMaterial", 1)->first();
        $usuario = User::find($m->idUsuario);

        $hoja=$this->procesaFormato($this->numSugerido, 2);
        //dd($hoja);
        if($hoja!=null){
            //crea una certificacion
            $certif= Certificacion::certificarGnvPendiente($certi->Taller, $certi->Servicio, $hoja, $certi->Vehiculo, $usuario, $precio, $certi->externo);
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



    public function order($sort)
    {
        if ($this->sort === $sort) {
            $this->direction = $this->direction === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function delete(CertificacionTaller $certificacion)
    {
        $certificacion->delete();
        $this->emit('render');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Expediente;
use App\Models\ExpedienteObservacion;
use App\Models\Imagen;
use App\Models\Observacion;
use App\Models\Servicio;
use App\Models\Taller;
use App\Models\TipoServicio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RevisionExpedientes extends Component
{
    use WithFileUploads;
    use WithPagination;



    public $documentos = [];
    public $observaciones = [
        array(
            "id" => 1,
            "detalle" => "Fotografias faltantes.",
            "tipo" => 1,
            "estado" => 0
        ),
        array(
            "id" => 2,
            "detalle" => "Serie de reductor no corresponde o no es visible.",
            "tipo" => 1,
            "estado" => 0
        ),
        array(
            "id" => 3,
            "detalle" => "Serie de tanque no corresponde o no es visible.",
            "tipo" => 1,
            "estado" => 0
        ),
        array(
            "id" => 4,
            "detalle" => "Documentos faltantes o erroneos.",
            "tipo" => 1,
            "estado" => 0
        ),
    ];
    public $observacionesEx = [];
    public $files = [];

    public $idus, $expediente, $identificador, $tipoServicio, $ta, $es, $ins, $tipoSer, $inspectores, $talleres, $tipos, $comentario, $activo, $index;
    public $conteo;
    public $search = "";
    public $cant = "";
    public $sort = "created_at";
    public $direction = 'desc';
    public $readyToLoad = false;
    public $editando = false;

    protected $listeners = ['render', 'delete', 'deleteFile', 'tallerSel'];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'created_at'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
        'es' => ['except' => ''],
        'ta' => ['except' => ''],
        'ins' => ['except' => ''],
    ];

    protected $rules = [

        'expediente.estado' => 'required',
        'conteo' => 'numeric|required|min:1',
        'comentario' => 'required|max:500',
    ];



    public function loadExpedientes()
    {
        $this->readyToLoad = true;
    }

    public function mount()
    {
        $this->talleres = Taller::all()->sortBy('nombre');
        $this->tipos = TipoServicio::all();
        $this->inspectores = User::role(['inspector', 'supervisor'])->where('id', '!=', Auth::id())->orderBy('name')->get();
        $this->idus = Auth::id();
        $this->identificador = rand();
        $this->expediente = new Expediente();
        $this->cant = "10";
        $this->conteo = 0;
        $this->activo = false;
    }

    public function agregaObservacion($id)
    {
        if ($this->observaciones[$id - 1]['estado'] == 0) {
            $this->observaciones[$id - 1]['estado'] = 1;
            $this->conteo++;
        } else {
            $this->observaciones[$id - 1]['estado'] = 0;
            $this->conteo--;
        }
    }

    public function creaGuardaObservaciones()
    {
        foreach ($this->observaciones as $obs) {
            if ($obs['estado'] == 1) {
                $ob = Observacion::create([
                    'detalle' => $obs['detalle'],
                    'tipo' => 1,
                    'estado' => 1,
                ]);

                ExpedienteObservacion::create([
                    'idExpediente' => $this->expediente->id,
                    'idObservacion' => $ob->id,
                ]);
            }
        }
        if ($this->activo) {
            $obser = Observacion::create([
                'detalle' => $this->comentario,
                'tipo' => 2,
                'estado' => 1,
            ]);
            ExpedienteObservacion::create([
                'idExpediente' => $this->expediente->id,
                'idObservacion' => $obser->id,
            ]);
        }
    }

    public function tallerSel($tall)
    {
        $this->ta = $tall;
    }

    public function render()
    {
        $filtros1 = [array('expedientes.placa', 'like', '%' . $this->search . '%'), ['expedientes.usuario_idusuario', '!=', Auth::id()]];
        $filtros2 = [array('expedientes.certificado', 'like', '%' . $this->search . '%'), ['expedientes.usuario_idusuario', '!=', Auth::id()]];
        if ($this->es != null) {
            array_push($filtros1, ['expedientes.estado', $this->es]);
            array_push($filtros2, ['expedientes.estado', $this->es]);
        }
        if ($this->ins != null) {
            array_push($filtros1, ['users.id', $this->ins]);
            array_push($filtros2, ['users.id', $this->ins]);
        }
        if ($this->ta != null) {
            array_push($filtros1, ['taller.id', $this->ta]);
            array_push($filtros2, ['taller.id', $this->ta]);
        }
        if ($this->tipoSer != null) {
            array_push($filtros1, ['tiposervicio.descripcion', $this->tipoSer]);
            array_push($filtros2, ['tiposervicio.descripcion', $this->tipoSer]);
        }

        if ($this->readyToLoad) {
            $expedientes = DB::table('expedientes')
                ->select('expedientes.*', 'tiposervicio.descripcion', 'users.name', 'taller.nombre', 'taller.id as tallerid')
                ->join('servicio', 'expedientes.servicio_idservicio', '=', 'servicio.id')
                ->join('tiposervicio', 'tiposervicio.id', '=', 'servicio.tipoServicio_idtipoServicio')
                ->join('users', 'users.id', '=', 'expedientes.usuario_idusuario')
                ->join('taller', 'taller.id', '=', 'servicio.taller_idtaller')
                ->where($filtros1)
                ->orWhere($filtros2)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } else {
            $expedientes = [];
        }

        return view('livewire.revision-expedientes', compact('expedientes'));
    }




    public function order($sort)
    {
        if ($this->sort = $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function cargaObservaciones(Expediente $expediente)
    {
        $nobs = ExpedienteObservacion::where('idExpediente', $expediente->id)->get();
        if ($nobs) {
            $this->reset(['observacionesEx']);
            foreach ($nobs as $n) {
                $ob = Observacion::find($n->idObservacion);
                if ($ob->tipo == 1) {
                    array_push($this->observacionesEx, $ob);
                    $this->conteo++;
                } else {
                    $this->comentario = $ob->detalle;
                    $this->index = $ob->id;
                    $this->activo = true;
                    $this->activaCheck();
                }
            }
        } else {
            $this->reset(['observacionesEx']);
        }
    }

    public function observacioneDisponibles()
    {
        foreach ($this->observacionesEx as $exob) {
            foreach ($this->observaciones as $key => $obser) {
                if ((string)$obser['detalle'] == (string)$exob->detalle) {
                    if ($obser['tipo'] == 1) {
                        $this->observaciones[$key]['tipo'] = 0;
                    }
                }
            }
        }
    }

    public function pasaDatosExpediente(Expediente $expediente)
    {
        $this->expediente = $expediente;
        $s = Servicio::find($expediente->servicio_idservicio);
        $ts = TipoServicio::find($s->tipoServicio_idtipoServicio);
        $this->tipoServicio = $ts->descripcion;
        $this->files = Imagen::where('Expediente_idExpediente', '=', $expediente->id)->whereIn('extension', ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'])->get();
        $this->documentos = Imagen::where('Expediente_idExpediente', '=', $expediente->id)->whereIn('extension', ['pdf', 'xlsx', 'xls', 'docx', 'doc'])->get();
        $this->cargaObservaciones($expediente);
        $this->reset(['observaciones']);
        $this->observacioneDisponibles();
        $this->identificador = rand();
    }



    public function edit(Expediente $expediente)
    {
        if ($expediente->estado == 2) {
            $this->pasaDatosExpediente($expediente);
            $this->editando = true;
        } else {
            $this->pasaDatosExpediente($expediente);
            $this->editando = true;
        }
    }

    public function actualizar()
    {
        //$this->eligeObservaciones();
        if ($this->expediente->estado != 2) {
            $this->conteo = 1;
        }
        $reglas = [
            'expediente.estado' => 'required',
            'conteo' => 'numeric|required|min:1'
        ];
        if ($this->activo) {
            $reglas += ['comentario' => 'required|max:500'];
        } else {
            $coment = Observacion::find($this->index);
            if ($coment) {
                $coment->delete();
            }
        }
        $this->validate($reglas);
        $this->creaGuardaObservaciones();
        $this->expediente->save();
        $this->editando = false;
        $this->emit('alert', 'El expediente se actualizo correctamente');
        $this->reset(['observaciones', 'observacionesEx', 'conteo', 'comentario', 'activo', 'index']);
        $this->conteo = 0;
        $this->resetCheck();
    }

    public function deleteObservacion($id)
    {
        $observacion = Observacion::find($id);
        $observacion->delete();
        $this->conteo--;
        $this->cargaObservaciones($this->expediente);
        $this->reset(['observaciones']);
        //$this->cargaObservaciones($this->expediente);
        $this->observacioneDisponibles();
    }

    public function download(Imagen $file)
    {
        // Comprueba que el archivo no esté vacío
        // dd($file);
        if (!empty($file)) {
            if ($file->migrado == 0) {
                // Descarga el archivo desde el almacenamiento local
                return Storage::download($file->ruta);
            } else {
                return Storage::disk('do')->download($file->ruta);
            }
        }
        // Si el archivo está vacío o no es válido, redirige a una página de error
        return redirect()->route('error.page');
    }


    public function activaCheck()
    {
        $this->emit('activaCheck');
    }

    public function validaObservaciones()
    {
    }

    public function resetCheck()
    {
        $this->emit('quitaCheck');
    }

    public function updated($propertyName)
    {
        //$this->resetPage();
        $this->validateOnly($propertyName);
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEditando()
    {
        $this->conteo = 0;
        $this->resetCheck();
        $this->reset(['observaciones', 'observacionesEx', 'conteo', 'comentario', 'activo', 'index']);
        //$this->resetPage();
    }

    protected $messages = [
        'conteo.min' => 'Debe seleccionar por lo menos una observación',
    ];
}

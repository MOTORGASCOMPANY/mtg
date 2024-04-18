<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expediente;
use App\Models\ExpedienteObservacion;
use App\Models\Imagen;
use App\Models\Observacion;
use App\Models\Taller;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Expedientes extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $observaciones = [];
    public $talleres = [];
    public $fotosnuevas = [];
    public $documentosnuevos = [];
    public $files = [];
    public $documentos = [];
    public $servicios = [];
    public $idus, $expediente, $identificador, $tallerSeleccionado, $servicioSeleccionado, $es, $comentario;
    public $search = "";
    public $cant = "";
    public $sort = "created_at";
    public $direction = 'desc';
    public $readyToLoad = false;
    public $editando = false;
    public $ta;

    protected $listeners = ['render', 'delete', 'deleteFile'];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'created_at'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
        'es' => ['except' => ''],
    ];

    protected $rules = [
        'expediente.placa' => 'required|min:6|max:7',
        'expediente.certificado' => 'required|min:1|max:7',
        'fotosnuevas.*' => 'image|mimes:jpeg,png,jpg,gif', //|max:2048
        'documentosnuevos.*' => 'mimes:pdf,xls,xlsx,doc,docx,txt|max:2048', //'documentosnuevos'=>'array|max:25'
        'tallerSeleccionado' => 'required',
        'servicioSeleccionado' => 'required',
    ];

    public function loadExpedientes()
    {
        $this->readyToLoad = true;
    }

    public function listaServicios()
    {
        if ($this->tallerSeleccionado != null) {
            $this->servicios = json_decode(DB::table('servicio')
                ->select('servicio.*', 'tiposervicio.descripcion')
                ->join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
                ->where('taller_idtaller', $this->tallerSeleccionado)
                ->get(), true);
        }
    }

    public function mount()
    {
        $this->idus = Auth::id();
        $this->identificador = rand();
        $this->expediente = new Expediente();
        $this->cant = "10";
        $this->talleres = Taller::all();
        $this->search = '';
        $this->es = '';
    }




    public function render()
    {

        if ($this->readyToLoad) {
            $expedientes = Expediente::placaOcertificado($this->search)
                ->idInspector(Auth::id())
                ->estado($this->es)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } else {
            $expedientes = [];
        }
        return view('livewire.expedientes', compact('expedientes'));
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
            $this->reset(['observaciones']);
            foreach ($nobs as $n) {
                $ob = Observacion::find($n->idObservacion);
                if ($ob->tipo == 1)
                    array_push($this->observaciones, $ob);
                else {
                    $this->comentario = $ob->detalle;
                }
            }
        } else {
            $this->reset(['observaciones']);
        }
    }



    public function edit(Expediente $expediente)
    {
        if ($expediente->id != null) {
            $this->expediente = $expediente;
            $this->files = Imagen::where('Expediente_idExpediente', '=', $expediente->id)->whereIn('extension', ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'])->get();
            $this->documentos = Imagen::where('Expediente_idExpediente', '=', $expediente->id)->whereIn('extension', ['pdf', 'xlsx', 'xls', 'docx', 'doc'])->get();
            $this->identificador = rand();
            $this->tallerSeleccionado = $expediente->idTaller;
            $this->listaServicios();
            $this->servicioSeleccionado = $expediente->servicio_idservicio;
            $this->cargaObservaciones($expediente);
            $this->editando = true;
        }
    }

    public function actualizar(){

        $this->validate();

        if(count($this->fotosnuevas)>0){
            foreach($this->fotosnuevas as $key=>$fn){
                $file_sa= new imagen();
                $file_sa->nombre=trim($this->expediente->placa).'-foto'.($key+1).$this->identificador.'-'.$this->expediente->certificado;
                $file_sa->extension=$fn->extension();
                $file_sa->ruta = $fn->storeAs('public/expedientes',$file_sa->nombre.'.'.$fn->extension());
                $file_sa->Expediente_idExpediente=$this->expediente->id;
                Imagen::create([
                    'nombre'=>$file_sa->nombre,
                    'ruta'=>$file_sa->ruta,
                    'extension'=>$file_sa->extension,
                    'Expediente_idExpediente'=>$file_sa->Expediente_idExpediente,
                ]);
            }
        }


        foreach($this->documentosnuevos as $key=>$file){
            $file_save= new imagen();
            $file_save->nombre=trim($this->expediente->placa).'-doc'.($key+1).$this->identificador.'-'.$this->expediente->certificado;
            $file_save->extension=$file->extension();
            $file_save->ruta = $file->storeAs('public/expedientes',$file_save->nombre.'.'.$file->extension());
            $file_save->Expediente_idExpediente=$this->expediente->id;
            Imagen::create([
                'nombre'=>$file_save->nombre,
                'ruta'=>$file_save->ruta,
                'extension'=>$file_save->extension,
                'Expediente_idExpediente'=>$file_save->Expediente_idExpediente,
            ]);
        }
        $this->expediente->idTaller=$this->tallerSeleccionado;

        $this->expediente->estado=1;

        $this->expediente->servicio_idservicio=$this->servicioSeleccionado;

        $this->expediente->save();

       // $this->reset();

        $this->reset(['editando','expediente','documentosnuevos','fotosnuevas']);

        $this->emit('alert','El expediente se actualizo correctamente');

        $this->identificador=rand();
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function delete(Expediente $expediente)
    {
        $imgs = Imagen::where('Expediente_idExpediente', '=', $expediente->id)->get();
        foreach ($imgs as $img) {
            if($img->migrado==0){
                Storage::delete($img->ruta);
            }else{
                Storage::disk('do')->delete($img->ruta);
            }
        }
        $expediente->delete();
        $this->expediente = Expediente::make();
        $this->emitTo('expedientes', 'render');
        $this->identificador = rand();
        $this->resetPage();
    }

    //borrar imagen de bd
    public function deleteFile(Imagen $file)
    {
        //Storage::delete([$file->ruta]);
        if($file->migrado==0){
            Storage::delete($file->ruta);
        }else{
            Storage::disk('do')->delete($file->ruta);
        }
        $file->delete();
        $this->reset(["files"]);
        // $this->identificador=rand();
        $this->files = Imagen::where('Expediente_idExpediente', '=', $this->expediente->id)->whereIn('extension', ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'])->get();
    }


    //borrar documentos en bs
    public function deleteDocument(Imagen $file)
    {
        if($file->migrado==0){
            Storage::delete($file->ruta);
        }else{
            Storage::disk('do')->delete($file->ruta);
        }
        $file->delete();
        $this->reset(["documentos"]);
        // $this->identificador=rand();
        $this->documentos = Imagen::where('Expediente_idExpediente', '=', $this->expediente->id)->whereIn('extension', ['pdf', 'xlsx', 'xls', 'docx', 'doc'])->get();
    }



    public function deleteFileUpload($id)
    {
        unset($this->fotosnuevas[$id]);
    }

    public function deleteDocumentUpload($id)
    {
        unset($this->documentosnuevos[$id]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEditando()
    {
        $this->reset(['documentosnuevos', 'fotosnuevas']);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Anulacion;
use App\Models\Archivo;
use App\Models\Certificacion;
use App\Models\Eliminacion;
use App\Models\Imagen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AnulacionSolicitud as NotificationsCreateSolicitud;
use App\Notifications\SolicitudEliminacion;
use Livewire\WithFileUploads;


class ListaCertificaciones extends Component
{
    use WithPagination;

    public $search, $sort, $direction, $cant, $user;
    public $anular, $eliminar, $motivo, $nombre, $imagen, $certiId;
    use WithFileUploads;


    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'certificacion.id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->user = Auth::id();
        $this->cant = "10";
        $this->sort = 'certificacion.id';
        $this->direction = "desc";
    }

    public function render()
    {

        $certificaciones = Certificacion::numFormato($this->search)
            ->placaVehiculo($this->search)
            ->idInspector(Auth::id())
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.lista-certificaciones', compact('certificaciones'));
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


    public function generarRuta($cer)
    {
        $certificacion = Certificacion::find($cer);
        $ver = "";
        $descargar = "";
        if ($certificacion) {
            $tipoSer = $certificacion->Servicio->tipoServicio->id;
            switch ($tipoSer) {
                case 1:
                    $ver = route('certificadoInicial', ['id' => $certificacion->id]);
                    break;
                case 2:
                    $ver = route('certificado', ['id' => $certificacion->id]);
                    break;
                default:
                    # code...
                    break;
            }
        }

        return $ver;
    }
    public function generarRutaDescarga($cer)
    {
        $certificacion = Certificacion::find($cer);
        $descargar = "";
        if ($certificacion) {
            $tipoSer = $certificacion->Servicio->tipoServicio->id;
            switch ($tipoSer) {
                case 1:
                    $descargar = route('descargarInicial', ['id' => $certificacion->id]);
                    break;
                case 2:
                    $descargar = route('descargarCertificado', ['id' => $certificacion->id]);
                    break;
                default:
                    # code...
                    break;
            }
        }

        return $descargar;
    }


    public function obtieneNumeroHoja($id)
    {
        $certificacion = Certificacion::find($id);
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
        if ($hoja->numSerie != null) {
            return $hoja->numSerie;
        } else {
            return 0;
        }
    }

    public function finalizarPreconversion(Certificacion $certi)
    {
        $ruta = route('finalizarPreconver', ["idCertificacion" => $certi->id]);
        return redirect()->to($ruta);
    }

    public function solicitarAnulacion($certificationId)
    {
        $this->anular = true;
        $this->certiId = $certificationId;
    }

    public function guardarSolicitudAnulacion()
    {
        $this->validate([
            'motivo' => 'required',
            'imagen' => 'required|image',
        ]);

        $certificacion = Certificacion::find($this->certiId); // Obtener la certifi cación correspondiente       
        $placa = $certificacion->Vehiculo->placa ?? 'SinPlaca'; // Obtener la placa del vehículo
        $nombreArchivo = $placa . '-' . time() . '.' . $this->imagen->getClientOriginalExtension(); // Renombrar el archivo a la hora de guardar

        $rutaImagen = $this->imagen->storeAs('public/anular',$nombreArchivo);

        //$rutaImagen = $this->imagen->storeAs('anular', $nombreArchivo, 'public'); // Guardar iamgen en carpeta anular 
        // Crear la solicitud de anulación
        $solicitudAnulacion = Anulacion::create([
            'motivo' => $this->motivo,
        ]);
        // Crear la entrada en la tabla de imágenes
        $imagen = Archivo::create([
            'nombre' => $nombreArchivo,
            'ruta' => $rutaImagen,
            'extension' => $this->imagen->getClientOriginalExtension(),
            'idDocReferenciado' => $solicitudAnulacion->id,
        ]);

        $this->emit("CustomAlert", ["titulo" => "Solicitud de anulación enviada", "mensaje" => "Su solicitud de anulación ha sido enviada con éxito.", "icono" => "success"]);
        $users = User::role(['administrador  '])->get();
        Notification::send($users, new NotificationsCreateSolicitud($solicitudAnulacion, $certificacion, Auth::user()));
        return redirect('Listado-Certificaciones');
    }

    public function solicitarEliminacion($certificationId)
    {
        $solicitudAnulacion = Eliminacion::create([
            
        ]);    
        $this->emit("CustomAlert", [
            "titulo" => "Solicitud de eliminación enviada",
            "mensaje" => "Su solicitud de eliminación ha sido enviada con éxito.",
            "icono" => "success",
        ]);
    
        // Crea una notificación
        $certificacion = Certificacion::find($certificationId);
        $users = User::role('administrador')->get();
        Notification::send($users, new SolicitudEliminacion( $solicitudAnulacion,$certificacion, Auth::user()));
        return redirect('Listado-Certificaciones');
        
    }

    
}

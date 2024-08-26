<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\Material;
use App\Models\User;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class NotificacionesPendientes extends Component
{
    public $user;
    public $notificacionesPendientes;
    protected $listeners = ['notificacionEliminada' => 'eliminarNotificacion'];


    public function mount()
    {
        $this->user = Auth::user();
        $this->notificacionesPendientes = $this->user->notifications->map(function ($notification) {
            $data = $notification->data;

            // Obtener nombre del inspector
            $nombreInspector = null;
            if (isset($data['idInspector'])) {
                $nombreInspector = User::find($data['idInspector'])->name;
            } elseif (isset($data['inspector'])) {
                $nombreInspector = $data['inspector'];
            }

            // Obtener placa
            $placa = null;
            if (isset($data['idServicio'])) {
                $certificacion = Certificacion::find($data['idServicio']);
                if ($certificacion) {
                    $placa = $certificacion->placa;
                }
            }

            // ontener # formato
            $numero = null;
            if (isset($data['idServicio'])) {
                $certificacion = Certificacion::find($data['idServicio']);

                if ($certificacion && $certificacion->Hoja) {
                    $numero = $certificacion->Hoja->numSerie;
                }
            }

            //obtener estado
            $estado = null;
            if (isset($data['idServicio'])) {
                $certificacion = Certificacion::find($data['idServicio']);
                if ($certificacion) {
                    $estado = $certificacion->estado;
                }
            }

            // Obtener material
            $material = [];
            if (isset($data['materiales'])) {
                // Aplanar el array de IDs de materiales
                $mateIds = array_column($data['materiales'], 'id');
                $materiales = Material::whereIn('id', $mateIds)->get();
                foreach ($materiales as $mate) {
                    $material[] = $mate->estado;
                }
            }


            // Asignar valores al objeto de notificación
            $notification->nombreInspector = $nombreInspector;
            $notification->placa = $placa;
            $notification->numero = $numero;
            $notification->estado = $estado;
            $notification->material = $material;
            return $notification;
        });
    }

    public function render()
    {
        return view('livewire.notificaciones-pendientes', [
            'notificacionesPendientes' => $this->notificacionesPendientes,
        ]);
    }

    public function verNotificacion($id)
    {
        $notification = $this->notificacionesPendientes->find($id);

        if ($notification) {
            $tipoNotificacion = $notification->type;
            $data = $notification->data;
            if ($tipoNotificacion === 'App\Notifications\AnulacionSolicitud') {
                $url = route('vistaSolicitudAnul', [
                    'anuId' => $data['idAnulacion'],
                    'cerId' => $data['idServicio'],
                    'userId' => $data['idInspector'],
                ]);
            } elseif ($tipoNotificacion === 'App\Notifications\SolicitudEliminacion') {
                $url = route('vistaSolicitudEli', [
                    'eliId' => $data['idEliminacion'],
                    'cerId' => $data['idServicio'],
                    'userId' => $data['idInspector'],
                ]);
            } elseif ($tipoNotificacion === 'App\Notifications\CreateSolicitud') {
                $url = route('vistaSolicitud', [
                    'soliId' => $data['idSoli'],
                ]);
            } elseif ($tipoNotificacion === 'App\Notifications\SolicitudDevolucion') {
                // Serializar los arrays antes de pasarlos a la URL
                $url = route('vistaDevolucion', [
                    'anuId' => json_encode(array_column($notification->data['anulaciones'], 'id')),
                    'matId' => json_encode(array_column($notification->data['materiales'], 'id')),
                    'userId' => $notification->data['idInspector'],
                ]);
            } else {
                $url = route('otraRuta');
            }
            return redirect($url);
        }
    }

    public function eliminarNotificacion($notificacionId)
    {
        // Eliminar directo de bd
        DB::table('notifications')->where('id', $notificacionId)->delete();
    }


    /*public function mount()
     {
        $this->user = Auth::user();
        //dd("Usuario autenticado:", $this->user);
        $this->cargarNotificaciones();
     }

     public function cargarNotificaciones()
     {
        // Verificamos si el usuario tiene el rol de inspector
        if ($this->user->hasRole('inspector')) {
            // Filtrar notificaciones para el inspector logueado
            $this->notificacionesPendientes = $this->filtrarNotificaciones();
        } else {
            // Si no es inspector, obtener notificaciones genéricas
            $this->notificacionesPendientes = $this->procesarNotificacionesGenericas($this->user->notifications);
        }
     }

     public function filtrarNotificaciones()
     {
        $userId = $this->user->id;

        // Obtener notificaciones del inspector, agrupando por el campo data (contenido JSON)
        // y filtrando por tipo de notificación (App\Notifications\AnulacionSolicitud)
        $notificacionesAgrupadas = DatabaseNotification::where('type', 'App\Notifications\AnulacionSolicitud')
            ->whereRaw('JSON_EXTRACT(data, "$.idInspector") = ?', [$userId])
            ->select(DB::raw('data, MIN(id) as id'))  // Seleccionamos una notificación por grupo basado en el campo `data`
            ->groupBy('data')  // Agrupamos por el contenido JSON del campo `data`
            ->get();

        // Procesar las notificaciones agrupadas
        return $notificacionesAgrupadas->map(function ($notification) {
            $notificacionCompleta = DatabaseNotification::find($notification->id);  // Obtenemos la notificación completa
            return $this->procesarNotificacion($notificacionCompleta);
        });
     }

     public function procesarNotificacionesGenericas($notificaciones)
     {
        return $notificaciones->map(function ($notification) {
            return $this->procesarNotificacion($notification);
        });
     }

     public function procesarNotificacion($notification)
     {
        $data = $notification->data;

        // Verificar si existe 'idInspector' antes de intentar acceder a él
        $nombreInspector = null;
        if (isset($data['idInspector'])) {
            $nombreInspector = User::find($data['idInspector'])->name ?? null;
        } elseif (isset($data['inspector'])) {
            // Si 'idInspector' no está presente, buscar en 'inspector' (otro posible campo)
            $nombreInspector = $data['inspector'];
        }

        // Verificar si existe 'idServicio' antes de intentar acceder a la certificación
        $placa = null;
        $numero = null;
        $estado = null;
        if (isset($data['idServicio'])) {
            $certificacion = Certificacion::find($data['idServicio']);
            if ($certificacion) {
                $placa = $certificacion->placa;
                $numero = $certificacion->Hoja->numSerie ?? null;
                $estado = $certificacion->estado;
            }
        }

        // Asignar valores procesados a la notificación
        $notification->nombreInspector = $nombreInspector;
        $notification->placa = $placa;
        $notification->numero = $numero;
        $notification->estado = $estado;

        return $notification;
     }

     public function RutaVistaAnulacion($id)
     {
        return redirect()->route('generaPdfSolicitudAnulacion', ['id' => $id]);
     }
    */
}

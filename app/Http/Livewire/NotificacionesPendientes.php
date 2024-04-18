<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\User;
use Illuminate\Notifications\Events\NotificationSent;
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
            $numero = null;

            if (isset($data['idServicio'])) {
                $certificacion = Certificacion::find($data['idServicio']);

                if ($certificacion && $certificacion->Hoja) {
                    $numero = $certificacion->Hoja->numSerie;
                }
            }
            // Asignar valores al objeto de notificación
            $notification->nombreInspector = $nombreInspector;
            $notification->placa = $placa;
            $notification->numero = $numero;
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
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class AnulacionController extends Controller
{
    
    public function marcarAnulacion($idNotificacion) {
        $notification = Auth()->user()->notifications->find($idNotificacion);
    
        if ($notification && isset($notification->data['idAnulacion'])) {
            $anuId = $notification->data['idAnulacion'];
            $idUsuario = $notification->data['idInspector'];
            $idServicio = $notification->data['idServicio'];
    
            /*Auth()->user()->unreadNotifications->when($idNotificacion, function ($query) use ($idNotificacion) {
                return $query->where('id', $idNotificacion);
            })->markAsRead();*/

            // Obtener todos los IDs de los administradores
            $adminUsers = User::role('administrador')->pluck('id');

            // Obtener todas las notificaciones relacionadas con la solicitud de anulación
            $notificationsToMark = DatabaseNotification::whereIn('notifiable_id', $adminUsers)
                ->where('data->idAnulacion', $anuId)
                ->get();

            // Marcar todas las notificaciones como leídas
            foreach ($notificationsToMark as $notification) {
                $notification->markAsRead();
            }

            return redirect()->route('vistaSolicitudAnul', ['anuId' => $anuId, 'cerId' => $idServicio, 'userId'=>$idUsuario] );
        }
    }


    public function marcarTodasLasNotificaciones(){
        Auth()->user()->unreadNotifications->markAsRead();
        redirect()->route('anulacion'); //return
    }
}
